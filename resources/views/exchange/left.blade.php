<div style="width:75%">
    <h1>Left</h1>
    <div id="chartContainer"></div>
</div>

<script src="{{ asset('/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/datafeeds/udf/dist/bundle.js') }}"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('initializeChart', (symbol) => {
            initializeChart(symbol[0]);
        });

        function initializeChart(symbol) {
            var widgetOptions = {
                container: 'chartContainer',
                locale: 'en',
                library_path: 'charting_library/',
                datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo-feed-data.tradingview.com"),
                symbol: symbol,
                interval: '1D',
                fullscreen: true,
                debug: true
            };

            window.tvWidget = new TradingView.widget(widgetOptions);

            if (window.tvWidget !== undefined) {
                window.tvWidget.onChartReady(() => {
                    window.tvWidget.chart().setSymbol(symbol, () => {});
                });
            } else {
                window.tvWidget = new TradingView.widget(widgetOptions);
            }
        }

    });
</script>
