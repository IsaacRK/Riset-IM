<?php
include 'loader.html';
require 'backend/conn.php';
$userlvl = ''; $username = '';
require 'backend/usersession.php';
$Foto_ID = $_SESSION["uid"];
$Foto_01 = "select * from image where user_id = '$Foto_ID'";
$Foto_02 = mysqli_query($servConnQuery, $Foto_01);
$Foto_03 = mysqli_fetch_assoc($Foto_02);
$Foto_04 = mysqli_num_rows($Foto_02);
if($Foto_04 == null){
$Foto_05 = "default-user.jpg";
} else{
$Foto_05 = $Foto_03['filename'];
}

?>


<div class="mt-2">
		<button class="openbtn" onclick="openNav()">☰</button>
</div>


<div id="mySidepanel" class="sidepanel">
  
    <div class="row" style="background:white;">
         
         <div class="col-5 align-self-center my-2">
             <a href='Profile.php'><img src='Photo/<?php echo$Foto_05; ?>' class='profile'></a>
         </div>
         <div class="col-5 text-center align-self-center my-2">
             <a href='Profile.php' class="sdnm">
                 <!--<div class="border rounded-start my-0 ms-1 p-1">-->
                     <p class="nmsz font-weight-bold text-primary text-left mb-0"><b><?php echo $username; ?></b></p>
                     <p class="nmsz text-primary" style="margin-bottom:0!important"><small><?php echo $userlvl; ?></small></p>
                 <!--</div>-->
             </a>
         </div>
         <div class="col-2 text-center">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
         </div>

    </div>
	<?php
	if($userlvl == 'supervisor'){}
	else if($userlvl == 'procurement'){}
	else{
	?>
    <a href="dashboard.php" id="beranda" class="list-group-item-action ripple text-light active" aria-current="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
            </svg> Beranda
    </a>
    <?php
	}
	if($userlvl == 'supervisor'){}
	else if($userlvl == 'procurement'){}
	else{
	?>
	<a href="stockInput.php" id="masuk" class="list-group-item-action ripple text-light" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
		</svg> Stok Masuk
	</a>
	 <?php
	}
	if($userlvl == 'supervisor'){}
	else if($userlvl == 'procurement'){}
	else{
	?>
	<a href="stockoutput.php" id="keluar" class="list-group-item-action ripple text-light" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
		</svg> Stok Keluar
	</a>
	<?php
	}
	if($userlvl == 'staff'){
	}else if($userlvl == 'operator'){
	}else if($userlvl == 'procurement'){
	}else{
	?>
	<a href="rencana.php" class="list-group-item-action ripple text-light" id="rencana" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
			<path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
			<path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
		</svg> Dashboard
	</a>
	<a href="prediksi.php" class="list-group-item-action ripple text-light" id="prediksi" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
		  <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
		</svg> Prediksi
	</a>
	<?php
	}
	?>
	<?php
	if($userlvl == 'staff'){
	}else if($userlvl == 'operator'){
	}else{	
	?>
	<a href="Pembelian.php" class="list-group-item-action ripple text-light" id="pembelian" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
		<path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
		</svg> Pembelian
	</a>
	<?php 
	}
	?>
	<a href="akutansi.php" id="Akutansi" class="list-group-item-action ripple text-light" aria-current="true">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
  		<path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
		</svg> Pengaturan Harga
    	</a>
	<a href="penyimpanan.php" id="pengaturan" class="list-group-item-action ripple text-light" aria-current="true">
		    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
			<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
			<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
		    </svg> Pengaturan
    	</a>
    	<a href="logout.php" class="list-group-item-action ripple text-light" aria-current="true">
		    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
			<path d="M7.5 1v7h1V1h-1z"/>
			<path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
		    </svg> Keluar
    	</a>

</div>  


<script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
	let linkStr = window.location.href;
	let urlTxt = linkStr.split("/").pop();
	
	if(urlTxt == "dashboard.php"){
		document.getElementById("beranda").className = "currentPage";
	}
	if(urlTxt == "stockInput.php"){
		document.getElementById("masuk").className = "currentPage";
	}
	if(urlTxt == "stockoutput.php"){
		document.getElementById("keluar").className = "currentPage";
	}
	if(urlTxt == "rencana.php"){
		document.getElementById("rencana").className = "currentPage";
	}
	if(urlTxt == "prediksi.php"){
		document.getElementById("prediksi").className = "currentPage";
	}
	if(urlTxt == "akutansi.php"){
	document.getElementById("Akutansi").className = "currentPage";
	}
	if(urlTxt == "pengaturan.php"){
		document.getElementById("pengaturan").className = "currentPage";
	}
	if(urlTxt == "Pembelian.php"){
		document.getElementById("pembelian").className = "currentPage";
	}
</script>

