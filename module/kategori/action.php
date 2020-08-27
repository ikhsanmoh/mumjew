<?php

    include_once("../../function/koneksi.php");
    include_once("../../function/helper.php");

    admin_only("kategori", $level);
    
    $button = isset($_POST['button']) ? $_POST['button'] : $_GET['button'];
    $kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : "";

    $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : "";
    $status = isset($_POST['status']) ? $_POST['status'] : "";

    // Nilai Default Notif
    $status_notif = "";
    
    if($button == "Add"){
        //keterangan mengecek data kategori yang sudah ada
        $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori='$kategori'");
        if(mysqli_num_rows($query) == 1){
            $status_notif = "gagal_add"; // Status Notif Handle
            header("location: ".BASE_URL."index.php?page=my_profile&module=kategori&action=form&notif=$status_notif");
            die();    
        } else {
            mysqli_query($koneksi, "INSERT INTO kategori (kategori, status) VALUES ('$kategori', '$status')");
        }
        //=====//
    }else if($button == "Update"){
        $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori='$kategori'");
        if(mysqli_num_rows($query) == 1){
            $status_notif = "gagal_update"; // Status Notif Handle
            header("location: ".BASE_URL."index.php?page=my_profile&module=kategori&action=form&notif=$status_notif");
            die();    
        } else {
            $kategori_id = $_GET['kategori_id'];
            mysqli_query($koneksi, "UPDATE kategori SET kategori='$kategori',
                                                        status='$status' WHERE kategori_id='$kategori_id'");
            $status_notif = "sukses_update"; // Status Notif Handle
            header("location: ".BASE_URL."index.php?page=my_profile&module=kategori&action=list&notif=$status_notif");
            die();
        } 

    }
    else if($button == "Delete"){
        mysqli_query($koneksi, "DELETE FROM kategori WHERE kategori_id='$kategori_id'");
        $status_notif = "sukses_delete"; // Status Notif Handle
        header("location: ".BASE_URL."index.php?page=my_profile&module=kategori&action=list&notif=$status_notif");
        die();
    }

    header("location:".BASE_URL."index.php?page=my_profile&module=kategori&action=list&notif=sukses_add");
?>