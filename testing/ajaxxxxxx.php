<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
	include'../layout/header.php';
  ?>
</head>
<body>

<div class="container mt-3">
  <h2>Accordion Example</h2>
  <p><strong>Note:</strong> The <strong>data-bs-parent</strong> attribute makes sure that all collapsible elements under the specified parent will be closed when one of the collapsible item is shown.</p>
  <div id="accordion">
    <div class="card">
      <div class="card-header" data-bs-toggle="collapse" href="#collapseOne">
        <a class="btn">
          Collapsible Group Item #1
        </a>
      </div>
      <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
        <div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
        Collapsible Group Item #2
      </a>
      </div>
      <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
        <div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </div>
      <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
        <div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
      </div>
    </div>
  </div>
</div>

<div class="table-responsive">
<table class="table" id="collapseParent">
	<thead>
		<th>Nama Stok</th>
		<th>Jumlah</th>
		<th>Prediksi Stok Keluar</th>
		<th>Prediksi Pergeseran Harga</th>
	</thead>
	<tbody>
	<?php for($x=0;$x<=5;$x++){?>
	<tr data-bs-toggle="collapse" href="#collapse<?php echo $x; ?>">
		<td>Nunc posuere risus at nisl faucibus</td>
		<td>Nunc posuere risus at nisl faucibus</td>
		<td>Nunc posuere risus at nisl faucibus</td>
		<td>Nunc posuere risus at nisl faucibus</td>
	</tr>
	<tr>
		<td colspan=4 style="padding:0!important">
			<div id="collapse<?php echo $x; ?>" class="collapse" data-bs-parent="#collapseParent">
				<div class="row">
					<div class="col-6">
						chart barang keluar
					</div>
					<div class="col-6">
						chart harga barang
					</div>
				</div>
			</div>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>
</div>

<div class="card">
	<div class="card-header" data-bs-toggle="collapse" href="#collapsex">
	<a class="btn">
		Collapsible Group Item #1
	</a>
	</div>
	<div id="collapsex" class="collapse show" data-bs-parent="#accordion">
		<div class="card-body">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		</div>
	</div>
</div>

</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>

</body>
</html>
