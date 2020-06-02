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

    ktiot.get_tag_stream_until = () => {
        if (!IS_INIT) {
            ktiot.init();
        }

        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_BASE_TIME}`,
            { 
                // headers
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { 
                // params 
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

        send(
            'GET',
            `${REST_API_HOST_URL}${TAG_STREAM_LOG_LAST}`,
            { 
                // headers
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { 
                // params 
            },
            (res) => {
                console.log(res);
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
                // headers
                'Authorization': 'Bearer ' + USER_TOKEN 
            },
            { 
                // params 
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

    function conv_to_timestamp(tstr) {
        return Date.parse(tstr);
    }

    return ktiot;
})(window.ktiot || {}, jQuery);
