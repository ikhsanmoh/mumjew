<?php
    include_once("function/koneksi.php");
    include_once("function/helper.php");

    session_start();

    $kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : false; 

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    $nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : false;
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : false;
    $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
    $totalBarang = count($keranjang);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pencarian</title>

        <link href="<?php echo BASE_URL."css/fontawesome-free-5.13.1-web/css/all.min.css"; ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo BASE_URL."css/style.css"; ?>" type="text/css" rel="stylesheet" />

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
                 $keyword = $_GET["keyword"];
                 $semuadata=array();
                 $ambil = $koneksi->query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR brand LIKE '%$keyword%'");
                //  while($pecah = $ambil->fetch_assoc())
                //  {
                //      $semuadata[]=$pecah;
                //  }
                //  echo "<pre>";
                //  print_r($semuadata);
                //  echo "</pre>"; 
            ?>
            <div id="kanan" style="width: auto;">

                <div id="left" style="padding-left: 120px;">
                    <form action="<?php echo BASE_URL."penulusuran.php"; ?>" method="GET">
                            <input type="text" name="keyword" size="40px" placeholder="Ketikan Nama Barang dan Kategori"/>
                            <button>Search</button>
                    </form>
                    <h3>Hasil Pencarian : <?php echo $keyword ?></h3>
                </div>

                <div id="frame-barang"> 
                     
                     <!-- foreach ($semuadata as $key => $value) {
                         echo 'Data = '. $value[''];
                     } -->
                    <ul>
                        <?php while($pecah = $ambil->fetch_assoc()) { ?>
                          
                            <li>
                                <div>
                                    <p class="brand"><?php echo $pecah['brand']; ?></p>
                                    <p class="price"><?php echo rupiah($pecah['harga']) ?></p>
                                </div>
                                    <a href="<?php //echo BASE_URL.''.$pecah['barang_id'].'/'.$pecah['kategori'].'/'.$pecah['nama_barang'].'html' ?>" >
                                        <img src="<?php echo BASE_URL.'images/barang/'.$pecah['gambar']; ?>" />
                                    </a> 
                                <div class="keterangan-gambar"> 
                                    <p>
                                        <a href="<?php //echo BASE_URL.'$pecah[barang_id]/$kategori/$barang.html' ?>"><?php echo $pecah['nama_barang'] ?></a>
                                    </p>
                                    <span>Stok : <?php echo $pecah['stok']; ?></span>
                                </div>
                                <div class="button-add-cart">
                                    <a href="<?php echo BASE_URL.'tambah_keranjang.php?barang_id='.$pecah['barang_id']; ?>">+ add to cart</a>
                                </div>
                        
                        <?php } ?>
                    </ul>
                        
                </div>

            </div>
            
        </div>    
        <div id="footer">
            <p>copyright Mumtaza Jewerly 2020</p>
        </div>

    </div>

</body>
</html>