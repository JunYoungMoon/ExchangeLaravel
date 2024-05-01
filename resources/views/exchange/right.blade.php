<div class="rgh">
    {{--5.코인 리스트--}}
    <div class="box_dashboard ty5" x-data="{ tab : $wire.entangle('tab')}">
        <div class="tit inp">
            <input type="search" id="search_input" class="inp_txt" placeholder="토큰명/심볼검색"
                   wire:model.live.debounce.800ms="search">
            <button type="button" class="btn_sch"><span class="ico_sch">검색</span></button>
        </div>
        <div class="mtit view-m">
            <h2 class="title">토큰검색</h2>
            <button type="button" class="btn_p_cloes"><span>닫기</span></button>
        </div>
        <div id="tit_tab3" class="tit tab ty5">
            <ul>
                <li><a :class="tab === 'KRW' ? 'active' : ''" class="nav-link" wire:click="changeTab('KRW')"><span>원화</span></a></li>
                <li><a :class="tab === 'HOLD' ? 'active' : ''" class="nav-link" wire:click="changeTab('HOLD')"><span>보유</span></a></li>
                <li><a :class="tab === 'FAVOR' ? 'active' : ''" class="nav-link" wire:click="changeTab('FAVOR')"><span>관심</span></a></li>
            </ul>
        </div>
        <div class="cont">
            <div class="tbl_basic">
                <table class="list tbody_list">
                    <colgroup>
                        <col class="w140">
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>
                            <a wire:click="sortBy('ccs_coin_name')">토큰명
                            <img src="/images/ico_arrow.png" alt="" style="height:12px;"/>
                            </a>
                        </th>
                        <th>
                            <a wire:click="sortBy('last_price')">현재가
                            <img src="/images/ico_arrow.png" alt="" style="height:12px;"/>
                            </a>
                        </th>
                        <th>
                            <a wire:click="sortBy('percent')">전일대비
                            <img src="/images/ico_arrow.png" alt="" style="height:12px;"/>
                            </a>
                        </th>
                        <th>
                            <a wire:click="sortBy('value')">거래대금
                            <img src="/images/ico_arrow.png" alt="" style="height:12px;"/>
                            </a>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="tbl_basic scrollY">
                @if($copiedCoins)
                    <table class="list">
                        <colgroup>
                            <col class="w140">
                            <col>
                            <col>
                            <col>
                        </colgroup>
                        <div wire:loading wire:target.except="addFavor">Data Loading....</div>
                        <tbody class="coin_list" x-data="{ copiedCoins: $wire.entangle('copiedCoins')}">
                        @auth
                            <template x-for="coin in copiedCoins">
                                <tr :class="(coin.type2 + '_' +coin.type).toUpperCase()">
                                    <td class="tx_left">
                                        <button wire:click="addFavor(coin.type2 + '_' +coin.type)" :class="'ico_star ' + coin.is_favor" type="button"><span>관심</span></button>
                                        <p class="coin_name">
                                            <a wire:click="$dispatch('emitCoinInfo', { market : coin.type2.toUpperCase(), coin : coin.type.toUpperCase()});">
                                                <span class="name" x-text="coin.ccs_coin_name"></span>
                                                <span class="stext" x-text="coin.type.toUpperCase() + '/' + coin.type2.toUpperCase()"></span>
                                            </a>
                                        </p>
                                    </td>
                                    <td :class="'c-' + coin.percent_color_code" x-text="parseInt(coin.last_price).toLocaleString()"></td>
                                    <td :class="'ta-r c-' + coin.percent_color_code"
                                        x-html="coin.percent_string + coin.percent + '%' + '<br>' + (coin.last_price - coin.yesterday_price).toLocaleString()"></td>
                                    <td x-text="coin.transaction_amount"></td>
                                </tr>
                            </template>
                        @endauth

                        @guest
                            @if($tab === 'KRW')
                                <template x-for="coin in copiedCoins">
                                    <tr :class="(coin.type2 + '_' +coin.type).toUpperCase()">
                                        <td class="tx_left">
                                            <button wire:click="addFavor(coin.type2 + '_' +coin.type)" :class="'ico_star ' + (coin.is_favor ? 'on' : 'off')" type="button"><span>관심</span></button>
                                            <p class="coin_name">
                                                <a wire:click="$dispatch('emitCoinInfo', { market : coin.type2.toUpperCase(), coin : coin.type.toUpperCase()});">
                                                    <span class="name" x-text="coin.ccs_coin_name"></span>
                                                    <span class="stext" x-text="coin.type.toUpperCase() + '/' + coin.type2.toUpperCase()"></span>
                                                </a>
                                            </p>
                                        </td>
                                        <td :class="'c-' + coin.percent_color_code" x-text="parseInt(coin.last_price).toLocaleString()"></td>
                                        <td :class="'ta-r c-' + coin.percent_color_code"
                                            x-html="coin.percent_string + coin.percent + '%' + '<br>' + (coin.last_price - coin.yesterday_price).toLocaleString()"></td>
                                        <td x-text="coin.transaction_amount"></td>
                                    </tr>
                                </template>
                            @else
                                <div><a href="{{route('login')}}">로그인이 필요합니다.</a></div>
                            @endif
                        @endguest
                        </tbody>
                    </table>
                @else
                    <div>데이터가 존재하지 않습니다.</div>
                @endif
            </div>
{{--            <button type="button" id="test">aaaa</button>--}}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>

@script
<script>
    Livewire.on('modal', function (data) {
        alert(data[0].msg);
    });

    {{--let connect = io.connect('{{$testAddress}}');--}}

    {{--$('#test').on('click',function () {--}}
    {{--    connect.emit('test');--}}
    {{--});--}}

    {{--connect.on('test2', function (data) {--}}
    {{--    $wire.copiedCoins['KRW_EGX'].ccs_coin_name = data;--}}
    {{--    $wire.copiedCoins['KRW_EGX'].ccs_coin_name = data;--}}

    {{--    console.log($wire.copiedCoins['KRW_EGX'].ccs_coin_name);--}}
    {{--});--}}
</script>
@endscript
