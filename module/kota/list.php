<?php
       $search = isset($_GET["search"]) ? $_GET["search"] : false;

        $where = "";
        $search_url = "";
        if($search){
            $search_url = "&search=$search";
            $where = "WHERE kota LIKE '%$search%' || kota.tarif LIKE '%$search%'";
        } 
?>

<div id="frame-tambah">
	<div id="left">
        <form action="<?php echo BASE_URL."index.php"; ?>" method="GET">
                <input type="hidden" name="page" value="<?php echo $_GET["page"] ?>" />
                <input type="hidden" name="module" value="<?php echo $_GET["module"] ?>" />
                <input type="hidden" name="action" value="<?php echo $_GET["action"] ?>" />
                <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Ketikan Nama Kota" />
                <input type="submit" value="Search" />
        </form>
    </div>
	<div id="right">	
		<a class="tombol-action" href="<?php echo BASE_URL."index.php?page=my_profile&module=kota&action=form"; ?>">+ Tambah Kota</a>
	</div>
</div>

<?php
    // Cek jika var notif pada url tersedia
	if (isset($_GET['notif'])) {
        echo notifTransaksi($_GET['notif'] ,"Kota");
    }
?>
<?php

	$pagination = isset($_GET["pagination"]) ? $_GET["pagination"] : 1;
	$data_per_halaman = 10;
	$mulai_dari = ($pagination-1) * $data_per_halaman;

	$queryKota = mysqli_query($koneksi, "SELECT * FROM kota $where LIMIT $mulai_dari, $data_per_halaman");
	
	if(mysqli_num_rows($queryKota) == 0){
		echo "<h3>Saat ini belum ada nama kota yang didalam database.</h3>";
	}
	else{
		echo "<table class='table-list'>";
		
			echo "<tr class='baris-title'>
					<th class='kolom-nomor'>No</th>
					<th class='kiri'>Kota</th>
					<th class='kiri'>Tarif</th>
					<th class='tengah'>Status</th>
					<th class='tengah'>Action</th>
				 </tr>";
				 
			$no = 1 + $mulai_dari;
			while($rowKota=mysqli_fetch_assoc($queryKota)){
				echo "<tr>
						<td class='kolom-nomor'>$no</td>
						<td>$rowKota[kota]</td>
						<td>".rupiah($rowKota['tarif'])."</td>
						<td class='tengah'>$rowKota[status]</td>
						<td class='tengah'>
							<a class='tombol-action' href='".BASE_URL."index.php?page=my_profile&module=kota&action=form&kota_id=$rowKota[kota_id]"."'>Edit</a>
							<a class='tombol-action' href='".BASE_URL."module/kota/action.php?button=Delete&kota_id=$rowKota[kota_id]'>Delete</a>
						</td>
					 </tr>";
				
				$no++;
			}
		
		echo "</table>";

		$queryHitungKota= mysqli_query($koneksi, "SELECT * FROM kota $where");
        pagination($queryHitungKota, $data_per_halaman, $pagination, "index.php?page=my_profile&module=kota&action=list$search_url");
	}
?>