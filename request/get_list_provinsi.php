<?php
    include_once("../function/helper.php");

    $response = curl_get("https://api.rajaongkir.com/starter/province");

    echo json_encode($response);