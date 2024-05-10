<div class="lghWarp">
    <div class="lft"
         x-data="{ coin : $wire.entangle('coin'), market : $wire.entangle('market'), coinInfo : $wire.entangle('coinInfo')}">
        {{--고가/저가--}}
        <div class="box_dashboard ty1 market_header" x-data="{ tab1 : 'price' }">
            <div id="tit_tab11">
                <div class="market_header_topar">
                    <div class="new_ex_top">
                        <div class="new_ex_top_left">
                            <div class="h1">
                                <em>
                                    <img :alt="coinInfo.ccs_coin_name" :src="'/uploads/' + coinInfo.code + '.png'">
                                </em>
                                <span x-text="coinInfo.ccs_coin_name"></span>
                                <span x-text="coin + ' / ' + market"></span>
                            </div>
                        </div>
                        <div class="tab_top_ar">
                            <ul>
                                <li :class="(tab1 === 'price') ? 'on' : ''"><a x-on:click="tab1 = 'price'"
                                                                               class="nav-link active">시세</a></li>
                                <li :class="(tab1 === 'info') ? 'on' : ''"><a x-on:click="tab1 = 'info'"
                                                                              class="nav-link active">정보</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{--1-1. 토큰 시세 영역--}}
                <div x-show="tab1 === 'price'" id="token_price" class="mkheader_token">
                    <div class="token_price_box">
                        <div class="token_price_box_left">
                            <div class="nex_price_ar">
                                <p class="t1">
                                    <strong class="price"></strong> {{$market}}
                                </p>
                                <p class="t2">
                                    {{--<span class="c-black">전일대비</span>--}}
                                    <strong class="percent"></strong>&percnt; <span>&sol;</span><strong
                                        class="cpd updown"></strong>
                                </p>
                            </div>
                            <div class="nex_price_more">
                                <p>고가<span class="max t3"></span></p>
                                <p>저가<span class="min t4"></span></p>
                                <p>거래량(24h) <span class="fz1"></span> <span x-text="coin"></span></p>
                                <p>거래대금(24h) <span class="value"></span> {{$market}} </p>
                            </div>
                        </div>
                        {{--미니차트 영역--}}
                        <div id="minichart"></div>
                    </div>
                    {{--2.차트부분--}}
                    <div class="box_dashboard ty2">
                        <div class="container center graph" id="chartContainer">
                        </div>
                    </div>
                </div>
                {{--1-2.토큰 정보 영역--}}
                <div x-show="tab1 === 'info'" id="token_info" class="mkheader_token_info">
                    <div class="tokenInfo01">
                        <div class="tokeninfo_tit" x-text="coinInfo.ccs_coin_name"></div>
                        <div class="tokeninfo_top ">
                            <p>
                                <img
                                    :src="'/uploads/' + ((coinInfo.detail?.ccsd_image) ? coinInfo.detail?.ccsd_image : '/img/token_no_image.svg')"
                                    x-on:click="window.open(this.src)">
                            </p>
                            <div class="tokeninfo_cont_ar">
                                <h4 class="tokeninfo_h4">상세설명</h4>
                                <div class="tokeninfo_cont" x-text="coinInfo.detail?.ccsd_explan"></div>
                            </div>
                        </div>
                        <div class="tokeninfo_ar">
                            <h4 class="tokeninfo_h4">모금정보</h4>
                            <div class="tokeninfo_normal">
                                <table class="tokeninfo_table">
                                    <colgroup>
                                        <col width="15%">
                                        <col width="35%">
                                        <col width="15%">
                                        <col width="35%">
                                    </colgroup>
                                    <tr>
                                        <th>총 레이즈</th>
                                        <td x-text="(coinInfo.detail?.ccsd_total_raise) ?? '-'"></td>
                                        <th>소프트캡</th>
                                        <td x-text="(coinInfo.detail?.ccsd_soft_cap) ?? '-'"></td>
                                    </tr>
                                    <tr>
                                        <th>레이즈상태</th>
                                        <td x-text="(coinInfo.detail?.ccsd_total_raise) ?? '-'"></td>
                                        <th>최소 투자</th>
                                        <td x-text="(coinInfo.detail?.ccsd_mini_invest) ?? '-'"></td>
                                    </tr>
                                    <tr>
                                        <th>승인된 투자자</th>
                                        <td x-text="(coinInfo.detail?.ccsd_approve_invest) ?? '-'"></td>
                                        <th>보안 유형</th>
                                        <td x-text="(coinInfo.detail?.ccsd_sec_type) ?? '-'"></td>
                                    </tr>
                                    <tr>
                                        <th>면제</th>
                                        <td x-text="(coinInfo.detail?.ccsd_exemption) ?? '-'"></td>
                                        <th>기구</th>
                                        <td x-text="(coinInfo.detail?.ccsd_organization) ?? '-'"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tokeninfo_ar">
                            <h4 class="tokeninfo_h4">토큰정보</h4>
                            <div class="tokeninfo_normal">
                                <table class="tokeninfo_table">
                                    <colgroup>
                                        <col width="15%">
                                        <col width="35%">
                                        <col width="15%">
                                        <col width="35%">
                                    </colgroup>
                                    <tr>
                                        <th>가격({{$coin}}</th>
                                        <td colspan="3"
                                            x-html="coinInfo.detail?.ccsd_token_price + '(<span class=\'t1 cpd\'>▼ 178,000</span>)'"></td>
                                    </tr>
                                    <tr>
                                        <th>토큰 발행처</th>
                                        <td x-text="(coinInfo.detail?.ccsd_token_issuer) ?? '-'"></td>
                                        <th>토큰 프로토콜</th>
                                        <td x-text="(coinInfo.detail?.ccsd_token_protocol) ?? '-'"></td>
                                    </tr>
                                    <tr>
                                        <th>토큰 발행 정보</th>
                                        <td x-text="(coinInfo.detail?.ccsd_token_issuer_info) ?? '-'"></td>
                                        <th>결제 옵션</th>
                                        <td x-text="(coinInfo.detail?.ccsd_payment_option) ?? '-'"></td>
                                    </tr>
                                    <tr>
                                        <th>토큰 권리</th>
                                        <td colspan="3" x-text="(coinInfo.detail?.ccsd_token_rights) ?? '-'"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--상세 영역--}}
        <div class="exLeft">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

                {{--호가창/최근 체결가 오더북--}}
                <div class="container bns_list">

                    <div id="tit_tab5" class="extab_tit99">
                        <ul>
                            <li>일반 호가</li>
                        </ul>
                    </div>

                    <div class="tab-content exHoga_ht">
                        <div id="tabTable1_1" class="tabTable1_1_n">
                            {{--매도 테이블--}}
                            <div class="hoga_sell">
                                {{--우측 코인정보--}}
                                <div class="hoga_sell_box">
                                    <div>
                                        <dl class="hoga_dl_tit">
                                            <dt>
                                                <em>
                                                    <a href="#" onclick="openLayerPopup('popInfo01');">
                                                        {{--                                                        <img alt="<?= $coinInfo->ccs_coin_name ?>"--}}
                                                        {{--                                                             src="<?= $protocol ?><?= $_SERVER['HTTP_HOST'] ?>/uploads/<?= strtoupper($code); ?>.png">--}}
                                                    </a>
                                                </em>코인명
                                                <span x-text="coin + ' / ' + market"></span>
                                            </dt>
                                            <dd></dd>
                                        </dl>
                                        <dl class="hoga_dl_price">
                                            <dt class="t1">
                                                <strong class="price"></strong> {{$market}}
                                            </dt>
                                            <dd>
                                                <span>전일대비</span>
                                                <strong class="t2 percent"></strong>
                                            </dd>
                                        </dl>
                                        <dl class="hoga_dl">
                                            <dt>거래량</dt>
                                            <dd><span class="fz1"></span> <span>{{$coin}}</span></dd>
                                        </dl>
                                        <dl class="hoga_dl">
                                            <dt>거래대금</dt>
                                            <dd><span class="value"></span> <span>{{$market}}</span>
                                            </dd>
                                        </dl>
                                        <p class="hoga_notice_right bot_line00">(최근24시간)</p>
                                        <dl class="hoga_dl">
                                            <dt>고가</dt>
                                            <dd><p class="c-up max"></p></dd>
                                        </dl>
                                        <dl class="hoga_dl">
                                            <dt>저가</dt>
                                            <dd><p class="c-down min"></p></dd>
                                        </dl>
                                    </div>
                                </div>
                                {{--매도 물량--}}
                                <table class="hogalist sell_tbb">
                                    <colgroup>
                                        <col style="width:10%;">
                                        <col style="width:23%;">
                                        <col style="width:34%; min-width:160px;">
                                        <col style="width:23%;">
                                        <col style="width:10%;">
                                    </colgroup>
                                    <tbody class="sell_hoga" x-data="sellHoga">
                                    <template x-for="_data in data" :key="_data.quantity">
                                        <tr class="down" style="cursor: pointer" x-on:click="setPriceValue">
                                            <td></td>
                                            <td>
                                                <div class="sell_gr"
                                                     x-bind:style="'width:' + (_data.quantity / max * 100) + '%'"></div>
                                                <p x-text="_data.quantity.toFixed(4)"></p>
                                            </td>
                                            <td :class="parseFloat(_data.hoga_price) === parseFloat(last_price) ? 'hoga_black' : '' ">
                                                <div class="hoga_div">
                                                    <ul x-bind:class="'c-' + _data.percent_color_code">
                                                        <li class="ftbd"
                                                            x-text="Number(_data.hoga_price).toLocaleString()"></li>
                                                        <li class="hoga_div_sma" x-text="_data.percent + '%'"></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                            {{--매수 테이블--}}
                            <div class="hoga_buy">
                                {{--체결가 체결량--}}
                                <div class="hoga_buy_box">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>체결가</th>
                                            <th>체결량</th>
                                        </tr>
                                        </thead>
                                        <tbody class="hoga_buy_box_list" x-data="buyHogaDetail">
                                        <template x-for="_data in data">
                                            <tr>
                                                <td :class="'c-' + _data.updown"
                                                    x-text="Number(_data.price).toLocaleString()"></td>
                                                <td>
                                                    <span :class="'c-' + _data.updown"
                                                          x-text="Number(_data.amount).toLocaleString()"></span>
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                                {{--매수 물량--}}
                                <table class="hogalist buy_tbb">
                                    <colgroup>
                                        <col style="width:10%;">
                                        <col style="width:23%;">
                                        <col style="width:34%; min-width:160px;">
                                        <col style="width:23%;">
                                        <col style="width:10%;">
                                    </colgroup>
                                    <tbody class="buy_hoga" x-data="buyHoga">
                                    <template x-for="_data in data" :key="_data.quantity">
                                        <tr class="up" style="cursor: pointer" x-on:click="setPriceValue">
                                            <td></td>
                                            <td></td>
                                            <td :class="parseFloat(_data.hoga_price) === parseFloat(last_price) ? 'hoga_black' : ''">
                                                <div class="hoga_div">
                                                    <ul x-bind:class="'c-' + _data.percent_color_code">
                                                        <li class="ftbd"
                                                            x-text="Number(_data.hoga_price).toLocaleString()"></li>
                                                        <li class="hoga_div_sma" x-text="_data.percent + '%'"></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="txal_left">
                                                <div class="buy_gr"
                                                     x-bind:style="'width:' + (_data.quantity / max * 100) + '%'"></div>
                                                <p x-text="_data.quantity.toFixed(4)"></p>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{--호가창/최근 체결가--}}
            </div>
        </div>

        <div class="exCenter" x-data="{ tab2 : 'buy' }">
            {{--4.매수/매도--}}
            <div class="box_dashboard ty4">
                <div id="tit_tab2" class="extab_tit">
                    <ul>
                        <li :class="(tab2 === 'buy') ? 'on' : ''"><a class="nav-link" x-on:click="tab2 = 'buy'"><span>{{$coin}} 매수</span></a>
                        </li>
                        <li :class="(tab2 === 'sell') ? 'on' : ''"><a class="nav-link" x-on:click="tab2 = 'sell'"><span>{{$coin}} 매도</span></a>
                        </li>
                    </ul>
                </div>
                <div id="ttab2_1" class="extab_cont" x-show="tab2 === 'buy'">
                    <div class="cont">
                        <ul>
                            <li>
                                <p class="h">주문형태</p>
                                <div id="tit_tab2_1" class="tab">
                                    <ul>
                                        <li onclick="submitmode=1;set_fee();maxvalue();$('.buy_price').val(0);">
                                            <a onclick="submitmode=1;set_fee();maxvalue();$('.buy_price').val(0);">
                                                <span>지정가</span>
                                            </a>
                                        </li>
                                        <li onclick="submitmode=2;set_fee();maxvalue();$('.buy_price').val(now_price);">
                                            <a onclick="submitmode=2;set_fee();maxvalue();$('.buy_price').val(now_price);">
                                                <span>시장가</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <p class="h">주문가능</p>
                                <div class="">
                                    <p><span class="available_buy_price spstst">0</span> {{$market}}</p>
                                    {{--<button type="button" class="btn-pk red2 s bdrs fl-r"><span class="ico_i">상승장 렌딩</span></button>--}}
                                </div>
                            </li>
                            <li>
                                <p class="h">주문가격</p>
                                <div class="">
                                    <div class="inp_num">
                                        <input type="number" class="inp_txt w100p buy_price"
                                               onchange="set_fee();maxvalue();" x-ref="buy_price" id="buy_price">
                                        <button type="button" class="btn_top"
                                                onclick="priceupdown('buy','down');"><span
                                                class="ico">수량 더하기</span></button>
                                        <button type="button" class="btn_down"
                                                onclick="priceupdown('buy','up');"><span
                                                class="ico">수량 빼기</span></button>
                                    </div>
                                    <p class="fz1 ta-r">최대 주문 가능 수량 <span class="c-black"
                                                                          id="max_v">0.0000</span></p>
                                </div>
                            </li>
                            <li>
                                <p class="h">주문수량</p>
                                <div class="">
                                    <div class="box-f" style="display:block">
                                        <div class="b">
                                            <input type="text" class="inp_txt buy_qtt"
                                                   placeholder="최소 = 0.0001{{$coin}}(500{{$market}}이상) "
                                                   onchange="setTotalPriceAndFee()" x-ref="buy_qtt" id="buy_qtt">
                                            <span>{{$coin}}</span>
                                        </div>
                                    </div>
                                    <div class="box-t">
                                        <ul>
                                            <li class="on"><a href="#"
                                                              onclick="percent_func('buy', this);">10%</a></li>
                                            <li><a href="#" onclick="percent_func('buy', this);">25%</a></li>
                                            <li><a href="#" onclick="percent_func('buy', this);">50%</a></li>
                                            <li><a href="#" onclick="percent_func('buy', this);">100%</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="line-top">
                                <p class="h">주문금액</p>
                                <div class="">
                                    <p><span class="buy_total_sum">0</span>{{$market}}</p>
                                </div>
                            </li>
                            <li>
                                <p class="h">수수료
                                    <button type="button" onclick="openLayerPopup('popHelp01');"><span
                                            class="ico_q">도움말</span></button>
                                </p>
                                <div class="">
                                    <p><span class="buy_fee">0</span>{{$market}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="botm">
                        @auth
                            <ul>
                                <li>
                                    <a class="btn-pk b w100p red" wire:click="transaction($refs.buy_price.value, $refs.buy_qtt.value, 'buy')">
                                        <span>{{$coin}} 매수</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn-pk b2 gray3">
                                        <img src="/img/comm/icon_f5.svg">
                                    </a>
                                </li>
                            </ul>
                        @else
                            <a href="/login" class="btn-pk b w100p dkblue2">로그인</a>
                        @endauth
                    </div>
                </div>
                <div id="ttab2_2" class="extab_cont" x-show="tab2 === 'sell'">
                    <div class="cont">
                        <ul>
                            <li>
                                <p class="h">주문형태</p>
                                <div id="tit_tab2_2" class="tab">
                                    <ul>
                                        <li onclick="submitmode=1;set_fee();$('.sell_price').val(0);">
                                            <a href="#"
                                               onclick="submitmode=1;set_fee();$('.sell_price').val(0);">
                                                <span>지정가</span>
                                            </a>
                                        </li>
                                        <li onclick="submitmode=2;set_fee();$('.sell_price').val(now_price);">
                                            <a href="#"
                                               onclick="submitmode=2;set_fee();$('.sell_price').val(now_price);">
                                                <span>시장가</span>
                                            </a>
                                        </li>
                                        {{--<li onclick="submitmode=3;"><a href="#" onclick="submitmode=3;"><span>자동</span></a> <button type="button"><span class="ico_q">도움말</span></button></li> --}}
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <p class="h">주문가능</p>
                                <div class="">
                                    <p><span class="available_sell_price spstst">0</span>{{$coin}}</p>
                                    {{--<button type="button" class="btn-pk red2 s bdrs fl-r"><span class="ico_i">상승장 렌딩</span></button>--}}
                                </div>
                            </li>
                            <li>
                                <p class="h">주문가격</p>
                                <div class="">
                                    <div class="inp_num">
                                        <input type="number" class="inp_txt w100p sell_price"
                                               onchange="set_fee();" id="sell_price">
                                        <button type="button" class="btn_top"
                                                onclick="priceupdown('sell','down');"><span
                                                class="ico">수량 더하기</span></button>
                                        <button type="button" class="btn_down"
                                                onclick="priceupdown('sell','up');"><span
                                                class="ico">수량 빼기</span></button>
                                    </div>
                                    <p class="fz1 ta-r"><span class="c-black"></span></p>
                                </div>
                            </li>
                            <li>
                                <p class="h">주문수량</p>
                                <div class="">
                                    <div class="box-f" style="display: block">
                                        <div class="b">
                                            <input type="text" class="inp_txt sell_qtt w100p"
                                                   placeholder="최소 = 0.0001" onchange="set_fee();"
                                                   id="sell_qtt">
                                            <span>{{$coin}}</span>
                                        </div>
                                    </div>
                                    <div class="box-t">
                                        <ul>
                                            <li class="on"><a href="#"
                                                              onclick="percent_func('sell', this);">10%</a></li>
                                            <li><a href="#" onclick="percent_func('sell', this);">25%</a></li>
                                            <li><a href="#" onclick="percent_func('sell', this);">50%</a></li>
                                            <li><a href="#" onclick="percent_func('sell', this);">100%</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="line-top">
                                <p class="h">주문금액</p>
                                <div class="">
                                    <p>
                                        <span class="sell_total_sum">0</span>{{$market}}</p>
                                </div>
                            </li>
                            <li>
                                <p class="h">수수료
                                    <button type="button" onclick="openLayerPopup('popHelp02');"><span
                                            class="ico_q">도움말</span></button>
                                </p>
                                <div class="">
                                    <p><span class="sell_fee">0</span>{{$market}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="botm">
                        @auth
                            <ul>
                                <li>
                                    <a class="btn-pk b w100p blue" wire:click="transaction($refs.sell_price.value, $refs.sell_qtt.value, 'sell')">
                                        <span>{{$coin}} 매수</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn-pk b2 gray3">
                                        <img src="/img/comm/icon_f5.svg">
                                    </a>
                                </li>
                            </ul>
                        @else
                            <a href="/login" class="btn-pk b w100p dkblue2">로그인</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- 6.체결 리스트 -->
            <div class="box_dashboard ty6">
                <div id="tit_tab4" class="extab_tit01">
                    <ul>
                        <li class="on"><a class="nav-link active" href="#order_list1"><span>미체결 주문</span></a>
                        </li>
                        <li><a class="nav-link" href="#order_list2"><span>체결 주문</span></a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="cont" id="order_list1">
                        <div class="tbl_top">
                            <div class="lft">
                                <div class="tab-link">
                                    <ul>
                                        <li class="on"
                                            onclick="select_order_date = 1; order_out_updata2(order_list);"><a
                                                href="#"
                                                onclick="select_order_date = 1; order_out_updata2(order_list);">당일</a>
                                        </li>
                                        <li onclick="select_order_date = 2; order_out_updata2(order_list);"><a
                                                href="#"
                                                onclick="select_order_date = 2; order_out_updata2(order_list);">7일</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rgh">
                                <button onclick="getSelectedCancel()">선택 취소</button>
                                {{--<a href="#" class="a_link c-black">전체보기</a>--}}
                                <select class="select1"
                                        onchange="select_order_type = this.value; order_out_updata2(order_list);">
                                    <option value="전체">전체</option>
                                    <option value="매수">매수</option>
                                    <option value="매도">매도</option>
                                </select>
                            </div>
                        </div>
                        <div class="tbl_basic">
                            <table class="list">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th rowspan="2">체결일시</th>
                                    <th>자산</th>
                                    <th>체결수량</th>
                                    <th>체결가격</th>
                                    <th rowspan="2">주문일시</th>
                                </tr>
                                <tr>
                                    <th>구분</th>
                                    <th>주문가격</th>
                                    <th>체결금액</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="scrollY tbl_basic mbtn_ty1">
                            <table class="list">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <tbody class="notexch_box">

                                <tr>
                                    <td colspan="5" class="notx tb_td_ctt">거래 내역이 없습니다.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cont" id="order_list2">
                        <div class="tbl_top">
                            <div class="lft">
                                <div class="tab-link">
                                    <ul>
                                        <li class="on"
                                            onclick="select_order_date2 = 1; order_updata2(order_list2);"><a
                                                href="#"
                                                onclick="select_order_date2 = 1; order_updata2(order_list2);">당일</a>
                                        </li>
                                        <li onclick="select_order_date2 = 2; order_updata2(order_list2);"><a
                                                href="#"
                                                onclick="select_order_date2 = 2; order_updata2(order_list2);">7일</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rgh">
                                {{--<a href="#" class="a_link c-black">전체보기</a>--}}
                                <select class="select1"
                                        onchange="select_order_type2 = this.value; order_updata2(order_list2);">
                                    <option value="전체">전체</option>
                                    <option value="매수">매수</option>
                                    <option value="매도">매도</option>
                                </select>
                            </div>
                        </div>
                        <div class="tbl_basic">
                            <table class="list">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th rowspan="2">체결일시</th>
                                    <th>자산</th>
                                    <th>체결수량</th>
                                    <th>체결가격</th>
                                    <th rowspan="2">주문일시</th>
                                </tr>
                                <tr>
                                    <th>구분</th>
                                    <th>주문가격</th>
                                    <th>체결금액</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="scrollY tbl_basic mbtn_ty1">
                            <table class="list">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>

                                <tbody class="order_updata_list">

                                <tr>
                                    <td colspan="5" class="notx tb_td_ctt">거래 내역이 없습니다.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--3.체결/일별--}}
        <div class="box_dashboard ty3">
            <div id="tit_tab1" class="extab_tit00">
                <ul>
                    <li class="on"><a class="nav-link active" href="#tabTable1"><span>체결</span></a></li>
                    <li><a class="nav-link active" href="#tabTable2"><span>일별</span></a></li>
                </ul>
            </div>
            <div class="cont">
                <div id="tabTable1" class="tbl_basic">
                    <div>
                        <table class="list">
                            <thead>
                            <tr>
                                <th>체결시간</th>
                                <th>체결가격({{$market}})</th>
                                <th>체결량({{$coin}})</th>
                                <th class="ta-r">체결금액</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <div class="scrollY">
                        <table class="list">
                            <tbody class="history_box">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabTable2" class="tbl_basic">
                    <div class="tbl_basic">
                        <div>
                            <table class="list">
                                <colgroup>
                                    <col class="w100">
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>일자</th>
                                    <th>종가</th>
                                    <th>전일대비</th>
                                    <th class="ta-r">거래량({{$coin}})</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="scrollY">
                            <table class="list">
                                <colgroup>
                                    <col class="w100">
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <tbody>
                                <?php
                                /*                                /*$tmpprice = 0;
                                                                foreach ($dayorderlist as $row) {
                                                                    $updown = "c-up";
                                                                    if ($tmpprice > $row['price']) {
                                                                        $updown = "c-down";
                                                                    } */ ?>
                                <tr>
                                    <td><?php /*$row['order_date']*/ ?></td>
                                    <td><strong class="<?php /*$updown */?>"><?php /*$row['price']*/ ?></strong></td>
                                    <td><span class="<?php /*$updown*/ ?>"><?php /*$row['avg']*/ ?>%</span></td>
                                    <td class="ta-r"><?php /*$row['amount']*/ ?></td>
                                </tr>
                                <?php
                                /*  $tmpprice = $row['price'];
                              } */ ?>
                                {{--<tr>
                            <td>05.08</td>
                            <td><strong class="c-down">25,322,000</strong></td>
                            <td><span class="c-down">-5.5%</span></td>
                            <td class="ta-r">1,376,546</td>
                        </tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script src="{{ asset('/vendor/trading-view/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/vendor/trading-view/datafeeds/udf/dist/bundle.js') }}"></script>
@endassets

<script>
    //spa라서 페이지내에서 뒤로가기, 앞으로가기를 모두 제어하기 어렵기 때문에 그냥 페이지 자체를 reload를 한다.
    //또한 크롬 브라우저 이슈로 어쩔땐 render를 타고 어쩔땐 cache를 타고 정확한 포인트를 잡기 힘들다.
    //render를 탄다고 해도 /livewire/update를 request로 가져가기 때문에 변경된 현재 파라미터를 서버측에서 알기 힘들다.
    //그러면 snapshot으로 가져오면 되지 않겠냐? snapshot은 이전 데이터를 가지고 있다.
    window.addEventListener("popstate", function () {
        if (window.location.pathname === '/exchange') {
            window.location.reload();
        }
    });
</script>

<script>
    let resultArray;
    let chart;

    function startInterval() {
        // 현재 시간을 가져와서 다음 15분 간격의 정각을 계산
        let now = new Date();
        let utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);
        let nextFifteenMinutes = new Date(now.getTime() + now.getTimezoneOffset() * 60000);

        // 다음 15분 단위의 시간을 계산
        let minutes = utc.getMinutes();
        let next15Minutes = Math.ceil(minutes / 15) * 15; // 다음 15분 단위로 올림

        //0, 15, 30, 45일때는 다음수로 올림
        if ((minutes % 15) === 0) {
            minutes++;
        }

        if (minutes < 45) {
            // 현재 분이 45분보다 작으면 다음 15분 단위로 올림
            next15Minutes = Math.ceil(minutes / 15) * 15;
        } else {
            // 현재 분이 45분 이상이면 다음 시간대로 넘어감
            next15Minutes = 0;
            nextFifteenMinutes.setHours(nextFifteenMinutes.getHours() + 1);

            // 다음 날로 넘어갈 때 처리
            if (nextFifteenMinutes.getDate() !== now.getDate()) {
                if (chart) {
                    // 기존 차트가 있으면 삭제
                    chart.destroy();
                }
                // 미니 차트 설정
                setHighChart();
            }
        }

        // 다음 시간을 설정
        nextFifteenMinutes.setMinutes(next15Minutes);
        nextFifteenMinutes.setSeconds(0);
        nextFifteenMinutes.setMilliseconds(0);

        // 다음 15분 간격의 정각까지의 시간 차이를 계산합니다.
        const timeUntilNextFifteenMinutes = nextFifteenMinutes - utc;

        // 매 15분 간격으로 작업을 수행하는 함수를 정의합니다.
        function performTask() {
            console.log('작업을 수행합니다.' + new Date(now.getTime() + now.getTimezoneOffset() * 60000));

            // 초기 페이지 세팅에서 저장된 가장 마지막 값중 x값인 YYYY-MM-DD hh:mm:ss를 가져온다.
            // GMT+0 기준으로 날짜를 파싱하여 timestamp로 가져오기
            const timestampStartOfDay = Date.parse(resultArray.slice(-1)[0][0]);
            const timestampEndOfDay = new Date().getTime();

            let arg = {
                resolution: 15,
                symbol: coin + "_" + market,
                from: timestampStartOfDay,
                to: timestampEndOfDay
            };

            $.get('{{$datafeedAddress}}' + '/history', arg, function (r) {
                let x, y;

                // UTC 기준으로 날짜를 파싱
                let currentDate = new Date(timestampStartOfDay);

                // 15분을 더함
                currentDate.setUTCMinutes(currentDate.getUTCMinutes() + 15);

                // 결과를 출력
                console.log(formatDate(currentDate)); // UTC 기준으로 출력

                x = formatDate(currentDate);

                if (r.c) {
                    y = (yesterday_price - r.c) * -1;
                } else {
                    y = resultArray.slice(-1)[0][1];
                }

                chart.series[0].addPoint([x, y], true, true);
            });

            // 다음 15분 간격으로 다시 setTimeout을 호출합니다.
            startInterval();
        }

        console.log('다음 동작 시간 ' + timeUntilNextFifteenMinutes)

        // 다음 15분 간격으로 setTimeout을 설정합니다.
        setTimeout(performTask, timeUntilNextFifteenMinutes);
    }

    function getNext15MinutesFormatted() {
        // 현재 시간을 가져오기
        let now = new Date();

        // 협정 세계시로 변경
        let utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);

        // 다음 15분 단위의 시간을 계산
        let minutes = utc.getMinutes();
        let next15Minutes = Math.ceil(minutes / 15) * 15; // 다음 15분 단위로 올림

        //0,15,30,45일때는 다음수로 넘김
        if ((minutes % 15) === 0) {
            minutes++;
        }

        if (minutes < 45) {
            // 현재 분이 45분보다 작으면 다음 15분 단위로 올림
            next15Minutes = Math.ceil(minutes / 15) * 15;
        } else {
            // 현재 분이 45분 이상이면 다음 시간대로 넘어감
            next15Minutes = 0;
            utc.setHours(utc.getHours() + 1);
        }

        // 다음 시간을 설정
        utc.setMinutes(next15Minutes);
        utc.setSeconds(0);
        utc.setMilliseconds(0);

        return formatDate(utc);
    }

    function generateTimeArray() {
        // 현재 시간을 가져오기
        let now = new Date();

        // 협정 세계시로 변경
        let utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);

        // 현재 날짜의 00:00:00을 설정
        let startOfDay = new Date(utc.getFullYear(), utc.getMonth(), utc.getDate(), 0, 0, 0, 0);

        // 15분 간격으로 시간을 저장할 배열
        let time = [];

        // 현재 시간 전까지의 15분 간격으로 배열에 저장
        for (let timePointer = new Date(startOfDay); timePointer <= utc; timePointer.setMinutes(timePointer.getMinutes() + 15)) {
            let year = timePointer.getFullYear().toString().padStart(4, '0');
            let month = (timePointer.getMonth() + 1).toString().padStart(2, '0');
            let day = timePointer.getDate().toString().padStart(2, '0');
            let hours = timePointer.getHours().toString().padStart(2, '0');
            let minutes = timePointer.getMinutes().toString().padStart(2, '0');
            let seconds = timePointer.getSeconds().toString().padStart(2, '0');

            // 시간을 배열에 추가
            time.push(year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds);
        }

        return time;
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function setHighChart() {
        // 현재 시간 가져오기
        let currentDate = new Date();

        // 현재 시간을 GMT 0 (UTC)로 변환
        let utcYear = currentDate.getUTCFullYear();
        let utcMonth = currentDate.getUTCMonth();
        let utcDay = currentDate.getUTCDate();

        // GMT 0의 00:00:00
        let utcMidnight = new Date(utcYear, utcMonth, utcDay, 0, 0, 0, 0);

        // GMT 0의 23:59:59
        let utcEndOfDay = new Date(utcYear, utcMonth, utcDay, 23, 59, 59, 999);

        // 타임스탬프 얻기 (마지막 3자리 제외)
        let timestampStartOfDay = Math.floor(utcMidnight.getTime() / 1000);
        let timestampEndOfDay = Math.floor(utcEndOfDay.getTime() / 1000);

        let arg = {
            resolution: 15,
            symbol: coin + "_" + market,
            from: timestampStartOfDay,
            to: timestampEndOfDay
        };

        // GMT0 기준 그날의 00:00:00 ~ 23:59:59까지 마지막 데이터 가져오기
        $.get('{{$datafeedAddress}}' + '/history', arg, function (r) {
            let closingPricesWithTime;

            // [1704087233, '700.00000000'] 종가와 시간을 배열로 가져옴
            if (r) {
                closingPricesWithTime = r.t.map((time, index) => [time, r.c[index]]);
            }

            // GMT0 기준으로 00:00:00 부터 15분간격으로 현재 시간까지 배열로 가져오기
            let timeArray = generateTimeArray();

            resultArray = [];

            // 새로운 배열 초기화
            timeArray.map((time, index) => {
                const nextTime = timeArray[index + 1]; // 다음 시간 값 가져오기

                // 해당 시간과 다음 시간 사이에 대응하는 타임스탬프 찾기
                const timestampMatch = closingPricesWithTime.find(entry => {
                    const timestamp = Date.UTC(
                        parseInt(time.substring(0, 4), 10),  // Year
                        parseInt(time.substring(5, 7), 10) - 1,  // Month (months are zero-based)
                        parseInt(time.substring(8, 10), 10),  // Day
                        parseInt(time.substring(11, 13), 10),  // Hours
                        parseInt(time.substring(14, 16), 10),  // Minutes
                        parseInt(time.substring(17, 19), 10)  // Seconds
                    ) / 1000;

                    const nextTimestamp = nextTime ? Date.UTC(
                        parseInt(nextTime.substring(0, 4), 10),  // Year
                        parseInt(nextTime.substring(5, 7), 10) - 1,  // Month (months are zero-based)
                        parseInt(nextTime.substring(8, 10), 10),  // Day
                        parseInt(nextTime.substring(11, 13), 10),  // Hours
                        parseInt(nextTime.substring(14, 16), 10),  // Minutes
                        parseInt(nextTime.substring(17, 19), 10)  // Seconds
                    ) / 1000 : Infinity;

                    return entry[0] >= timestamp && entry[0] < nextTimestamp;
                });

                // 타임스탬프가 존재하는 경우 계산 수행
                if (timestampMatch) {
                    const priceDiff = (yesterday_price - timestampMatch[1]) * -1;
                    resultArray.push([time, priceDiff]);
                } else {
                    // 타임스탬프가 존재하지 않는 경우
                    if (index === 0) {
                        resultArray.push([time, 0]); // index가 0이면 0으로 채우기
                    } else {
                        // 이전 가격 정보 사용
                        const prevTimestampMatch = resultArray[index - 1];
                        resultArray.push([time, prevTimestampMatch[1]]);
                    }
                }
            });

            console.log(resultArray);

            initializeHighChart(resultArray);

            startInterval();
        }, "json");
    }

    function initializeHighChart(data) {
        // Highcharts 차트 옵션 설정
        let options = {
            chart: {
                animation: false,
                backgroundColor: "transparent",
                type: 'area', // 선 그래프 사용
                width: 140,    // 차트 너비
                height: 56,    // 차트 높이
                margin: [0, 0, 0, 0],
                reflow: false
            },
            navigator: {
                enabled: false
            },
            title: {
                style: {
                    display: false,
                },
                text: null    // 제목 없음
            },
            credits: {
                enabled: false // 로고 비활성화
            },
            xAxis: {
                labels: {
                    enabled: false // x 축 레이블 비활성화
                },
                max: 96 // 24시간/15분 = 96회
            },
            tooltip: {
                enabled: false
            },
            yAxis: {
                labels: {
                    enabled: false // y 축 레이블 비활성화
                },
                title: {
                    text: null // y 축 제목 비활성화
                }
            },
            legend: {
                enabled: false, // 범례 비활성화
            },
            plotOptions: {
                area: {
                    marker: {
                        states: {
                            hover: {
                                enabled: false,
                            }
                        },
                        enabled: false // 데이터 지점의 동그란 모양 비활성화
                    }
                },
                series: {},
            },
            rangeSelector: {
                enabled: false,
            },
            scrollbar: {
                enabled: false,
            },
            series:
                [
                    {
                        "name": "샌드박스",
                        "data": data,
                        "lineWidth": 1,
                        "lineCap": "square",
                        "fillColor": "rgba( 200, 74, 49, 0.1)",
                        "color": "#C84A31",
                        "negativeFillColor": "rgba( 0, 98, 223, 0.1)",
                        "negativeColor": "#0062DF"
                    }
                ]
        };

        // 미니 차트를 miniChartContainer에 그리기
        chart = Highcharts.chart('minichart', options);
    }
</script>

<script>
    let last_price;
    let comm_rate;
    let yesterday_price;
    let coin;
    let market;
    let order_form_type;
    let available_buy_price;
    let available_sell_price;
</script>

@script
<script>
    let exchangeConnect = io.connect('{{$exchangeAddress}}');
    let datafeedConnect = io.connect('{{$datafeedAddress}}');
    let hogaConnect = io.connect('{{$hogaAddress}}');

    document.addEventListener('livewire:navigated', () => {
        initalizeCoinInfo();
        setTradingViewChart();
        socketJoinRoom();
        setHighChart();

        Livewire.on('initializeLeft', () => {
            initalizeCoinInfo();
            setTradingViewChart();
            socketJoinRoom();
            setHighChart();
        });
    }, {once: true}); //이벤트 리스너가 실행된 후 제거하는 방법

    function initalizeCoinInfo(){
        last_price = $wire.coinInfo.price.lastPrice;
        comm_rate = $wire.coinInfo.ccs_commission_rate;
        yesterday_price = $wire.coinInfo.price.yesterdayPrice;
        coin = $wire.coinInfo.ccs_coin_name2;
        market = $wire.coinInfo.ccs_market_name2;

        debugger;
    }

    function setTradingViewChart() {
        let checkChart = $('#chartContainer iframe').length;

        if (checkChart && widget !== null) {
            // 차트가 있으면 내용만 교체
            widget.chart().setSymbol(coin + '_' + market, '1D', () => {
                console.log('Chart updated with symbol:', coin + '_' + market);
            });
        } else {
            // 차트가 없으면 차트를 새로 생성
            initializeTradingViewChart(market, coin);
        }
    }

    let chart_realtime_callback = null;
    let global_resolution;

    //실시간 차트 데이터를 받는다.
    hogaConnect.on('get_chart_data_signal', function () {
        let param = {
            market: market,
            coin: coin,
            resolution: global_resolution,
        }

        //사용자의 coin, market, resolution을 가지고 다시 이벤트를 올린다.
        hogaConnect.emit('get_real_time_chart_data', param, function (data) {
            chart_realtime_callback({
                time: data.t[0] * 1000,
                close: parseFloat(data.c),
                open: parseFloat(data.o),
                low: parseFloat(data.l),
                high: parseFloat(data.h),
            });
        });
    });

    //트레이딩뷰 차트 그리기
    function initializeTradingViewChart(market, coin) {
        let initialState = {
            width: '100%',
            height: '445',
            interval: '1D',
            symbol: coin + "_" + market,
            timezone: "Asia/Seoul",
            debug: false,
            container: "chartContainer",
            library_path: "/vendor/trading-view/charting_library/",
            locale: "ko",
            enabled_features: ["keep_left_toolbar_visible_on_small_screens"],
            disabled_features: [
                "use_localstorage_for_settings",
                "header_compare"{{--+버튼--}},
            ],
            datafeed: {
                onReady: function (cb) {
                    setTimeout(function () {
                        cb(['60', '1', '5', '15', '30', 'D', "2D", "3D", "W", "3W", "M"]);
                    }, 0);
                },
                resolveSymbol: function (symbolName, onSymbolResolvedCallback, onResolveErrorCallback) {
                    try {
                        setTimeout(function () {
                            onSymbolResolvedCallback({
                                name: symbolName,
                                description: "",
                                type: symbolName,
                                session: "24x7",
                                timezone: "Asia/Seoul",
                                ticker: symbolName,
                                minmov: 1,
                                pricescale: 100000000,
                                has_intraday: true,
                                supported_resolutions: ['1', '5', '15', '30', '60', 'D', "2D", "3D", "W", "3W", "M"],
                                visible_plots_set: 'ohlcv',
                                has_weekly_and_monthly: false,
                                volume_precision: 2,
                                data_status: "streaming",
                                supports_search: false, {{--Disable symbol search--}}
                                disabled_features: ["use_localstorage_for_settings", "header_symbol_search "],
                            });
                        }, 0);
                    } catch (err) {
                        onResolveErrorCallback(err.message);
                    }
                },
                getBars: function (symbolInfo, resolution, periodParams, onHistoryCallback, Callback, firstDataRequest) {
                    global_resolution = resolution;

                    let arg = {
                        resolution: resolution,
                        symbol: symbolInfo.name,
                        from: periodParams.from,
                        to: periodParams.to
                    };

                    $.get('{{$datafeedAddress}}' + '/history', arg, function (r) {
                        let bars = [];
                        for (let i = 0; i < r.t.length; ++i) {
                            let bar = {
                                time: 1e3 * r.t[i],
                                close: parseFloat(r.c[i]),
                                open: parseFloat(r.o[i]),
                                high: parseFloat(r.h[i]),
                                low: parseFloat(r.l[i]),
                                volume: parseFloat(r.v[i])
                            }
                            bars.push(bar)
                        }

                        onHistoryCallback(bars, {
                            noData: bars.length <= 0
                        });
                    }, "json");
                },
                subscribeBars: function (symbolInfo, resolution, onRealtimeCallback, subscribeUID, onResetCacheNeededCallback) {
                    chart_realtime_callback = onRealtimeCallback; {{--여기에 차트 콜백함수 부여--}}
                },
                unsubscribeBars: function (subscriberUID) {
                },
            },
        }

        widget = new TradingView.widget(initialState);

        widget.onChartReady(() => {
            widget.headerReady().then(function () {
                // 새로운 버튼을 생성
                let button = widget.createButton();
                button.setAttribute('title', '초기화');
                button.textContent = '초기화';

                // 버튼에 클릭 이벤트를 추가
                button.addEventListener('click', function () {
                    initializeTradingViewChart(market, coin)
                });
            });
        });
    }

    // 룸 접속
    function socketJoinRoom() {
        hogaConnect.emit('joinRoom', coin, market);
    }

    // 호가창
    hogaConnect.on('hoga', function (data) {
        if (data != null) {
            try {
                data.sell.reverse();
            } catch (err) {
                console.log(err);
            }

            let maxQuantity = 0;

            data.buy.forEach(function (_data) {
                if (_data.quantity > maxQuantity) {
                    maxQuantity = _data.quantity;
                }
            });

            data.sell.forEach(function (_data) {
                if (_data.quantity > maxQuantity) {
                    maxQuantity = _data.quantity;
                }
            });

            try {
                updateHogaBook(data.sell, maxQuantity, sellApp);
                updateHogaBook(data.buy, maxQuantity, buyApp);
            } catch (err) {
                console.log(err);
            }
        } else {
            updateHogaBook([], 0, sellApp);
            updateHogaBook([], 0, buyApp);
        }
    });

    function initializeReactiveHogaData(data, max, last_price) {
        return Alpine.reactive({
            data: data,
            max: max,
            last_price: last_price
        });
    }

    let initialHogadata = [{
        quantity: 0,
        percent_color_code: '',
        hoga_price: 0,
        percent: 0,
        last_price: 0,
    }];

    const sellApp = initializeReactiveHogaData(initialHogadata, 0, last_price);
    const buyApp = initializeReactiveHogaData(initialHogadata, 0, last_price);

    Alpine.data('sellHoga', () => (
        sellApp
    ));

    Alpine.data('buyHoga', () => (
        buyApp
    ));

    function updateHogaBook(data, max, app) {
        app.max = max;
        app.data = data.map(_data => {
            let percent_price;
            let percent;

            if (yesterday_price === null || yesterday_price === undefined || Number(yesterday_price) === 0) {
                percent_price = _data.hoga_price - last_price;

                if (last_price === 0) {
                    percent = (_data.hoga_price - last_price);
                } else {
                    percent = ((_data.hoga_price - last_price) / last_price) * 100;
                }
            } else {
                percent_price = _data.hoga_price - yesterday_price;
                percent = ((_data.hoga_price - yesterday_price) / yesterday_price) * 100;
            }

            percent = percent.toFixed(2);

            let percent_color_code = '';

            if (percent_price < 0) {
                percent_color_code = 'blue';
            } else {
                percent_color_code = 'red';
            }

            if (percent == 'NaN' || percent_price == '0') {
                percent_color_code = 'red';
                percent = "0.00";
            }

            if (percent == 0.00) {
                percent_color_code = 'black';
            }

            _data.percent = percent;
            _data.percent_color_code = percent_color_code;

            return _data;
        });
    }

    hogaConnect.on('his', function (data) {
        // 호가창 안에 작은 체결창
        updateHogaDetailBook(data == null ? [] : data, buyHogaDetailApp)
    });

    function initializeReactiveHogaDetailData(data) {
        return Alpine.reactive({
            data: data,
        });
    }

    let initialHogaDetaildata = [{
        price: 0,
        amount: 0,
        updown: '',
    }];

    const buyHogaDetailApp = initializeReactiveHogaDetailData(initialHogaDetaildata);

    Alpine.data('buyHogaDetail', () => (
        buyHogaDetailApp
    ));

    function updateHogaDetailBook(data, app) {
        app.data = data.map(_data => {
            _data.updown = (_data.order_type == 1) ? 'down' : 'up';

            return _data;
        });
    }

    // 잔액 가져오기
    exchangeConnect.on('get_balance', function (data) {
        available_buy_price = Number(data.mark_available);
        available_sell_price = Number(data.coin_available);
    });
</script>
@endscript

<script>
    //호가창을 누르면 가격에 세팅
    function HogaClickSetPriceValue(event) {
        const clickedElement = event.currentTarget;
        const ftbdElement = clickedElement.querySelector('.ftbd');

        if (ftbdElement) {
            const ftbdValue = ftbdElement.innerText.replace(/,/g, "");

            document.getElementById('sell_price').value = ftbdValue;
            document.getElementById('buy_price').value = ftbdValue;
        }
    }

    //주문금액 수수료 넣기
    function setTotalPriceAndFee(isNowprice) {
        if (submitmode === 2) {
            isNowprice = true;
        }

        let bq = $('.buy_qtt').val();
        let bp = $('.buy_price').val();
        let sq = $('.sell_qtt').val();
        let sp = $('.sell_price').val();

        bq = bq.replace(/[^-\.0-9]/g, '');
        bp = bp.replace(/[^-\.0-9]/g, '');
        sq = sq.replace(/[^-\.0-9]/g, '');
        sp = sp.replace(/[^-\.0-9]/g, '');

        $('.buy_qtt').val(bq.replace(/[^-\.0-9]/g, ''));
        $('.buy_price').val(bp.replace(/[^-\.0-9]/g, ''));
        $('.sell_qtt').val(sq.replace(/[^-\.0-9]/g, ''));
        $('.sell_price').val(sp.replace(/[^-\.0-9]/g, ''));

        if (isNowprice) {
            bp = last_price;
            sp = last_price;
        }

        $('.buy_total_sum').html((bq * bp));
        $('.sell_total_sum').html((sq * sp));

        $('.sell_fee').html((sq * sp * comm_rate * 0.01));
        $('.buy_fee').html((bq * bp * comm_rate * 0.01));
    }

    //최대 주문 가능 수량 넣기
    function setMaximumOrderableQuantity() {
        let isNowprice = false;

        if (order_form_type == 2) {
            isNowprice = true;
        }

        let percent = 1;
        let avail = available_buy_price;
        let price;

        if (isNowprice) {
            price = last_price;
        } else {
            price = Number($(".buy_price").val());
        }
        if (percent == 1) {
            avail = avail / (1 + comm_rate * 0.01);
        }
        if (price == 0) {
            $("#max_v").html(0);
            return false;
        }
        let result = avail * percent / price;

        $("#max_v").html(Number(result));
    }

</script>
