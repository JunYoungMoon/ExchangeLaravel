<div style="width:75%">
    <h1>Left</h1>
    <div id="chartContainer" wire:ignore></div>
</div>

<script src="{{ asset('/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/datafeeds/udf/dist/bundle.js') }}"></script>

@script
<script>
    console.log('1');

    //다른페이지에서 뒤로가기, 앞으로가기 왔을떄
    document.addEventListener('livewire:navigated', () => {
        console.log('2');

        let pathName = window.location.pathname;

        if (pathName === '/exchange') {
            widget = null;

            console.log('5');
            let queryString = window.location.search;
            let searchParams = new URLSearchParams(queryString);
            let symbol = searchParams.get('code').split('-');

            setChart(symbol[0], symbol[1]);
        }
    });

    function setChart(market, coin) {
        if (widget !== null) {
            console.log('6');
            widget.chart().setSymbol(coin + '_' + market, '1D', () => {
                console.log('Chart updated with symbol:', coin + '_' + market);
            });
        } else {
            console.log('7');
            // 처음으로 차트를 생성할 때
            initializeChart(market, coin);
        }
    }

    document.addEventListener('livewire:navigated', () => {
        Livewire.on('initializeChart', (symbol) => {
            console.log('4');

            setChart(symbol[0]['market'], symbol[0]['coin']);
        });
    }, { once: true });

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
