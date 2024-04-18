<div style="width:75%">
    <h1>Left</h1>
    <div id="chartContainer" wire:ignore></div>
</div>

<script src="{{ asset('/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/datafeeds/udf/dist/bundle.js') }}"></script>

@script
<script>
    init();

    function init(){
        //filter를 통해서 최초 한번만 이벤트를 등록할수 있도록 처리
        if (typeof livewireNavigatedFilter =='undefined' || !livewireNavigatedFilter) {
            setEvent();
            livewireNavigatedFilter = true;
        }
    }

    function setEvent(){
        //navigate클릭, 뒤로가기, 앞으로가기시 동작하는데 컴포넌트가 다 그려진상태
        document.addEventListener('livewire:navigated', () => {
            let pathName = window.location.pathname;

            if (pathName === '/exchange') {
                let queryString = window.location.search;
                let searchParams = new URLSearchParams(queryString);
                let symbol = searchParams.get('code').split('-');

                //navigated시 Chart iframe DOM이 유지되지 않아 새로 그리는 방식 밖에 없음
                initializeChart(symbol[0], symbol[1]);
            }
        });

        document.addEventListener('livewire:navigated', () => {
            Livewire.on('initializeChart', (symbol) => {
                setChart(symbol[0]['market'], symbol[0]['coin']);
            });
        }, {once: true}); // 이벤트 리스너가 실행된 후 제거하는 방법
    }

    function setChart(market, coin) {
        let checkChart = $('#chartContainer iframe').length;

        if (checkChart && widget !== null) {
            // 차트가 있으면 내용 교체
            widget.chart().setSymbol(coin + '_' + market, '1D', () => {
                console.log('Chart updated with symbol:', coin + '_' + market);
            });
        } else {
            // 차트가 없으면 차트 생성
            initializeChart(market, coin);
        }
    }

    function initializeChart(market, coin) {
        let initialState = {
            width: '100%',
            height: '445',
            interval: '1D',
            symbol: coin + "_" + market,
            timezone: "Asia/Seoul",
            debug: false,
            container: "chartContainer",
            library_path: "charting_library/",
            locale: "ko",
            enabled_features: ["keep_left_toolbar_visible_on_small_screens"],
            disabled_features: [
                "use_localstorage_for_settings",
                "header_compare"/*+버튼*/,
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
                                supports_search: false, // Disable symbol search
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

                    $.get('http://192.168.100.193:8191/history', arg, function (r) {
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
                    chart_realtime_callback = onRealtimeCallback; //여기에 차트 콜백함수 부여
                },
                unsubscribeBars: function (subscriberUID) {
                },
            },
        }

        widget = new TradingView.widget(initialState);

        widget.onChartReady(() => {
            widget.headerReady().then(function () {
                let button = widget.createButton();
                button.setAttribute('title', '초기화');
                button.addEventListener('click', function () {
                    // Initial widget setup
                    initializeWidget();
                });
                button.textContent = '초기화';
            });
        });
    }

    function initializeWidget() {
        widget = new TradingView.widget(initialState);

        widget.headerReady().then(function () {
            let button = widget.createButton();
            button.setAttribute('title', '초기화');
            button.addEventListener('click', initializeWidget);
            button.textContent = '초기화';
        });
    }
</script>
@endscript
