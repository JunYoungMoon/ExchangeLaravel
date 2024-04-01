window._cmn = {}

_cmn['time'] = {
    getTimestamp: function (param) {
        return new Date(param) / 1000;
    },
    setCountdown: function (selector, run_time) {
        let _second = 1000;
        let _minute = _second * 60;
        let _hour = _minute * 60;
        let _day = _hour * 24;

        function getDate(target_time) {
            let _nDate = new Date();

            let cal_date = target_time - _nDate;

            let days = Math.floor(cal_date / _day);
            let hours = Math.floor((cal_date % _day) / _hour);
            let minutes = Math.floor((cal_date % _hour) / _minute);
            let seconds = Math.floor((cal_date % _minute) / _second);

            return days + 'D : ' + hours + 'H : ' + minutes + 'M : ' + seconds + 'S';
        }

        function countDown() {
            $(selector).each(function () {
                $(this).text(getDate($(this).data('time')));
            });
        }

        setInterval(countDown, run_time);
    },
    getDateStr: function (date) {
        /*파라메타는 new Date()형태로 받아야함*/
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2);
        let day = ('0' + date.getDate()).slice(-2);

        return year + '-' + month + '-' + day;
    },
    getToday: function () {
        let today = new Date();
        return _cmn.time.getDateStr(today);
    },
    getOneWeekAgo: function () {
        /*일주일전*/
        let oneWeekAgo = new Date(new Date().setDate(new Date().getDate() - 7));
        return _cmn.time.getDateStr(oneWeekAgo);
    },
    getTwoWeekAgo: function () {
        /*15일전*/
        let TwoWeekAgo = new Date(new Date().setDate(new Date().getDate() - 15));
        return _cmn.time.getDateStr(TwoWeekAgo);
    },
    getOneMonthAgo: function () {
        /*한달전*/
        let oneMonthAgo = new Date(new Date().setMonth(new Date().getMonth() - 1));
        return _cmn.time.getDateStr(oneMonthAgo);
    },
    getThreeMonthAgo: function () {
        /*세달전*/
        let oneMonthAgo = new Date(new Date().setMonth(new Date().getMonth() - 3));
        return _cmn.time.getDateStr(oneMonthAgo);
    },
    getOneYearAgo: function () {
        /*1년전*/
        let oneYearAgo = new Date(new Date().setFullYear(new Date().getFullYear() - 1));
        return _cmn.time.getDateStr(oneYearAgo);
    },
    getWhenDate: function (date) {
        let target = new Date() - (date * 1000);
        let str;
        let date_time = new Date(date * 1000);
        let month = date_time.getMonth() + 1;
        let day = date_time.getDate();
        month = month >= 10 ? month : '0' + month;
        day = day >= 10 ? day : '0' + day;

        if (target < 1000 * 60)
            str = Math.floor(target / 1000) + ' seconds ago';
        else if (target < 1000 * 60 * 60)
            str = Math.floor(target / (1000 * 60)) + ' minutes ago';
        else if (target < 1000 * 60 * 60 * 24)
            str = Math.floor(target / (1000 * 60 * 60)) + ' hours ago';
        else if (target < 1000 * 60 * 60 * 24 * 7)
            str = Math.floor(target / (1000 * 60 * 60 * 24)) + ' days ago';
        else
            str = date_time.getFullYear() + '-' + month + '-' + day;

        return str;
    },
    getWhenDateAdmin: function (date, type = 1) {
        /*type=1:~일전 표기법, type=2:yyyy-mm-dd hh:MM:ss, type=3:yyyy-mm-dd*/
        let target = new Date() - (date * 1000);
        let str;
        let date_time = new Date(date); // 수정된 부분: Unix timestamp를 직접 전달
        let month = date_time.getMonth() + 1;
        let day = date_time.getDate();
        let hour = date_time.getHours() >= 10 ? date_time.getHours() : '0' + date_time.getHours();
        let minute = date_time.getMinutes() >= 10 ? date_time.getMinutes() : '0' + date_time.getMinutes();
        let seconds = date_time.getSeconds() >= 10 ? date_time.getSeconds() : '0' + date_time.getSeconds();
        let time = hour + ':' + minute + ':' + seconds;
        month = month >= 10 ? month : '0' + month;
        day = day >= 10 ? day : '0' + day;

        if (type === 1) {
            if (target < 1000 * 60)
                str = Math.floor(target / 1000) + ' seconds ago';
            else if (target < 1000 * 60 * 60)
                str = Math.floor(target / (1000 * 60)) + ' minutes ago';
            else if (target < 1000 * 60 * 60 * 24)
                str = Math.floor(target / (1000 * 60 * 60)) + ' hours ago';
            else if (target < 1000 * 60 * 60 * 24 * 7)
                str = Math.floor(target / (1000 * 60 * 60 * 24)) + ' days ago';
            else
                str = date_time.getFullYear() + '-' + month + '-' + day;
        } else if (type === 2) {
            str = date_time.getFullYear() + '-' + month + '-' + day + ' ' + time;
        } else if (type === 3) {
            str = date_time.getFullYear() + '-' + month + '-' + day;
        }
        return str;
    },
    getKoreaTime: function (date, type = 1) {
        let target = new Date(Date.parse(date));
        let offset = -540;
        let koreanDate = new Date(target.getTime() - offset * 60 * 1000);
        let year = koreanDate.getFullYear();
        let month = ('0' + (koreanDate.getMonth() + 1)).slice(-2);
        let day = ('0' + koreanDate.getDate()).slice(-2);
        let hour = ('0' + koreanDate.getHours()).slice(-2);
        let minute = ('0' + koreanDate.getMinutes()).slice(-2);
        let second = ('0' + koreanDate.getSeconds()).slice(-2);

        if (type === 1) {
            return year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        } else if (type === 2) {
            return year + '-' + month + '-' + day;
        }
    },
}

_cmn['pagination'] = {
    getPagination: function (totalCount, page = 1, listMaxSize, pageMaxSize) {
        let totalPage = Math.ceil(totalCount / listMaxSize);

        if (Number(page) > totalPage) {
            page = totalPage;
        }

        if (Number(page) < 1) {
            page = 1;
        }

        let prev, next;

        if (Number(page) - 1 === 0) {
            prev = 1;
        } else {
            prev = Number(page) - 1;
        }

        if (Number(page) + 1 > totalPage) {
            next = totalPage;
        } else {
            next = Number(page) + 1;
        }

        let startPage = Math.floor((Number(page) - 1) / pageMaxSize) * pageMaxSize + 1;
        let endPage = startPage + pageMaxSize - 1;

        if (endPage > totalPage) {
            endPage = totalPage;
        }

        let html = '';

        html += '<a class="first">' + (1) + '</a>';
        html += '<a class="prev">' + prev + '</a>';
        for (let i = startPage; i <= endPage; i++) {
            if (i === Number(page)) {
                html += '<a class="on">' + (i) + '</a>';
            } else {
                html += '<a>' + (i) + '</a>';
            }
        }
        html += '<a class="next">' + next + '</a>';
        html += '<a class="end">' + totalPage + '</a>';

        return html;
    },
}

_cmn['url'] = {
    getParam: function (paramName, defaultValue = '') {
        let url = new URL(window.location.href);
        let value = url.searchParams.get(paramName);

        if (value !== null && (paramName === 'start_dt' || paramName === 'end_dt')) {
            return _cmn.time.getWhenDateAdmin(value, 3);
        }

        return value ?? defaultValue;
    },

    setParam: function (url, paramName, value, defaultValue = '') {
        url.searchParams.delete(paramName);
        if (value && value !== defaultValue) {
            url.searchParams.set(paramName, value);
        }
    },

    setParams: function (searchFilter) {
        let url = new URL(window.location.href);
        for (let key in searchFilter) {
            _cmn['url'].setParam(url, key, searchFilter[key]);
        }
        return url;
    },
}
