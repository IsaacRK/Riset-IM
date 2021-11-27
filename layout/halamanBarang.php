<?php
include'../backend/conn.php';
$rak=1;
if(isset($_GET['rak'])){
	$rak = $_GET['rak'];
}
?>

<div class="card">
	<!--<div class="card-body px-0 overflow-auto" style="background-color:#2879ff73;">-->
	<div class="card-body px-0 overflow-auto" style="background-color:#C2C2C2;">
		<?php								
			function boxColor($fetch){
				if($fetch==null){
					//$col='color-tertiary';
					$col='bg-light';
				}else{
					$col='color-danger text-light';
				}
				return($col);
			}
			
			function boxColorText($a,$b){
				$string = '
				<div class="col-auto p-1 d-flex justify-content-center">
					<div class="shadow-sm border rounded rak-box text-center '.$a.'">
					<div style="">'.$b.'</div>
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
			
			for($i=$queryNum;$i>=1;$i--){
				
				//isi
				$top='';
				$bot='';
				
				$sql1 = "select * from penyimpanan where lantai='$i' and rak='$rak' ORDER BY kolom ASC, baris ASC";
				$run1 = mysqli_query($servConnQuery, $sql1);
				while($row1 = mysqli_fetch_assoc($run1)){
					if($row1['baris']==1){
						$txt='C'.$row1['kolom'];
						$col=boxColor($row1['stock_id']);
						$str=boxColorText($col,$txt);
						$top=$top.$str;
					}
					if($row1['baris']==2){
						$txt='C'.$row1['kolom'];
						$col=boxColor($row1['stock_id']);
						$str=boxColorText($col,$txt);
						$bot=$bot.$str;
					}
				}
				
				if($top!=''){
					$top = '
						<div class="col-auto d-flex justify-content-center text-center pl-4 mt-2">
							<b>B1</b>
						</div>'.$top;
				}
				if($bot!=''){
					$bot = '
						<div class="col-auto d-flex justify-content-center text-center pl-4 mt-2">
							<b>B2</b>
						</div>'.$bot;
				}
				
				//print
				echo'
				<div class="card m-3">
					<div class="card-body m-1 p-1" style="background-color:#DBDBDB;">
					<div class="w-100 text-center"><h5>Lantai '.$i.'</h5></div>
						<div class="row d-flex justify-content-center">
							'.$top.'
						</div>
						<div class="row d-flex justify-content-center">
							'.$bot.'
						</div>
					</div>
				</div>
				';
			}
			
		?>
		
		<div class="row fw-semi-bold m-0 justify-content-md-center">
			<span class="col-auto m-1 mr-2">
				<span class="color-danger rounded-circle p-1 border border-dark" style="display:inline-block;">
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
				
				<h4 class="card-title">Daftar komponen</h4>
				
				<div class="table-responsive">
				<table class="table table-striped table-sm" id="tbComponent">
					<thead>
					<tr>
						<th scope="col">Nama komponen</th>
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
						where penyimpanan.rak = '$rak'
						order by stock.stock_id asc limit 5";
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
				});
				</script>
