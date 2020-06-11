<?php

    $authorize_code = $_GET["code"];
    $link = mysqli_connect("db", "root", "sksmschlrhek1", "iotadmin_db");
    if (!$link) {
        exit;
    }
    $sql = "SELECT * FROM flora WHERE name='imgomi'";
    $result = mysqli_query($link, $sql);
    $num_record = mysqli_num_rows($result);
    if ($num_record >= 1) {
        $sql = "UPDATE flora SET code='$authorize_code' WHERE name='imgomi'";
    } else {
        $sql = "INSERT INTO flora(name, code) VALUES('imgomi', '$authorize_code')";
    }
    mysqli_query($link, $sql);

    session_start();
    $_SESSION["kakao"] = "A+";

    echo "<script> window.location.href='/'</script>";
