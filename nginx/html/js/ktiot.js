let ktiot = (function (ktiot, $) {
    // START: KT IoTMakers와 통신하기 위해서 필요한 전역 변수
    const DEVICE_ID                 = "imgomiD1591093976479";
    const EVENT_ID_DICT             = {
        'low-battery': {
            id: '001PTL001D10008796', 
            message: '센서의 배터리가 15% 이하 입니다. 배터리를 교체해주세요.'
        }
    };

    const CROS_PROXY_URL            = 'https://cors-anywhere.herokuapp.com';
    const REST_API_HOST_URL         = "https://iotmakers.kt.com";

    // Request Oauth Path
    const REQ_OAUTH_TOKEN_PATH      = "oauth/token";
    // Tag Stream API Path
    const TAG_STREAM_LOG_BASE_TIME  = `api/v1/streams/${DEVICE_ID}/log`;
    const TAG_STREAM_LOG_DETAIL     = `api/v1/streams/${DEVICE_ID}`;
    const TAG_STREAM_LOG_LAST       = `api/v1/streams/${DEVICE_ID}/log/last`;
    // END: KT IoTMakers와 통신하기 위해서 필요한 전역 변수

    // START: 초기화 상태와 유저 토큰
    let IS_INIT = false;
    let USER_TOKEN;
    // END: 초기화 상태와 유저 토큰

    /**
     *  @description 태그 스트림 데이터 가져오기
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param:
     *      - count: 태그 스트림 데이터 개수
     *      - period: 태그 스트림의 데이터 분
     *  @return: 태그 스트림 딕셔너리 데이터 배열
     */
    ktiot.get_tag_stream_period = (count, period) => {
        if (!IS_INIT) {
            ktiot.init();
        }

        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_BASE_TIME}`,
            { // params
                period,
                count
            }
        );
    };

    /**
     *  @description from~to까지의 태그 스트림 데이터 가져오기
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param:
     *      - count: 태그 스트림 데이터의 개수
     *      - from: 시작 시간
     *      - to: 끝 시간
     *  @return: 태그 스트림 딕셔너리 데이터 배열
     */
    ktiot.get_tag_stream_until = (count, from, to) => {
        if (!IS_INIT) {
            ktiot.init();
        }

        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_BASE_TIME}`,
            { // params
                from: conv_time_to_timestamp(from),
                to: conv_time_to_timestamp(to),
                count
            }
        );
    };

    /**
     *  @description 마지막 요청된 태그 스트림 가져오기
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: void
     *  @return: 태그스트림 데이터
     */
    ktiot.get_last_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }

        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_LAST}`,
            { /* params */ }
        );
    };

    /**
     *  @description 태그 스트림 값 자세히 가져오기
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: void
     *  @return: 태그스트림 데이터
     */
    ktiot.get_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }
        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_DETAIL}`,
            { /* params */ }
        );
    };

    /**
     *  @description 이벤트 발생 로그
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: 
     *      - event_name: EVENT_ID_DICT의 key
     *      - dom: 위젯을 표시할 DOM ID
     *  @return: 이벤트 로그
     */
    ktiot.get_event_logs = (event_name, dom) => {
        if (!IS_INIT) {
            ktiot.init();
        }
        let start_time = new Date();
        start_time.setDate(start_time.getDate()-7)
        const req_url = `api/v1/event/logByEventId/${EVENT_ID_DICT[event_name].id}/${start_time.getTime()}`;
        let event_logs_data = JSON.parse(api_method_get_send(
            `${REST_API_HOST_URL}/${req_url}`,
            { /* params */ }
        ));

        if (dom !== undefined) {
            let root_dom = $(`#${dom}`);
            let rows = event_logs_data.data.rows;
            for (let i = 0; i < rows.length; i++) {
                root_dom.append(
                    $("<div>").addClass("col-md-12 mb-2").attr("style", "border-left: 2px solid red;").append(
                        $("<div>").addClass("col-md-12").append(
                            $("<h3>").html(rows[i].evetNm)
                        ),
                        $("<div>").addClass("col-md-12").append(
                            $("<span>").attr("style", "font-size: 0.9rem;").html(EVENT_ID_DICT[event_name].message)
                        ),
                        $("<div>").addClass("col-md-12").append(
                            $("<p>").attr("style", "font-size: 0.9rem;").html(rows[i].msrDt)
                        )
                    )
                )
            }
        }
        return event_logs_data;
    };

    ktiot.get_all_event_logs = () => {
        let all_event_datas = [];
        for (let i = 0; i < EVENT_ID_DICT.length; i++) {
            ktiot.get_event_logs();
        }
    };

    /**
     *  @description KT IoTMakers를 사용하기 위한 초기화 함수
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: void
     *  @return: void
     */
    ktiot.init = () => {
        request_token_aware_api();
        IS_INIT = true;
    };

    /**
     *  @description 딕셔너리 배열을 키값별 데이터 배열로 변환하는 함수
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: 딕셔너리 배열
     *  @return: 키값으로 구별된 데이터 딕셔너리 배열
     */
    ktiot.split_dict_array = (dict_array) => {
        let result = {};
        for (let i = 0; i < dict_array.length; i++) {
            for (const [key, value] of Object.entries(dict_array[i].attributes)) {
                if (!result.hasOwnProperty(key)) {
                    result[key] = [];
                }
                result[key].push(value); 
            }
        }
        return result;
    }

    /**
     *  @description RestAPI 사용을 위한 토큰 정보를 가져오기 위한 함수
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: void
     *  @return: void
     */
    function request_token_aware_api() {
        send(
            'POST',
            `${REST_API_HOST_URL}/${REQ_OAUTH_TOKEN_PATH}`,
            { // headers
                'Authorization': 'Basic ' + btoa(atob('NHlpSGx3aElNeDhTY0xXaw==') + ':' + atob('VlRvdE4xS1dGOFhsR09pQQ=='))
            },
            { // params
                grant_type: 'password',
                username: atob('aW1nb21p'),
                password: atob('ZGtkbGRoeGwwcDlvLQ==')
            },
            (res) => {
                USER_TOKEN = res.access_token;
            }
        );
    };

    /**
     *  @description Ajax를 간편하기 사용하기 위한 함수
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param:
     *      - method: 메소드명
     *      - url: 요청할 URL 주소
     *      - headers: 요청시 포함할 헤더정보
     *      - data: 요청시 포함할 데이터
     *      - fn: 통신이 성공할 경우 호출될 함수
     *      - async: 비동기화 통신 Flag
     *      - cors_proxy: CORS 정책 우회를 위한 프록시 사용여부
     *  @return: void
     */
    function send(method, url, headers, data, fn, async=false, cors_proxy=false) {
        if (cors_proxy) {
            url = `${CROS_PROXY_URL}/${url}`;
        }

        $.ajax(url, {
            async,
            method,
            // xhrFields: { withCredentials: true },
            headers,
            data,
            success: fn
        });
    }

    /**
     *  @description GET method만을 위한 요청 래핑 함수
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: url: 요청할 URL 주소, params: 요청시 포함할 데이터
     *  @return: 요청에 대한 response 데이터
     */
    function api_method_get_send(url, params, async=false, cors_proxy=false) {
        let ret;
        send(
            'GET',
            url,
            { 'Authorization': 'Bearer ' + USER_TOKEN },
            params,
            (res) => {
                ret = res;
            },
            async,
            cors_proxy
        )
        return ret;
    }

    /**
     *  @description 시간 문자열을 timestamp값으로 반환
     * 
     *  @author: 신병주(webmaster@mail.gomi.land)
     *  @param: tstr: 변환할 시간 문자열
     *  @return: unix-timestamp
     */
    function conv_time_to_timestamp(tstr) {
        return new Date(tstr).getTime();
    }

    function get_current_timestamp() {
        return new Date().getTime();
    }

    return ktiot;
})(window.ktiot || {}, jQuery);
