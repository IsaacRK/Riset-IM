<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>
<!DOCTYPE html>
<html>

<head>
	<title>Dashboard</title>
	<?php include"layout/header.php"?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Home Dashboard</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Arduino
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				  </div>
				</div>
			
				</br>
				
				<div class="card">
					<div class="card-body" style="">
						<div class="row">
						<div class="container mx-5 overflow-auto">
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

						<div class="row">
						<div class="container mx-5">
						<div class="row">
							<div class="col">
								<div class="row mt-2">
								<div class="col pr-0 d-flex justify-content-center">
									<div class="shadow-sm border rounded rak-box color-tertiary m-0"></div>
								</div>
								<div class="col pl-0">
									<p class="align-middle m-0 pt-2">Free Space</p>
								</div>
								</div>
							</div>
							<div class="col">
								<div class="row mt-2">
								<div class="col pr-0 d-flex justify-content-center">
									<div class="shadow-sm border rounded rak-box color-primary m-0"></div>
								</div>
								<div class="col pl-0">
									<p class="align-middle m-0 pt-2">Full</p>
								</div>
								</div>
							</div>
						</div>
						</div>
						</div>
						
					</div>
				</div>
				
				<h4 class="card-title">Component list</h4>
				
				<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">name of component</th>
						<th scope="col">stock</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>500</td>
					</tr>
					</tbody>
				</table>
			
			</div>
			</div>
		</div>
		
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Arduino
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				  </div>
				</div>
			
				</br>
			
				<div class="card">
					<div class="card-body" style="height:250px;">
						<canvas id="line-chart" style=""></canvas>
					</div>
				</div>
				
				<h4 class="card-title">Activity Record</h4>
				
				<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">name of component</th>
						<th scope="col">date</th>
						<th scope="col">requester</th>
						<th scope="col">quantity</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>arduino nano</td>
						<td>13/09</td>
						<td>anon</td>
						<td>5</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>13/09</td>
						<td>anon</td>
						<td>5</td>
					</tr>
					<tr>
						<td>arduino nano</td>
						<td>13/09</td>
						<td>anon</td>
						<td>5</td>
					</tr>
					</tbody>
				</table>
				</div>
			
			</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php
	include"layout/js.php";
?>

</body>
</html>