<div>
    <h1>Right</h1>
    <div style="display: flex; flex-direction: column;">
        <!-- He who is contented is rich. - Laozi -->
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'AAPL' })">애플</button>
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'IBM' })">IBM</button>
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'AAPL' })">코스피</button>
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'AAPL' })">KRW_COLE</button>
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'AAPL' })">KRW_DLAD</button>
        <button @click="$dispatch('emitCoinInfo', { market: 'KRW', code : 'AAPL' })">KRW_VJDN</button>
    </div>
</div>
