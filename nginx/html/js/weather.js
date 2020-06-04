let owmapi = (function (owmapi, $) {
    const API_KEY = atob("NmJlZjY0ZmQyMTNjM2U4Y2Y0OTFkNTRmMDk1MmQ1ODA=");
    const CITY_NAME = "daegu";

    const CROS_PROXY_URL            = 'https://cors-anywhere.herokuapp.com';

    const CUR_WEATHER_API_URL       = `https://api.openweathermap.org/data/2.5/weather?q=${CITY_NAME}&appid=${API_KEY}`;
    const DAILY_FORECAST_COUNT      = 7;
    const DAILY_FORECAST_API_URL    = `https://api.openweathermap.org/data/2.5/forecast/daily?q=${CITY_NAME}&cnt=${DAILY_FORECAST_COUNT}&appid=${API_KEY}`;
    const ONE_CALL_API_URL          = `https://api.openweathermap.org/data/2.5/onecall?lat=35.8&lon=128.55&%20exclude=&appid=${API_KEY}`;

    owmapi.get_cur_weather = () => {
        let weather
        send(
            'GET', CUR_WEATHER_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
        console.log(weather);
    };

    owmapi.get_daily_weather = () => {
        let weather
        send(
            'GET', DAILY_FORECAST_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
        console.log(weather);
    }

    owmapi.one_call_weather = () => {
        let weather
        send(
            'GET', ONE_CALL_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
        console.log(weather);
    }

    function send(method, url, headers, data, fn, async=false, cors_proxy=true) {
        if (cors_proxy) {
            url = `${CROS_PROXY_URL}/${url}`;
        }
        $.ajax(url, {
            async,
            method,
            headers,
            data,
            success: fn
        });
    }

    return owmapi;
})(window.owmapi || {}, jQuery);
