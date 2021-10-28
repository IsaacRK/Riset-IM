<?php
include "loader.html";
?>
<style>	
.sidebar > a:hover,.sidebar > a:focus{
	color: #1064ae!important;
}
.currentPage{
	background-color: #fff!important;
	color: #1064ae!important;
}
</style>
<div class="open-menu" id="openMenu">
	<p><a>≡</a></p>
</div>

<div class="close-menu" id="closeMenu"></div>

<div class="sidebar" id="sidebar">
	<div id="demo"></div>
	<div class="list-group-item list-group-item-action flex-column align-items-start color-secondary">
		<div class="row">
			<div class="col-sm">
				<div class="border border-dark rounded-circle m-0" style="width:40px;height:40px;"></div>
			</div>
			<div class="col-sm">
				<a href ="editprofile.php">

				<p class="font-weight-bold text-primary text-left"><?php echo $username; ?></p>			</div>
</a>
			</div>
	</div>
	</br>
	<a href="dashboard.php" id="beranda" class="list-group-item-action ripple text-light active" aria-current="true">Halaman Beranda</a>
	<a href="stockinput.php" id="masuk" class="list-group-item-action ripple text-light" aria-current="true">Barang Masuk</a>
	<a href="stockoutput.php" id="keluar" class="list-group-item-action ripple text-light" aria-current="true">Barang Keluar</a>
	<a href="" class="list-group-item-action ripple text-light" aria-current="true">Rencana Produksi</a>
	<a href="" class="list-group-item-action ripple text-light" aria-current="true">Pengaturan</a>
</div>

<script>
	let linkStr = window.location.href;
	let urlTxt = linkStr.split("/").pop();
	
	if(urlTxt == "dashboard.php"){
		document.getElementById("beranda").className = "currentPage";
	}
	if(urlTxt == "stockinput.php"){
		document.getElementById("masuk").className = "currentPage";
	}
	if(urlTxt == "stockoutput.php"){
		document.getElementById("keluar").className = "currentPage";
	}
</script>