<div class="rgh">
    <button type="button" class="btn_coin view-m btn-pk n bdrs nx_btn" onclick="coinSch();"><span>토큰 검색</span>
    </button>
    <!-- 5.코인 리스트 -->
    <div class="box_dashboard ty5">
        <div class="mtit view-m">
            <h2 class="title">토큰검색</h2>
            <button type="button" class="btn_p_cloes" onclick="coinSchClose();"><span>닫기</span></button>
        </div>
        <div class="tit inp">
            <input type="search" id="search_input" class="inp_txt" placeholder="토큰명/심볼검색"
                   onchange="coin_search(this)">
            <button type="button" class="btn_sch"><span class="ico_sch">검색</span></button>
        </div>
        <div id="tit_tab3" class="tit tab ty5">
            <ul>
                <li><a class="nav-link active" href="#t_market" id="krw_tab"><span>원화</span></a></li>
                <li><a class="nav-link" href="#t_hold" id="hold_tab"><span>보유</span></a></li>
                <li><a class="nav-link" href="#t_bookmark" id="favor_tab"><span>관심</span></a></li>
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
                        <th><a href="#t_market" onclick="coin_sort(1,true);">토큰명 <img
                                    src="/images/ico_arrow.png" alt="" style="height:12px;"/></th>
                        <th><a href="#t_market" onclick="coin_sort(2,true);">현재가 <img
                                    src="/images/ico_arrow.png" alt="" style="height:12px;"/></th>
                        <th><a href="#t_market" onclick="coin_sort(3,true);">전일대비 <img
                                    src="/images/ico_arrow.png" alt="" style="height:12px;"/></th>
                        <th><a href="#t_market" onclick="coin_sort(4,true);">거래대금 <img
                                    src="/images/ico_arrow.png" alt="" style="height:12px;"/></th>
                    </tr>
                    </thead>

                </table>
            </div>
            <div class="tbl_basic scrollY">
                <table class="list">
                    <colgroup>
                        <col class="w140">
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody class="coin_list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
