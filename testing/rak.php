<?php
include'../backend/conn.php';
include'../layout/header.php';
###################################
##====| archive rak carousel |===##
###################################
/*
include'../backend/conn.php';
$rak=1;
if(isset($_GET['rak'])){
	$rak = $_GET['rak'];
}
?>

<div class="card">
	<div class="card-body px-0" style="background-color:#2879ff73;">
		<div class="container p-0" style="height:200px">
		
		<!--carousel open-->
		<div id="mapping" class="carousel slide carousel-dark h-100" data-bs-ride="carousel">
			<!-- Carousel indicators -->
			<ol class="carousel-indicators">
				<?php
				$queryNum=0;
				$arrLan=array();
				$sqlStorageL = "select lantai from penyimpanan where rak='$rak'";
				$runStorageL = mysqli_query($servConnQuery, $sqlStorageL);
				while($fetchL=mysqli_fetch_assoc($runStorageL)){
					$a=$fetchL['lantai'];
					if(in_array($a,$arrLan)){
					}else{
						array_push($arrLan,$a);
					}
				}
				$queryNum = count($arrLan);
				
				for($i=0;$i<$queryNum;$i++){
					if($i==0){
						echo'
						<li data-bs-target="#mapping" data-bs-slide-to="'.$i.'" class="active"></li>
						';
					}else{
						echo'<li data-bs-target="#mapping" data-bs-slide-to="'.$i.'"></li>
						';
					}
				}
				?>
			</ol>
			<div class="carousel-inner">
			<?php
				
				function boxColor($fetch){
					if($fetch==null){
						$col='color-tertiary';
					}else{
						$col='color-primary text-light';
					}
					return($col);
				}
				function boxColorText($a,$b){
					$string = '
					<div class="col p-1 d-flex justify-content-center">
					<div class="shadow-sm border rounded rak-box text-center '.$a.'">
					<div style="margin-top:25%;">'.$b.'</div>
					</div>
					</div>';
					return ($string);
				}
				
				for($i=1;$i<=$queryNum;$i++){
					if($i==1){
						echo'
						<div class="carousel-item active">
						';
					}else{
						echo'
						<div class="carousel-item">
						';
					}
					
					//isi
					$top='';
					$bot='';
					
					echo'<div class="row">';
					$sql1 = "select * from penyimpanan where lantai='$i' and rak='$rak' ORDER BY kolom ASC, baris ASC";
					$run1 = mysqli_query($servConnQuery, $sql1);
					while($row1 = mysqli_fetch_assoc($run1)){
						if($row1['baris']==1){
							$txt='C'.$row1['kolom'].'B1';
							$col=boxColor($row1['stock_id']);
							$str=boxColorText($col,$txt);
							$top=$top.$str;
						}
						if($row1['baris']==2){
							$txt='C'.$row1['kolom'].'B2';
							$col=boxColor($row1['stock_id']);
							$str=boxColorText($col,$txt);
							$bot=$bot.$str;
						}
					}
					echo$top.'</div><div class="row">'.$bot;
					
					echo'
						</div>
						<div class="carousel-caption d-md-block" style="position:static!important">
							<h5>Lantai '.$i.'</h5>
						</div>
						</div>
					';
				}
				
			?>						
			</div>
			<a class="carousel-control-prev" href="#mapping" data-bs-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#mapping" data-bs-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
		<!--carousel close-->
		
		</div>
		
		<div class="row fw-semi-bold m-0 justify-content-md-center">
			<span class="col-auto m-1 mr-2">
				<span class="color-primary rounded-circle p-1 border border-dark" style="display:inline-block;">
					<span class="visually-hidden">penuh</span>
				</span>
				Penuh
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="color-tertiary rounded-circle p-1 border border-dark" style="display:inline-block;">
					<span class="visually-hidden">Kosong</span>
				</span>
				Kosong
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="badge bg-light text-dark">C</span>
				Kolom
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="badge bg-light text-dark">B</span>
				Baris
			</span>
		</div>
		
	</div>
</div>
*/




$rak=1;
if(isset($_GET['rak'])){
	$rak = $_GET['rak'];
}
?>
<div class="card">
	<div class="card-body px-0" style="background-color:#2879ff73;">
		<?php								
			function boxColor($fetch){
				if($fetch==null){
					$col='color-tertiary';
				}else{
					$col='color-primary text-light';
				}
				return($col);
			}
			
			function boxColorText($a,$b){
				$string = '
				<div class="col p-1 d-flex justify-content-center">
				<div class="shadow-sm border rounded rak-box text-center '.$a.'">
				<div style="margin-top:25%;">'.$b.'</div>
				</div>
				</div>';
				return ($string);
			}
			
			$queryNum=0;
			$arrLan=array();
			$sqlStorageL = "select lantai from penyimpanan where rak='$rak'";
			$runStorageL = mysqli_query($servConnQuery, $sqlStorageL);
			while($fetchL=mysqli_fetch_assoc($runStorageL)){
				$a=$fetchL['lantai'];
				if(in_array($a,$arrLan)){
				}else{
					array_push($arrLan,$a);
				}
			}
			$queryNum = count($arrLan);
			
			for($i=1;$i<=$queryNum;$i++){
				
				//isi
				$top='';
				$bot='';
				
				echo'<div class="row">';
				$sql1 = "select * from penyimpanan where lantai='$i' and rak='$rak' ORDER BY kolom ASC, baris ASC";
				$run1 = mysqli_query($servConnQuery, $sql1);
				while($row1 = mysqli_fetch_assoc($run1)){
					if($row1['baris']==1){
						$txt='C'.$row1['kolom'].'B1';
						$col=boxColor($row1['stock_id']);
						$str=boxColorText($col,$txt);
						$top=$top.$str;
					}
					if($row1['baris']==2){
						$txt='C'.$row1['kolom'].'B2';
						$col=boxColor($row1['stock_id']);
						$str=boxColorText($col,$txt);
						$bot=$bot.$str;
					}
				}
				echo$top.'</div><div class="row text-middle">'.$bot;
				
				echo'
					<h5>Lantai '.$i.'</h5>
					<hr></hr>
				';
			}
			
		?>
		</div>
		
		<div class="row fw-semi-bold m-0 justify-content-md-center">
			<span class="col-auto m-1 mr-2">
				<span class="color-primary rounded-circle p-1 border border-dark" style="display:inline-block;">
					<span class="visually-hidden">penuh</span>
				</span>
				Penuh
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="color-tertiary rounded-circle p-1 border border-dark" style="display:inline-block;">
					<span class="visually-hidden">Kosong</span>
				</span>
				Kosong
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="badge bg-light text-dark">C</span>
				Kolom
			</span>
			
			<span class="col-auto m-1 mr-2">
				<span class="badge bg-light text-dark">B</span>
				Baris
			</span>
		</div>
		
	</div>
</div>
</div>