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
        <title>Indikator Peforma</title>
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

            </div>
            </div>


        </div>
        </div>
    </body>
</html>
