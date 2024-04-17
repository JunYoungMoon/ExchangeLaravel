<div>
    <h1>Right</h1>
    <div style="display: flex; flex-direction: column;">
        <button @click="$dispatch('emitCoinInfo', { market : 'KRW', coin : 'EGX' })">EnegraGroup</button>
        <button @click="$dispatch('emitCoinInfo', { market : 'KRW', coin : 'BOSS' })">BossInfoAG</button>
{{--        <button onClick="javascript:emitCoinInfo('AAPL')">애플</button>--}}
{{--        <button onClick="javascript:emitCoinInfo('IBM')">IBM</button>--}}
        <button @click="$dispatch('emitCoinInfo', { code : 'AAPL' })">코스피</button>
        <button @click="$dispatch('emitCoinInfo', { code : 'AAPL' })">KRW_COLE</button>
        <button @click="$dispatch('emitCoinInfo', { code : 'AAPL' })">KRW_DLAD</button>
        <button @click="$dispatch('emitCoinInfo', { code : 'AAPL' })">KRW_VJDN</button>
    </div>
</div>
