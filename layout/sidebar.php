<?php
include "loader.html";
require 'backend/conn.php';
require 'backend/usersession.php';
$Foto_ID = $_SESSION["uid"];
$Foto_01 = "select * from Image where user_id = '$Foto_ID'";
$Foto_02 = mysqli_query($servConnQuery, $Foto_01);
@$Foto_03 = mysqli_fetch_assoc($Foto_02);
@$Foto_04 = mysqli_num_rows($Foto_02);
if($Foto_04 == null){
$Foto_05 = "default-user.jpg";
} else{
$Foto_05 = $Foto_03['filename'];
}

?>
<style>	
.sidebar > a:hover,.sidebar > a:focus{
	color: #1064ae!important;
}
.currentPage{
	background-color: #fff!important;
	color: #1064ae!important;
}
.profile{
	object-fit: cover;
	width:50px;
	height:50px;
	border-radius:50%;
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
			<div class="col-sm col-4 align-self-center">
  				 <?php echo "<img src='Photo/$Foto_05' class='profile'>" ?>
			</div>
			<div class="col-sm col-6 text-center align-self-center">
				<a href ="editprofile.php">

				<p class="font-weight-bold text-primary text-left" style="margin-bottom:0!important;"><?php echo $username; ?></p>			
				<p class="text-primary" style="margin-bottom:0!important"><small><?php echo $userlvl; ?></small></p>	
				</div>
</a>
			</div>
	</div>
	</br>
	<a href="dashboard.php" id="beranda" class="list-group-item-action ripple text-light active" aria-current="true">Halaman Beranda</a>
<?php
	if($userlvl != 'supervisor'){
	echo '<a href="stockinput.php" id="masuk" class="list-group-item-action ripple text-light" aria-current="true">Barang Masuk</a>';
	}else{}
	if($userlvl != 'supervisor'){
	echo '<a href="stockoutput.php" id="keluar" class="list-group-item-action ripple text-light" aria-current="true">Barang Keluar</a>';
	}else{}
	if($userlvl != 'staff' || 'operator'){
	echo '<a href="" class="list-group-item-action ripple text-light" aria-current="true">Rencana Produksi</a>';
	}else{}
?>
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
