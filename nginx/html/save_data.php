<?php

    $water = $_POST["water"];
    $battery = $_POST["battery"];

    $link = mysqli_connect("db", "root", "sksmschlrhek1", "iotadmin_db");
    if (!$link) {
        exit;
    }
    $sql = "UPDATE flora SET water='$water', battery='$battery' WHERE name='imgomi'";
    mysqli_query($link, $sql);
    echo "<script> window.location.href='/'</script>";
