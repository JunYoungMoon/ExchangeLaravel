<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 로그인 하지 않은 사용자는 글작성 화면을 볼 수없다.
     */
    public function test_create_view(): void
    {
        $response = $this->get(route('articles.create'));
        $response->assertStatus(302)->assertRedirectToRoute('login');
    }

    /**
     * 로그인 사용자만 글작성을 할수 있다.
     */
    public function test_create_api(): void
    {
        // database/factories/UserFactory.php > factory는 가짜 데이터를 만들어준다.
        $user = User::factory()->create();

        $testData = [
            'body' => 'test article'
        ];

        //actingAs로 로그인상태 추가
        $response = $this->actingAs($user)
            ->post(
                route('api.articles.create'),
                $testData
            );

        //$response->assertSuccessful();
        //응답이 redirect이기 때문에 200이 아닌 302로 검증
        $response->assertRedirect(route('articles.index'));

        //DB에 올바르게 저장되어 있는지 체크
        $this->assertDatabaseHas('articles', $testData);
    }

    /**
     * 로그인 하지 않은 사용자는 글작성을 할수 있다.
     */
    public function test_not_create_api(): void
    {
        $testData = [
            'body' => 'test article'
        ];

        //actingAs로 로그인상태 추가
        $response = $this
            ->post(
                route('api.articles.create'),
                $testData
            );

        //$response->assertSuccessful();
        //응답이 redirect이기 때문에 200이 아닌 302로 검증
        $response->assertRedirectToRoute('login');

        //DB에 올바르게 저장되어 있는지 체크
        $this->assertDatabaseMissing('articles', $testData);
    }

    /**
     * 글목록을 확인 할수 있다.
     */
    public function test_list_api(): void
    {
        // 5개의 게시글을 생성하되, 가장 최신 게시글부터 생성하도록 함
        $articles = Article::factory()->count(5)->create()->sortByDesc('created_at')->values();

        $response = $this->post(route('api.articles.list'));

        // 응답 결과 확인
        $response->assertStatus(200);

        // 응답 구조 확인
        $response->assertJsonStructure([
            'articles' => [
                '*' => ['id', 'body', 'user_id', 'created_at', 'user'],
            ],
            'totalCount',
            'page',
            'perPage',
        ]);

        $response->assertJson([
            'totalCount' => 5,
            'page' => 1,
            'perPage' => 2,
        ]);

        // API 응답에서 perPage가 2개이기 때문에 'articles' 배열의 요소 개수가 2개인지 확인
        $response->assertJsonCount(2, 'articles');

        // API 응답을 JSON 형식으로 디코딩하고, 그 결과에서 'articles' 키의 값(게시글 목록)을 가져옴
        $responseData = $response->json();
        $responseArticles = $responseData['articles'];

        // 생성된 게시글 중에서 가장 최신의 2개의 ID를 가져와서 비교
        $expectedIds = $articles->take(2)->pluck('id')->toArray();
        $actualIds = collect($responseArticles)->pluck('id')->toArray();

        // 기대되는 ID 목록과 실제 응답의 ID 목록을 비교
        $this->assertEquals($expectedIds, $actualIds);
    }


    /**
     * 글상세 화면을 볼 수있다.
     */
    public function test_detail_view(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.detail', ['article' => $article]))
            ->assertSuccessful()
            ->assertSee($article->body);
    }

    /**
     * 로그인한 사용자만 글수정 화면을 볼 수있다.
     */
    public function test_edit_view(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('articles.edit', ['article' => $article]))
            ->assertSuccessful()
            ->assertSee($article->body);
    }

    /**
     * 로그인 하지 않은 사용자는 글수정 화면을 볼 수없다.
     */
    public function test_not_edit_view(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.edit', ['article' => $article]))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    /**
     * 로그인한 사용자는 글수정 할수 있다.
     */
    public function test_edit_api(): void
    {

        $user = User::factory()->create();

        $payload = ['body' => '수정된 글'];
        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->patch(
                route('api.articles.update',
                    [
                        'article' => $article->id
                    ]
                ),
                $payload
            )->assertRedirect(route('articles.index'));

        // DB 비교 방식1
        $this->assertDatabaseHas('articles', $payload);

        // DB 비교 방식2
        $this->assertEquals($payload['body'], $article->refresh()->body);
    }

    /**
     * 로그인하지 않은 사용자는 글수정 할수 없다.
     */
    public function test_not_edit_api(): void
    {
        $payload = ['body' => '수정된 글'];
        $article = Article::factory()->create();

        $this->patch(
            route('api.articles.update',
                [
                    'article' => $article->id
                ]
            ),
            $payload
        )->assertRedirectToRoute('login');

        // DB 비교 방식1
        $this->assertDatabaseMissing('articles', $payload);

        // DB 비교 방식2
        $this->assertNotEquals($payload['body'], $article->refresh()->body);
    }

    /**
     * 로그인한 사용자는 글삭제 할수 있다.
     */
    public function test_delete_api(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(
                route('api.articles.delete',
                    [
                        'article' => $article->id
                    ]
                )
            )->assertSee('delete');

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    /**
     * 로그인한 사용자는 글삭제 할수 있다.
     */
    public function test_not_delete_api(): void
    {
        $article = Article::factory()->create();

        $this->delete(
            route('api.articles.delete',
                [
                    'article' => $article->id
                ]
            )
        )->assertRedirectToRoute('login');

        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }
}
