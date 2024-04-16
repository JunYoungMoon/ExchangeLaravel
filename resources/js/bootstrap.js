import axios from 'axios';
import $ from "jquery";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use(
    config => {
        showLoading();
        return config;
    }
);

window.axios.interceptors.response.use(
    response => {
        hideLoading();
        return response;
    },
    error => {
        if (error.response && error.response.status === 401) {
            // 401 Unauthorized 에러 처리
        } else if (error.response && error.response.status === 404) {
            // 404 Not Found 에러 처리
        } else if (error.response && error.response.status === 500) {
            // 500 Internal Server Error 에러 처리
        } else if (error.response.status === 422) {
            // 422 Unprocessable Content 에러 처리
        } else {
            // 기타 에러 처리
        }

        return Promise.reject(error);
    }
);

function showLoading() {
    console.log("showLoading");
    $('#loading').show();
}

function hideLoading() {
    console.log("hideLoading");
    $('#loading').hide();
}

document.addEventListener('livewire:init', () => {
    Livewire.on('showLoading', function () {
        console.log('showLoading');
        $('#loading').show();
    });

    Livewire.on('hideLoading', function () {
        console.log('hideLoading');
        $('#loading').hide();
    });

    // window.onpopstate = function (event) {
    //
    //     let pathName = window.location.pathname;
    //
    //     if (pathName === '/exchange') {
    //         let queryString = window.location.search;
    //         let searchParams = new URLSearchParams(queryString);
    //         let codeArray = searchParams.get('code').split('-');
    //
    //         debugger;
    //         Livewire.dispatch('test', {market: codeArray[0], coin: codeArray[1]});
    //         Livewire.dispatch('emitCoinInfo', {market: codeArray[0], coin: codeArray[1]});
    //     }
    // };
});
