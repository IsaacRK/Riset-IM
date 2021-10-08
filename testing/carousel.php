<?php
include"../backend/conn.php";
?>
<html>
<head>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/jquery-ui.css" rel="stylesheet">
<script src="../js/bootstrap.bundle.js"></script>
<script src="../js/jquery3.6.0.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<style>

.color-primary{
	background-color: #1064ae;
}
.color-secondary{
	background-color: #89c5fb;
}
.color-tertiary{
	background-color: #d4dfe9;
}
text-primary{
	color: #1064ae;
}
text-secondary{
	color: #89c5fb;
}
text-tertiary{
	color: #d4dfe9;
}

.rak-box{
	width: 50px;
	height: 50px;
}
.carousel-item{
    min-height: 280px;
}
</style>
</head>
<body>

<div style="width: 400px;height: 200px; background-color:#f0f0f0;">
<div class="container my-3" style="width400px;height:200px;">
    <div id="mapping" class="carousel slide" data-bs-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <li data-bs-target="#mapping" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#mapping" data-bs-slide-to="1"></li>
            <li data-bs-target="#mapping" data-bs-slide-to="2"></li>
        </ol>
        
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row">
					
					<?php
						$mappingQuery = "select * from penyimpanan where lantai = '1' and  baris = '1'";
						$mappingRun = mysqli_query($servConnQuery, $mappingQuery);
						if(mysqli_num_rows($mappingRun) > 0){
							while($mappingFetch = mysqli_fetch_assoc($mappingRun)){
								if($mappingFetch['stock_id']==null){
									echo'
										<div class="col p-1 d-flex justify-content-center">
											<div class="shadow-sm border rounded rak-box color-tertiary">
												'.$mappingFetch['storage_id'].'
											</div>
										</div>
									';
								}else{
									echo'
										<div class="col p-1 d-flex justify-content-center">
											<div class="shadow-sm border rounded rak-box color-primary">
												'.$mappingFetch['storage_id'].'
											</div>
										</div>
									';
								}
							}
						}
					?>
				
					<div class="w-100"></div>
					
					<?php
						$mappingQuery = "select * from penyimpanan where lantai = '1' and  baris = '2'";
						$mappingRun = mysqli_query($servConnQuery, $mappingQuery);
						if(mysqli_num_rows($mappingRun) > 0){
							while($mappingFetch = mysqli_fetch_assoc($mappingRun)){
								if($mappingFetch['stock_id']==null){
									echo'
										<div class="col p-1 d-flex justify-content-center">
											<div class="shadow-sm border rounded rak-box color-tertiary">
												'.$mappingFetch['storage_id'].'
											</div>
										</div>
									';
								}else{
									echo'
										<div class="col p-1 d-flex justify-content-center">
											<div class="shadow-sm border rounded rak-box color-primary">
												'.$mappingFetch['storage_id'].'
											</div>
										</div>
										';
								}
							}
						}
					?>
					
				</div>
            </div>
            <div class="carousel-item">
                <div class="row">
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
				
					<div class="w-100"></div>
					
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
				</div>
            </div>
            <div class="carousel-item">
                <div class="row">
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
				
					<div class="w-100"></div>
					
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
					<div class="col p-1 d-flex justify-content-center">
						<div class="shadow-sm border rounded rak-box color-tertiary"></div>
					</div>
				</div>
            </div>
        </div>

        <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#mapping" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#mapping" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
</div>

</body>