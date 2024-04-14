<div style="width:75%">
    <h1>Left</h1>
    <div id="chartContainer"></div>
</div>

<script src="{{ asset('/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/datafeeds/udf/dist/bundle.js') }}"></script>

<script>
    document.addEventListener('livewire:init', () => {
        let tvWidget = null; // TradingView 차트 위젯 변수 선언

        Livewire.on('initializeChart', (symbol) => {
            // 새로운 symbol이 주어질 때마다 차트를 업데이트

            if (tvWidget !== null) {
                tvWidget.chart().setSymbol(symbol[0], '1D', () => {
                    console.log('Chart updated with symbol:', symbol[0]);
                });
            } else {
                // 처음으로 차트를 생성할 때
                initializeChart(symbol[0]);
            }
        });

        function initializeChart(symbol) {
            var widgetOptions = {
                container: 'chartContainer',
                locale: 'en',
                library_path: 'charting_library/',
                datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo-feed-data.tradingview.com"),
                symbol: symbol,
                interval: '1D',
                fullscreen: true
            };

            tvWidget = new TradingView.widget(widgetOptions);
        }
    });
</script>
