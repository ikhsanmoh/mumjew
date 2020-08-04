<?php
    include("../../function/koneksi.php");   
	include("../../function/helper.php");   
	
	$button = isset($_POST['button']) ? $_POST['button'] : $_GET['button'];
	$kota_id = isset($_GET['kota_id']) ? $_GET['kota_id'] : "";
	
    $kota = isset($_POST['kota']) ? $_POST['kota'] : false;
    $tarif = isset($_POST['tarif']) ? $_POST['tarif'] : false;
    $status = isset($_POST['status']) ? $_POST['status'] : false;
	
	if($button == "Add"){
		mysqli_query($koneksi, "INSERT INTO kota (kota, tarif, status) VALUES('$kota', '$tarif', '$status')");
	}
	else if($button == "Update"){
		mysqli_query($koneksi, "UPDATE kota SET kota='$kota',
												tarif='$tarif',
												status='$status' WHERE kota_id='$kota_id'");
	}

	else if($button == "Delete"){
        mysqli_query($koneksi, "DELETE FROM kota WHERE kota_id='$kota_id'");
    }
	
	header("location:" .BASE_URL."index.php?page=my_profile&module=kota&action=list");