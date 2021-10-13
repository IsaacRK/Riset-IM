<?php?>
<div class="open-menu" id="openMenu">
	<p><a>≡</a></p>
</div>

<div class="close-menu" id="closeMenu"></div>

<div class="sidebar" id="sidebar">
	<div class="list-group-item list-group-item-action flex-column align-items-start color-secondary">
		<div class="row">
			<div class="col-sm">
				<div class="border border-dark rounded-circle m-0" style="width:40px;height:40px;"></div>
			</div>
			<div class="col-sm">
				<p class="font-weight-bold text-primary text-left"><?php echo $username; ?></p>			</div>
		</div>
	</div>
	</br>
	<a href="dashboard-id.php" class="list-group-item-action ripple text-light" aria-current="true">Halaman Beranda</a>
	<a href="stockinput-id.php" class="list-group-item-action ripple text-light" aria-current="true">Stok Masuk</a>
	<a href="stockoutput-id.php" class="list-group-item-action ripple text-light" aria-current="true">Stok Keluar</a>
	<a href="" class="list-group-item-action ripple text-light" aria-current="true">Rencana Produksi</a>
	<a href="" class="list-group-item-action ripple text-light" aria-current="true">Pengaturan</a>
</div>