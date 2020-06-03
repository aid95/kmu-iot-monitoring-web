let ktiot = (function (ktiot, $) {
    const DEVICE_ID = "imgomiD1591093976479";

    const REST_API_HOST_URL         = "https://iotmakers.kt.com";

    const REQ_OAUTH_TOKEN           = "/oauth/token";
    // Tag Stream API Path
    const TAG_STREAM_LOG_BASE_TIME  = `/api/v1/streams/${DEVICE_ID}/log`;
    const TAG_STREAM_LOG_DETAIL     = `/api/v1/streams/${DEVICE_ID}`;
    const TAG_STREAM_LOG_LAST       = `/api/v1/streams/${DEVICE_ID}/log/last`;

    let IS_INIT = false;
    let USER_TOKEN;
    let LAST_RESPONSE_BODY;

    ktiot.get_tag_stream_period = (count, period) => {
        if (!IS_INIT) {
            ktiot.init();
        }
        
        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_BASE_TIME}`,
            {
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { // params
                period,
                count
            },
            (res) => {
                console.log(res);
            }
        )
    };

    ktiot.get_tag_stream_until = (count, from, to) => {
        if (!IS_INIT) {
            ktiot.init();
        }
        
        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_BASE_TIME}`,
            {
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { // params
                from: conv_time_to_timestamp(from),
                to: conv_time_to_timestamp(to),
                count
            },
            (res) => {
                console.log(res);
            }
        )
    };

    ktiot.get_last_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }

        let ret;
        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_LAST}`,
            {
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { // params 
            },
            (res) => {
                ret = res;
            }
        )
    };

    ktiot.get_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }

        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_DETAIL}`,
            {
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { // params 
            },
            (res) => {
                console.log(res);
            }
        )
    };

    ktiot.init = () => {
        request_token_aware_api();
        IS_INIT = true;
    };

    function request_token_aware_api() {
        send(
            'POST',
            'https://iotmakers.kt.com/oauth/token', 
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

    function send(method, url, headers, data, fn) {
        $.ajax(url, {
            method,
            xhrFields: { withCredentials: true },
            headers,
            data,
            success: fn
        });
    }

    function conv_time_to_timestamp(tstr) {
        return new Date(tstr).getTime();
    }

    return ktiot;
})(window.ktiot || {}, jQuery);
