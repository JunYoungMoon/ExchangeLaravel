<div>
    <h1>Right</h1>
    <div style="display: flex; flex-direction: column;">
        <button @click="$dispatch('emitCoinInfo', { market : 'KRW', coin : 'EGX' })">EnegraGroup</button>
        <button @click="$dispatch('emitCoinInfo', { market : 'KRW', coin : 'BOSS' })">BossInfoAG</button>
    </div>
</div>
