<?php
    include("../../function/koneksi.php");   
	include("../../function/helper.php");   
	
	$button = isset($_POST['button']) ? $_POST['button'] : false;
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
    
	$nama = isset($_POST['nama']) ? $_POST['nama'] : false;
	$email = isset($_POST['email']) ? $_POST['email'] : false;
	$phone = isset($_POST['phone']) ? $_POST['phone'] : false;
	$provinsi = isset($_POST['provinsi']) ? $_POST['provinsi'] : false;
	$kota = isset($_POST['kota']) ? $_POST['kota'] : false;
	$kode_pos = isset($_POST['kode_pos']) ? $_POST['kode_pos'] : false;
	$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : false;
	$password = isset($_POST['password']) ? md5($_POST['password']) : false;
    $repassword = isset($_POST['repassword']) ? md5($_POST['repassword']) : false;
    
    // var_dump($user_id, $nama, $email, $phone, $alamat, $password, $repassword);
    // die();

	if ($button == "Update") {
		$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");
		if(mysqli_num_rows($query) == 1){
			header("location: ".BASE_URL."index.php?page=my_profile&module=data_diri&action=form&user_id=$user_id&notif=gagal_update&pesan_err=email_sama");
			die();    
		} else {
            if ($password != $repassword) {
                header("location: ".BASE_URL."index.php?page=my_profile&module=data_diri&action=form&user_id=$user_id&notif=gagal_update&pesan_err=pass_tidak_sama");
			    die();    
            } else {
                $sql = mysqli_query($koneksi, "UPDATE 
                                                user 
                                               SET 
                                                nama='$nama',
                                                email='$email',
                                                phone='$phone',
                                                provinsi='$provinsi',
                                                kota='$kota',
                                                kode_pos='$kode_pos',
                                                alamat='$alamat',
                                                password='$password'
                                                WHERE user_id='$user_id'");
                if ($sql) {
                    header("location: ".BASE_URL."index.php?page=my_profile&module=data_diri&action=form&notif=sukses_update");
                    die(); 									                   
                } else {
                    die('Gagal Update, Terjadi kesalahan pada Query!');
                }
            }
            
		}
	}											   
?>