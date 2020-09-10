<?php

    session_start();

    include_once("function/koneksi.php");
    include_once("function/helper.php");


    $page = isset($_GET['page']) ? $_GET['page'] : false; 
    $kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : false; 

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    $nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : false;
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : false;
    $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
    $totalBarang = count($keranjang);

    // Menarik data API
    $list_provinsi = curl_get('https://api.rajaongkir.com/starter/province');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Mumtaza Jewerly | Toko Emas</title>

        <link href="<?php echo BASE_URL."css/fontawesome-free-5.13.1-web/css/all.min.css"; ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo BASE_URL."css/style.css"; ?>" type="text/css" rel="stylesheet" />
		<link href="<?php echo BASE_URL."css/banner.css"; ?>" type="text/css" rel="stylesheet" />
		
		<script src="<?php echo BASE_URL."js/jquery-3.1.1.min.js"; ?>"></script>
		<script src="<?php echo BASE_URL."js/Slides-SlidesJS-3/source/jquery.slides.min.js"; ?>"></script>
		<script src="<?php echo BASE_URL."js/script.js"; ?>"></script>
		
		<script>
		$(function() {
			$('#slides').slidesjs({
				height: 350,
				play: { auto : true,
					    interval : 3000
					  },
				navigation : false
			});
		});
		</script>		

</head>
<body>
    
    <div id="container">
        <div id="header">
            <a href="<?php echo BASE_URL."index.php"; ?>">
                <img src="<?php echo BASE_URL."images/logo.png"; ?>"/>
            </a>

            <div id="menu">
                <div id="user">
                    <?php
                        if($user_id){
                            echo "Hi <b>$nama</b>, 
                                  <a href='".BASE_URL."index.php?page=my_profile&module=pesanan&action=list'>My Profile</a>
                                  <a href='".BASE_URL."logout.php'>Logout</a>";
                        }else{
                            echo "<a href='".BASE_URL."login.html'>Login</a>
                                  <a href='".BASE_URL."register.html'>Register</a>";
                        }
                    ?>
                    
                </div>
                <a href="<?php echo BASE_URL."keranjang.html"; ?>" id="button-keranjang">
                    <img src="<?php echo BASE_URL."images/cart.png"; ?>"/>
                    <?php
                        if($totalBarang != 0){
                            echo "<span class='total-barang'>$totalBarang</span>";
                        }
                    ?>
                </a>
            </div>        
        </div>

        <div id="content">
            <?php
                $filename = "$page.php";

                if(file_exists($filename)){
                    include_once($filename);
                }else{
                    include_once("main.php");
                }
            ?>
        </div>
        
        <div id="datacont">

        </div>
        
        <div id="footer">
            <p>copyright Mumtaza Jewerly 2020</p>
        </div>

    </div>

    <?php
        if (isset($_GET['add_status'])) {
            echo "
            <script>
            $(document).ready(function(){
                alert('Berhasil memasukan barang ke keranjang')
                window.history.replaceState({}, document.title, '/' + 'index.php')
            })
            </script>";
        }
    ?>

<!-- JS Manual -->

<script>

    // Menghilangkan Notif dalam interval waktu tertentu
    $('#notif').delay(3000).fadeOut(300);

    function get_ongkir($id_kota_tujuan) {
        const xhr = new XMLHttpRequest();
        var res;

        // Get Ongkir - Response Handler
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("demo").innerHTML = this.responseText;
            }
        };

        // Get Ongkir - Set Request
        xhr.open("GET", "request/get_ongkir.php", true);
        xhr.send();
    }

    // Fungsi untuk mengcek ongkos kirim
    function cek_ongkir() {
        alert("Proses Cek Ongkir");
        const xhr = new XMLHttpRequest();
        const nama_provinsi_tujuan = document.querySelector('#kota_tujuan').value;
        var res, id_kota_tujuan;


        // Get id Kota - Response Handler
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                res = JSON.parse(this.responseText);
                
                // document.querySelector('#datacont').innerHTML = res.rajaongkir.results[0].province;
                for(key in res.rajaongkir.results) {
                    if (res.rajaongkir.results[key]['province'] == nama_provinsi_tujuan) {                 
                        console.log(
                            res.rajaongkir.results[key]['province_id'], 
                            res.rajaongkir.results[key]['province']
                        );
                        id_kota_tujuan = res.rajaongkir.results[key]['province_id'];
                    }
                }

                // Get ongkir
                get_ongkir(id_kota_tujuan);
            }
        };

        // Get id Kota - Set Request
        xhr.open("GET", "request/get_list_provinsi.php", true);
        xhr.send();
    }

    // function cek_jangkauan_kurir() {
    //     alert('Berhasil');
    // }

//   function ubah_list_kota() {
//     const xhr = new XMLHttpRequest();
//     xhr.open('GET', 'https://kodepos-2d475.firebaseio.com/list_kotakab/.json')
//     alert('Berhasil');
//   }

</script>

</body>
</html>