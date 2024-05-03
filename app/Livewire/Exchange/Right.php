<?php

namespace App\Livewire\Exchange;

use App\Models\MemberCoinFavor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Right extends Component
{
    public $originalCoins;
    public $copiedCoins;
    public $favors;
    public $holds;
    public $search;
    public $tab = 'KRW';
    public $sortField;
    public $sortDirection = 'asc';
    public $exchangeAddress;

    public function mount($originalCoins, $exchangeAddress)
    {
        $this->exchangeAddress = $exchangeAddress;
        $this->originalCoins = $originalCoins;

        if (Auth::check()) {
            $this->loadUserPreferences();
        }

        $this->copiedCoins = $this->originalCoins;
    }

    /**
     * 사용자일때 기본 설정 세팅
     */
    public function loadUserPreferences()
    {
        $this->getHold();
        $this->getFavor();

        if ($this->favors) {
            $this->markFavoredCoins();
        }
    }

    /**
     * 보유 코인 리스트 정보를 가져온다 ['EGX', 'BOSS', ...]
     */
    public function getHold()
    {
        //보유 코인 가져오기
        $userId = Auth::id();

        $user = User::find($userId);

        $uniqueCoins = [];

        foreach ($this->originalCoins as $coin) {
            $coinName = strtolower($coin['coin_name']);

            // 해당 컬럼이 존재하고, 보유한게 있는지 체크한다.
            if (isset($user->{$coinName . '_available'}) && isset($user->{$coinName . '_using'}) &&
                ($user->{$coinName . '_available'} > 0 || $user->{$coinName . '_using'} > 0)) {
                // 중복이 없는 코인 이름을 배열에 추가한다.
                if (!in_array($coinName, $uniqueCoins)) {
                    $uniqueCoins[] = $coinName;
                }
            }
        }

        // 중복이 없는 코인 이름이 저장된 배열을 $this->hold_list에 할당한다.
        $this->holds = collect($uniqueCoins);
    }

    /**
     * 관심 코인 리스트 정보를 가져온다 ['KRW_EGX', 'KRW_BOSS', ...]
     */
    public function getFavor()
    {
        //관심 코인 가져오기
        $userId = Auth::id();

        // 로그인한 사용자의 id로 관심 코인정보를 가져온다.
        $this->favors = MemberCoinFavor::where('user_id', $userId)->pluck('symbol')->map(function ($favor) {
            return strtolower($favor);
        });
    }

    /**
     * 관심 코인 리스트 정보와 코인 정보가 일치할때 마킹을 한다.
     */
    public function markFavoredCoins()
    {
        foreach ($this->originalCoins as &$coin) {
            $coin['is_favor'] = $this->favors->contains(strtolower($coin['type2'] . '_' . $coin['type'])) ? 'on' : 'off';
        }
    }

    /**
     * 탭이 변경될때 동작
     */
    public function changeTab($tab)
    {
        $this->tab = $tab;
        $this->applyFilters();
    }

    /**
     * tab,search에 따라 필터를 적용
     */
    public function applyFilters()
    {
        switch ($this->tab) {
            case 'KRW':
                $this->copiedCoins = $this->originalCoins;
                $this->filterSearch();
                break;
            case 'HOLD':
                if (Auth::check()) {
                    $this->copiedCoins = $this->originalCoins;
                    $this->getHold();
                    $this->filterSearch();

                    $this->copiedCoins = collect($this->copiedCoins)->filter(function ($coin) {
                        return collect($this->holds)->contains(strtolower($coin['type']));
                    })->all();
                }
                break;
            case 'FAVOR':
                if (Auth::check()) {
                    $this->copiedCoins = $this->originalCoins;
                    $this->getFavor();
                    $this->filterSearch();

                    $this->copiedCoins = collect($this->copiedCoins)->filter(function ($coin) {
                        return collect($this->favors)->contains(strtolower($coin['type2'] . "_" . $coin['type']));
                    })->all();
                }
                break;
        }
    }

    /**
     * 검색 필터 기능
     */
    public function filterSearch()
    {
        if ($this->search) {
            $this->copiedCoins = collect($this->copiedCoins)->filter(function ($coin) {
                // 검색어를 소문자로 변환하여 일치 여부를 검사
                $search = strtolower($this->search);

                // $coin['ccs_coin_name'] 또는 $coin['coin_name'] 중 하나라도 검색어를 포함하는지 확인
                return str_contains(strtolower($coin['ccs_coin_name']), $search) ||
                    str_contains(strtolower($coin['coin_name']), $search);
            })->all();
        }
    }

    /**
     * 토큰명/심볼 검색 기능
     * search변수와 매핑되어 있다.
     */
    public function updatedSearch()
    {
        $this->applyFilters();
    }

    /**
     * 정렬기능
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;

        $this->copiedCoins = collect($this->copiedCoins)->sortBy([
            [$field, $this->sortDirection]
        ])->values()->all();
    }

    /**
     * 좋아요 추가
     */
    public function addFavor($symbol)
    {
        if (Auth::check()) {
            $userId = Auth::id();

            $results = MemberCoinFavor::where('user_id', $userId)
                ->where('symbol', $symbol)
                ->get();

            if ($results->isNotEmpty()) {
                $results->each(function ($result) {
                    $result->delete();
                });
            } else {
                MemberCoinFavor::create([
                    'user_id' => $userId,
                    'symbol' => $symbol,
                ]);
            }

            $this->getFavor();
            $this->markFavoredCoins();
            $this->applyFilters();
        } else {
            $this->dispatch('modal',['msg'=>'로그인을 해주세요.']);
        }
    }

    public function render()
    {
        return view('exchange.right');
    }
}
