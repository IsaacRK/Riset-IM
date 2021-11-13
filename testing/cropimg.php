<?php?>
<html>
<head>
	<?php include'../layout/header.php';?>
	<link rel="stylesheet" href="css/croppie.css" />
	<script src="js/croppie.js"></script>
	<style>
		#cropieDiv{
			width: 350px;
		}
		#croppieContainer{
			padding-top: 30px;
		}
		#croppieView{
			background: #e1e1e1;
			width: 300px;
			padding: 30px;
			height: 30px;
			margin-top: 30px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 text-center">
				<!--img-->
				<div id="cropieDiv"></div>
				<!--img-->
			</div>
			<div class="col-md-4" id="croppieContainer">
				<strong>aaAAaa</strong>
				</br>
				<input type="file" id="croppie-input">
				</br>
				<button class="btn btn-success croppie-upload">uploadAAAAA</button>
			</div>
			<div class="col-md-4">
				<div id="croppieView"></div>
			</div>
		</div>
	</div>
<script>
	var div = $('#cropieDiv').croppie({
		enableOrientation: true,
		viewport: {
			width: 250,
			height: 250,
			type: 'circle'
		},
		boundary: {
			width: 300,
			height: 300
		}
	});
	
	$('#croppie-input').on('change', function(){
		var reader = new FileReader();
		reader.onload = function(e){
			div.croppie('bind', {
				url: e.target.result
			});
		}
		reader.readAsDataURL(this.files[0]);
	});
	
	$('.croppie-upload').on('click', function(ev){
		div.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(image){
			$.ajax({
				url: "croppieupload.php",
				type: "post",
				data:{
					'image' : image
				},
				success: function(data){
					html = '<img src="'+image+'"/>';
					$("#croppieView").html(html);
				}
			});
		});
	});
</script>
</body>
</html>