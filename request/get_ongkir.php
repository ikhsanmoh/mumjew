<?php
    include_once("../function/helper.php");

    $response = curl_post("https://api.rajaongkir.com/starter/cost");

    echo json_encode($response);