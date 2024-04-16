<div style="width:75%">
    <h1>Left</h1>
    <div id="chartContainer" wire:ignore></div>
</div>

<script src="{{ asset('/charting_library/charting_library.standalone.js') }}"></script>
<script src="{{ asset('/datafeeds/udf/dist/bundle.js') }}"></script>

@script
<script>
    let widget = null;

    $wire.on('initializeChart', (symbol) => {
        if (widget !== null) {
            widget.chart().setSymbol(symbol[0], '1D', () => {
                console.log('Chart updated with symbol:', symbol[0]);
            });
        } else {
            // 처음으로 차트를 생성할 때
            initializeChart(symbol[0]);
        }
    });

    function initializeChart(symbol) {
        let widgetOptions = {
            container: 'chartContainer',
            locale: 'en',
            library_path: 'charting_library/',
            datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo-feed-data.tradingview.com"),
            symbol: symbol,
            interval: '1D',
            fullscreen: true
        };

        widget = new TradingView.widget(widgetOptions);
    }
</script>
@endscript
