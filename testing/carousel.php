<?php
include"../backend/conn.php";
?>
<html>
<head>
<?php include"../layout/header.php";?>
<head>
<body>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
  Open modal
</button>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Penggunaan Website</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
		<!-- Carousel -->
		<div id="demo" class="carousel slide" data-bs-ride="carousel">

		  <!-- Indicators/dots -->
		  <div class="carousel-indicators">
			<button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
			<button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
			<button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
		  </div>

		  <!-- The slideshow/carousel -->
		  <div class="carousel-inner">
			<div class="carousel-item active">
			  <img src="https://cdn.pixabay.com/photo/2018/08/15/13/10/galaxy-3608029__340.jpg" alt="Los Angeles" class="d-block w-100">
			</div>
			<div class="carousel-item">
			  <img src="https://media.istockphoto.com/photos/planet-earth-from-the-space-at-night-picture-id1271122894?b=1&k=20&m=1271122894&s=170667a&w=0&h=IGczVHxn-c0qpV5LGPUDZVbJfTpD7ZMc0G1ROuNsQS4=" alt="Chicago" class="d-block w-100">
			</div>
			<div class="carousel-item">
			  <img src="https://cbsnews3.cbsistatic.com/hub/i/r/2021/08/02/ad96efb4-2405-4b26-a093-41993790fc6c/thumbnail/640x637/166bb875d83de6a901c48b798342d0e8/eaglenebula.jpg" alt="New York" class="d-block w-100">
			</div>
		  </div>

		  <!-- Left and right controls/icons -->
		  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		  </button>
		  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
		  </button>
		</div>
		
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>

<script>
</script>
</body>
</html>