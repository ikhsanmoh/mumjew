<?php

	include_once("../../function/koneksi.php");
	include_once("../../function/helper.php");
	
	session_start();

	$button = isset($_POST['button']) ? $_POST['button'] : $_GET['button'];
    $pesanan_id = isset($_GET['pesanan_id']) ? $_GET['pesanan_id'] : "";
	
	if($button == "Konfirmasi"){
		
		$user_id = $_SESSION["user_id"];

		$nomor_rekening = isset($_GET['nomor_rekening']) ? $_GET['nomor_rekening'] : false;
		$nama_account = isset($_GET['nama_account']) ? $_GET['nama_account'] : false;
		$tanggal_transfer = isset($_GET['tanggal_transfer']) ? $_GET['tanggal_transfer'] : false;
		
		$queryPembayaran = mysqli_query($koneksi, "INSERT INTO konfirmasi_pembayaran (pesanan_id, nomor_rekening, nama_account, tanggal_transfer)
																			VALUES ('$pesanan_id', '$nomor_rekening', '$nama_account', '$tanggal_transfer')");
																			
		if($queryPembayaran){
			mysqli_query($koneksi, "UPDATE pesanan SET status='1' WHERE pesanan_id='$pesanan_id'");
		}
		
	}else if($button == "Edit Status"){
		$status = $_POST["status"];
		
		mysqli_query($koneksi, "UPDATE pesanan SET status='$status' WHERE pesanan_id='$pesanan_id'");
		
		if($status == "2"){
			$query = mysqli_query($koneksi, "SELECT * FROM pesanan_detail WHERE pesanan_id='$pesanan_id'");
			while($row=mysqli_fetch_assoc($query)){
				$barang_id = $row["barang_id"];
				$quantity = $row["quantity"];
				
				mysqli_query($koneksi, "UPDATE barang SET stok=stok-$quantity WHERE barang_id='$barang_id'");
			}
		}
	}

	else if($button == "Delete"){
		mysqli_query($koneksi, "DELETE FROM pesanan WHERE pesanan_id='$pesanan_id'");
	}
	
	header("location:".BASE_URL."index.php?page=my_profile&module=pesanan&action=list");