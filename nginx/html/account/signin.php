<?php
?>

<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, initial-scale=1.0">
    <title>FLORA 🌷 로그인</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
    @font-face { font-family: 'NanumBarunGothic'; font-style: normal; font-weight: 400; src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWeb.eot'); src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWeb.eot?#iefix') format('embedded-opentype'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWeb.woff') format('woff'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWeb.ttf') format('truetype'); } @font-face { font-family: 'NanumBarunGothic'; font-style: normal; font-weight: 700; src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebBold.eot'); src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebBold.eot?#iefix') format('embedded-opentype'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebBold.woff') format('woff'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebBold.ttf') format('truetype') } @font-face { font-family: 'NanumBarunGothic'; font-style: normal; font-weight: 300; src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebLight.eot'); src: url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebLight.eot?#iefix') format('embedded-opentype'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebLight.woff') format('woff'), url('//cdn.jsdelivr.net/font-nanumlight/1.0/NanumBarunGothicWebLight.ttf') format('truetype'); } .nanumbarungothic * { font-family: 'NanumBarunGothic', sans-serif; }

    body {
        margin: 0;
        padding: 0;
        background-color: #F7F9F9;
    }

    .wrap {
        width: 100%;
        height: 100%;
    }

    .signin-center-wrap {
        width: 320px;
        height: 100%;
        margin: 0 auto;
        display: table;
    }

    .signin-content {
        width: 100%;
        height: 520px;
        display: table-cell;
        vertical-align: middle;
    }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="signin-center-wrap">
            <div class="signin-content">
                <div class="signin-logo">
                    <img src="/img/logo.png" alt="flora">
                </div>
                <div class="signin-form">
                    <div class="signin-id-txt">
                        <div class="form-group">
                            <label for="txt-id-field" style="font-family: 'NanumBarunGothic';">아이디</label>
                            <input id="txt-id-field" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="signin-pw-txt">
                        <div class="form-group">
                            <label for="txt-pw-field" style="font-family: 'NanumBarunGothic';">비밀번호</label>
                            <input id="txt-pw-field" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="signin-help-link text-right">
                        <a href="">회원가입</a>
                        <a href="">아이디/비밀번호 찾기</a>
                    </div>
                    <div class="signin-submit-bt">
                        <button type="submit" class="btn btn-primary">로그인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
