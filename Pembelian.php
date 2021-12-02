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
    <title>Pembelian</title>
	<?php include "layout/header.php"?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    </head>

    <body>
        <?php include 'sidebar.php';?>
        <div class="content">
         <div class="container mr-0">

            <div class="row">
                <div class="col-sm-4">
                    
                    <div class="card shadow-sm mb-2">
                     <div class="card-body">
                        <h3 class="text-center">Registrasi Data</h3>
                        <h3 class="text-center">Pembelian</h3>

                        <div class="row mb-3 mt-3">
                            <div class="col-4">
                                <p class="text-end">Nama : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" name="nmbrng" id="" style="width:150%;"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="text-end">Link : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" name="link" id="" style="width:150%;"/>
                            </div>
                        </div>
                
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="text-end">Harga : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="number" name="harga" id="" style="width:150%;"/>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="text-end">Ongkir : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="number" name="ongkir" id="" style="width:150%;"/>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="text-end">Jumlah : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="number" name="JMLH" id="" style="width:150%;"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col text-center">
                                <Button class="btn btn-primary" type="submit" name="tambahkan" value="tambahkan">Tambahkan</button>
                            </div>
                        </div>                        


                     </div>
                    </div>
			         
                </div>

                <div class="col-sm-8">

                    <div class="card shadow-sm mb-2">
                        <div class="card-body">
                            <h3 class="text-center card-title">Rencana Pembelian</h3>

                            <div class="table-responsive">
                                <table class="table table-striped table-sm" id="Rncn">
                                    <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Harga beli</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

         </div>
        </div>
    </body>
</html>