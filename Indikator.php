<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
			header('location:Verifyno.php');
}else{}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Indikator Performa</title>
        <?php include 'layout/header.php';?>
    </head>
    <body>
        <?php include 'layout/sidebar-old.php';?>

        <div class="content">
        <div class="container mr-0">

            <div class="p-1 mb-3">
            <div class="row">
                <div>
                    <h1>Indikator Performa</h1>
                </div>
            </div>
            </div>

            <div class="card shadow-sm">
	        <div class="card-body">

                <div class="row text-center mb-4">
                    <div class="col">
                        <h4>Target pemasukkan bulanan :</h4>
                        <input class="form-control" type="text" name="" id=""/>
                    </div>
                    <div class="col">
                        <h4>Total rata pemasukan :</h4>
                        <input class="form-control" type="text" name="" id=""/>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col">
                        <h4>Total pengeluaran bulan :</h4>
                        <input class="form-control" type="text" name="" id=""/>
                    </div>
                    <div class="col">
                        <h4>Indikator performa :</h4>
                        <input class="form-control" type="text" name="" id=""/>
                    </div>
                </div>
				<div class="row text-center">
                    <div class="col">
                        <button class="btn btn-primary mb-3 mt-3" type="submit" name="" value="">Ubah</button>
                    </div>
                </div>
			
				<!--chart-->
				<div class="card">
					<div class="card-body" id="indikatorChart" style="">
						<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
						
						
						</div>
					</div>
				</div>
				<form id="form30Hari" action="">
					<input type="submit" name="30d" value="30 hari">
				</form>
				<form id="form7Hari" action="">
					<input type="submit" name="7d" value="7 hari">
				</form>
				<div id="scrol"></div>
            </div>
            </div>

        </div>
        </div>
	
	<script>
		$(document).ready(function(){
			$('#indikatorChart').load('layout/indikatorChart.php');
		});
		
		//fungsi scroll
		var scrl = document.getElementById('scrol');
		$(document).ready(function(){
			scrl.scrollIntoView(true);
		});
		
		$('#form30Hari').on("submit", function(e){
			e.preventDefault();
			$('#indikatorChart').load('layout/indikatorChart.php?30d=yes');
			scrl.scrollIntoView(true);
		});
		
		$('#form7Hari').on("submit", function(e){
			scrl.scrollIntoView(true);
			e.preventDefault();
			$('#indikatorChart').load('layout/indikatorChart.php?7d=yes');
		});
	</script>
    </body>
</html>
