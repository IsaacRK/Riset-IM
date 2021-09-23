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
	
	color-dblue{
		color: #1064AE;
	}
	
	div.content{
		margin-left: 200px;
		padding: 1px;
	}
	
	.sidebar{
		position: fixed;
		margin: 0;
		padding: 0;
		width: 200px;
		height: 100%;
		box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
		overflow: auto;
		background-color: #fff;
		
	}
	
	div.open-menu{
		position: relative;
		display: none;
	}
	
	.sidebar a{
		display:block;
		padding: 16px;
		text-decoration: none;
	}
	
	/*screen less than 767px*/
	@media screen and (max-width: 767px){
		.sidebar{
			position: fixed;
			z-index:10;
			display: none;
		}
		
		div.content{
			margin-left: 0;
			position: relative;
			z-index: 1;
		}
		
		div.open-menu{
			display: block;
		}
		div.open-menu a{
			position: fixed;
			top: .5em;
			left: .5em;
			z-index: 15;
			font-family: 'Nanum Gothic', sans-serif;
			font-size: 30px;
			font-weight: 700;
			width: 40px;
			height: 40px;
			line-height: .9em;
			text-align: center;
			border: .2em solid #888;
			background-color: #fff;
			border-radius: 3em;
			color: #888!important;
		}
		
		.close-menu{
			display: none;
			position: fixed;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			background: rgba(0, 0, 0, .3) 1px 1px repeat;
			z-index: 9;
		}
	}
	</style>
</head>

<body>
<!--
<div class="bg-white sidebar">
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
-->

<div class="open-menu" id="openMenu">
	<p><a>≡</a></p>
</div>

<div class="close-menu" id="closeMenu"></div>

<div class="sidebar" id="sidebar">
	<div class="list-group-item list-group-item-action flex-column align-items-start">
		<div class="row">
			<div class="col-sm">
				<div class="border border-dark rounded-circle m-0" style="width:40px;height:40px;"></div>
			</div>
			<div class="col-sm">
				<p>Username</p>
			</div>
		</div>
	</div>
	</br>
	<a href="" class="list-group-item-action ripple" aria-current="true">Home</a>
	<a href="" class="list-group-item-action ripple" aria-current="true">Stock Input</a>
	<a href="" class="list-group-item-action ripple" aria-current="true">Stock Output</a>
	<a href="" class="list-group-item-action ripple" aria-current="true">Production Planning</a>
	<a href="" class="list-group-item-action ripple" aria-current="true">Setting</a>
</div>

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

<script>
	document.getElementById("openMenu").onclick = function() {buttonSidebarShow()};
	document.getElementById("closeMenu").onclick = function() {sidebarHide()};

	function buttonSidebarShow(){
		var x = document.getElementById("sidebar");
		x.style.display = "block";
		
		var x = document.getElementById("closeMenu");
		x.style.display = "block";
		
		var x = document.getElementById("openMenu");
		x.style.display = "none";
	}
	
	function sidebarHide(){
		var x = document.getElementById("sidebar");
		x.style.display = "none";
		
		var x = document.getElementById("closeMenu");
		x.style.display = "none";
		
		var x = document.getElementById("openMenu");
		x.style.display = "block";
	}
</script>
</body>
</html>