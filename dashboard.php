<?php

//require 'backend/conn.php';
//require 'backend/usersession.php';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="images/favicon.png" type="">
	
	<title>Dashboard</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link href="css/responsive.css" rel="stylesheet" />
	<script src="js/propper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	
	<style>
	body{
		background-color: #e0e2e1
	}
	
	login-container{
		height: 100%;
		width: 100%;
	}
	
	.sidebar{
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		padding: 58px 0 0;
		box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
		width: 240px;
		z-index: 600;
	}
	
	.container-padding{
		padding-left: 10%;
	}
	</style>
</head>

<body>

<nav class="collapse d-lg-block collapse bg-white sidebar">
	<div class="position-sticky">
		<div class="list-group list-group-flush mx-3 mt-4">
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
				<span class="fas fs-chart-area fa-fw me-3">dashbooard</span>
			</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
			<a href="" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">dashbooard</a>
		</div>
	</div>
</nav>

<div class="container container-padding mr-0">

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
					<div class="card-body" style="height:250px;">
					
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
					
					</div>
				</div>
				
				<h4 class="card-title">Activity Record</h4>
				
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

</body>

</html>