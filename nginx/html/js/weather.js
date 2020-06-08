let owmapi = (function (owmapi, $) {
    /**
     * @description OpenWeatherMap API를 사용하기 위한 전역변수
     */
    const API_KEY                   = atob("NmJlZjY0ZmQyMTNjM2U4Y2Y0OTFkNTRmMDk1MmQ1ODA=");
    const CITY_NAME                 = "daegu";

    const CROS_PROXY_URL            = 'https://cors-anywhere.herokuapp.com';

    const CUR_WEATHER_API_URL       = `https://api.openweathermap.org/data/2.5/weather?q=${CITY_NAME}&appid=${API_KEY}`;
    const DAILY_FORECAST_COUNT      = 7;
    const DAILY_FORECAST_API_URL    = `https://api.openweathermap.org/data/2.5/forecast/daily?q=${CITY_NAME}&cnt=${DAILY_FORECAST_COUNT}&appid=${API_KEY}`;
    const ONE_CALL_API_URL          = `https://api.openweathermap.org/data/2.5/onecall?lat=35.8&lon=128.55&%20exclude=&appid=${API_KEY}`;

    /**
     *  @todo 현재 날씨를 가져오기 위한 함수
     * 
     *  @author: 김규동
     *  @param: void
     *  @return: void
     */
    owmapi.get_cur_weather = () => {
        let weather
        send(
            'GET', CUR_WEATHER_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
    };

    /**
     *  @todo 오늘의 날씨를 가져오기 위한 함수
     * 
     *  @author: 김규동
     *  @param: void
     *  @return: void
     */
    owmapi.get_daily_weather = () => {
        let weather
        send(
            'GET', DAILY_FORECAST_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
    }

    /**
     *  @description 날씨에 관련된 모든 데이터를 한번에 가져오기와 현재 날씨 주간 날씨 주간 평균 날씨 위젯을 표시하기 위한 함수
     * 
     *  @author: 
     *      - 김규동
     *      - 신병주(webmaster@mail.gomi.land)
     *  @param:
     *      - cur_weather_dom: 현재 날씨 정보 위젯을 표시하기 위한 DOM 이름
     *      - week_weather_dom: 주간 날씨 정보 위젯을 표시하기 위한 DOM 이름
     *      - week_avg_weather_dom: 주간 평규 날씨 정보 위젯을 표시하기 위한 DOM 이름
     *  @return: void
     */
    owmapi.one_call_weather = (cur_weather_dom, week_weather_dom, week_avg_weather_dom) => {
        let weather
        send(
            'GET', ONE_CALL_API_URL, {'Content-Type': 'application/json'}, '', (res) => { weather = res; }
        );
        
        if (cur_weather_dom !== undefined) {
            let dom = $(`#${cur_weather_dom}`);
            dom.empty().append(
                $("<div>").addClass("row").append(
                    // IMPORTANT!! .align-font-txt-center는 사용자 정의 스타일
                    $("<div>").addClass("col-md-12").append(
                        $("<h5>").addClass("align-font-txt-center").html(get_day_name_from_unix_timestamp(weather.current.dt))
                    ),
                    $("<div>").addClass("col-md-12").addClass("text-center").append(
                        $("<img>").attr("src", `http://openweathermap.org/img/wn/${weather.current.weather[0].icon}@4x.png`)
                    ),
                    $("<div>").addClass("col-md-12").addClass("align-font-txt-center").append(
                        $("<p>").html(`🌡 ${(weather.current.temp-273.15).toFixed(1)}℃ / 🤒 ${(weather.current.feels_like-273.15).toFixed(1)}℃ / 🕶 ${Math.round(weather.current.uvi)} / 💦 ${Math.round(weather.current.humidity)}`),
                    )
                )
            );
        }

        if (week_weather_dom !== undefined) {
            let root_dom = $(`#${week_weather_dom}`);

            let ww_dom = $("<div>").addClass("row");
            for (let i = 1; i < 7; i++) {
                // IMPORTANT!! .align-font-txt-center는 사용자 정의 스타일
                ww_dom.append(
                    $("<div>").addClass("col-md-2").append(
                        $("<div>").addClass("col-md-12").append(
                            $("<h5>").addClass("align-font-txt-center").html(get_day_name_from_unix_timestamp(weather.daily[i].dt))
                        ),
                        $("<div>").addClass("col-md-12").addClass("text-center").append(
                            $("<img>").attr("src", `http://openweathermap.org/img/wn/${weather.daily[i].weather[0].icon}.png`)
                        )
                    )
                );
            }
            root_dom.empty().append(ww_dom);
        }

        if (week_avg_weather_dom !== undefined) {
            let root_dom = $(`#${week_avg_weather_dom}`);
            let daily_datas = weather.daily.slice(1);
            let daily_datas_len = daily_datas.length;

            let total_temp = 0;
            let total_feels_like = 0;
            let total_uvi = 0;
            let total_humidity = 0;
            for (let i = 0; i < daily_datas.length; i++) {
                total_feels_like += daily_datas[i].feels_like.day - 273.15;
                total_humidity += daily_datas[i].humidity;
                total_temp += daily_datas[i].temp.day - 273.15;
                total_uvi += daily_datas[0].uvi;
            }

            let avg_dom = $("<p>").html(`🌡 ${(total_temp / daily_datas_len).toFixed(1)}℃ / 🤒 ${(total_feels_like / daily_datas_len).toFixed(1)}℃ / 🕶 ${Math.round(total_uvi / daily_datas_len)} / 💦 ${Math.round(total_humidity / daily_datas_len)}`);
            root_dom.empty().append(avg_dom);
        }

        return weather;
    }

    /**
     *  @description Ajax를 간편하기 사용하기 위한 함수
     * 
     *  @author: 김규동
     *  @param:
     *      - method: 메소드명
     *      - url: 요청할 URL 주소
     *      - headers: 요청시 포함할 헤더정보
     *      - data: 요청시 포함할 데이터
     *      - fn: 통신이 성공할 경우 호출될 함수
     *      - async: 비동기화 통신 Flag
     *      - cors_proxy: CORS 규칙을 위한 프록시 서버 사용 Flag
     *  @return: void
     */
    function send(method, url, headers, data, fn, async=false, cors_proxy=true) {
        if (cors_proxy) {
            url = `${CROS_PROXY_URL}/${url}`;
            headers['X-Requested-With'] = 'XMLHttpRequest';
        }
        $.ajax(url, {
            async,
            method,
            headers,
            data,
            success: fn
        });
    }

    /**
     *  @description unix-timestamp로부터 요일명 가져오기
     * 
     *  @author: 김규동
     *  @param:
     *      - dt: datetime
     *  @return: 요일명
     */
    function get_day_name_from_unix_timestamp(dt) {
        return new Date(dt * 1000).toString().split(' ')[0].toUpperCase()
    }

    return owmapi;
})(window.owmapi || {}, jQuery);
