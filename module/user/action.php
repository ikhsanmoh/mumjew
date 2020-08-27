<?php
    include("../../function/koneksi.php");   
	include("../../function/helper.php");   
	
	$button = isset($_POST['button']) ? $_POST['button'] : $_GET['button'];
	$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
	
	$nama = isset($_POST['nama']) ? $_POST['nama'] : false;
	$email = isset($_POST['email']) ? $_POST['email'] : false;
	$phone = isset($_POST['phone']) ? $_POST['phone'] : false;
	$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : false;
	$level = isset($_POST['level']) ? $_POST['level'] : false;
	$status = isset($_POST['status']) ? $_POST['status'] : false;

	if ($button == "Update") {
		$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");
		if(mysqli_num_rows($query) == 1){
			header("location: ".BASE_URL."index.php?page=my_profile&module=user&action=form&notif=n_email&user_id=$user_id&notif=gagal_update");
			die();    
		} else {
		mysqli_query($koneksi, "UPDATE user SET nama='$nama',
											   email='$email',
											   phone='$phone',
											   alamat='$alamat',
											   level='$level',
											   status='$status'
											   WHERE user_id='$user_id'");
		header("location: ".BASE_URL."index.php?page=my_profile&module=user&action=list&notif=sukses_update");
		die(); 									   
		}
	}											   

	else if($button == "Delete"){
		mysqli_query($koneksi, "DELETE FROM user WHERE user_id='$user_id'");
		header("location: ".BASE_URL."index.php?page=my_profile&module=user&action=list&notif=sukses_delete");
            die(); 
	}

    header("location: ".BASE_URL."index.php?page=my_profile&module=user&action=list&notif=sukses");
?>