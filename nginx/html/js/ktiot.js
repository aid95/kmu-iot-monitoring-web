let ktiot = (function (ktiot, $) {
    const DEVICE_ID = "imgomiD1591093976479";

    const REST_API_HOST_URL         = "https://iotmakers.kt.com";

    // Request Oauth Path
    const REQ_OAUTH_TOKEN_PATH      = "oauth/token";
    // Tag Stream API Path
    const TAG_STREAM_LOG_BASE_TIME  = `api/v1/streams/${DEVICE_ID}/log`;
    const TAG_STREAM_LOG_DETAIL     = `api/v1/streams/${DEVICE_ID}`;
    const TAG_STREAM_LOG_LAST       = `api/v1/streams/${DEVICE_ID}/log/last`;

    let IS_INIT = false;
    let USER_TOKEN;

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

    ktiot.get_last_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }

        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_LAST}`,
            { /* params */ }
        );
    };

    ktiot.get_tag_stream = () => {
        if (!IS_INIT) {
            ktiot.init();
        }
        return api_method_get_send(
            `${REST_API_HOST_URL}/${TAG_STREAM_LOG_DETAIL}`,
            { /* params */ }
        )
    };

    ktiot.init = () => {
        request_token_aware_api();
        IS_INIT = true;
    };

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

    function send(method, url, headers, data, fn, async=false) {
        $.ajax(url, {
            async,
            method,
            xhrFields: { withCredentials: true },
            headers,
            data,
            success: fn
        });
    }

    function api_method_get_send(url, params) {
        let ret;
        send(
            'GET',
            url,
            { 'Authorization': 'Bearer ' + USER_TOKEN },
            params,
            (res) => {
                ret = res;
            }
        )
        return ret;
    }

    function conv_time_to_timestamp(tstr) {
        return new Date(tstr).getTime();
    }

    return ktiot;
})(window.ktiot || {}, jQuery);
