<?php
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
								$sqlStorageL = "select lantai from penyimpanan where rak=$rak";
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
									'.$b.'
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
									$line=1;
									
									echo'<div class="row">';
									$sql1 = "select * from penyimpanan where lantai='$i'";
									$run1 = mysqli_query($servConnQuery, $sql1);
									while($row1 = mysqli_fetch_assoc($run1)){
										if($row1['baris']==1){
											$txt='C'.$line.'B1';
											$col=boxColor($row1['stock_id']);
											$str=boxColorText($col,$txt);
											$top=$top.$str;
										}
										if($row1['baris']==2){
											$txt='C'.$line.'B2';
											$col=boxColor($row1['stock_id']);
											$str=boxColorText($col,$txt);
											$bot=$bot.$str;
											$line++;
										}
									}
									echo$top.'<div class="w-100"></div>'.$bot;
									
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
					</div>
				</div>
				
				<h4 class="card-title">Daftar Komponen</h4>
				
				<div class="table-responsive">
				<table class="table table-striped table-sm" id="tbComponent">
					<thead>
					<tr>
						<th scope="col">Nama Komponen</th>
						<th scope="col">Jumlah</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$stockQuery = "
						select stock.* , penyimpanan.*
						from stock
						join penyimpanan
						on stock.storage_id = penyimpanan.storage_id
						where penyimpanan.rak = $rak
						order by stock.stock_id desc";
						$stockRun = mysqli_query($servConnQuery, $stockQuery);
						$arr = array();
						
						while($stockFetch = mysqli_fetch_assoc($stockRun)){
							$arr[] = $stockFetch;
						}
						foreach($arr as $data){ ?>
						<tr>
							<td><?php echo $data['stock_name'] ?></td>
							<td><?php echo $data['amount'] ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
				<script>
				$(function(){
					$('#tbComponent').DataTable({
						"scrollY": "50vh",
						"scrollCollapse": true,
						language:{
							url: 'js/id.json'
						}
					});
					$('.dataTables_length').addClass('bs-select');
				})
				</script>