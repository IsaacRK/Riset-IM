<?php
require 'backend/conn.php';
require 'backend/usersession.php';
require 'backend/pmbln.php';
if ($userAC == '0'){
	header('location:Verifyno.php');
}else{}
?>

<!DOCTYPE html>
<html>

    <head>
    <title>Rencana Pembelian</title>
	<?php include "layout/header.php"?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        .page-header, .page-header-space {
        height: 110px;
        }
        .page-footer, .page-footer-space {
        height: 50px;
        }
        #format{
            display:none;
        }
        .page-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        border-top: 1px solid black; /* for demo */
        background: white;
        }
        .page-header {
        position: fixed;
        top: 0mm;
        width: 100%;
        border-bottom: 1px solid black; /* for demo */
        background:white;
        }
        .page {
        page-break-after: always;
        }
        .tblw{
            width:1000px;
        }
        .company-details {
            text-align: right
        }
        .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }
        .tableFixHead {
        table-layout: fixed;
        border-collapse: collapse;
        }
        .tableFixHead tbody {
        display: block;
        overflow: auto;
        max-height: 440px;
        }
        .tableFixHead thead tr {
        display: block;
        }
        .tableFixHead th,
        .tableFixHead td {
        width: 200px;
        }
        @page {
        margin: 20mm
        }

        @media print {
        thead {display: table-header-group;} 
        tfoot {display: table-footer-group;}
        
        button {display: none;}

        body * {
            visibility: hidden;
            margin: 0;
        }
            #format, #format * {
            visibility: visible;
        }
            #format {
            position: absolute;
            left: 0;
            top: 0;
            display:block;
        }
        }
    </style>
    </head>

    <body>
        <?php include 'layout/sidebar-old.php';?>
        <div class="content">
         <div class="container mr-0">

          <div class="p-1">
    		<div class="mb-3">
			<h1>Pembelian</h1>
	    	</div>
	  </div>		 
		 
            <div class="row">
                <div class="col">
                 <form action="" method="post">   
                    <div class="card shadow-sm mb-2">
                        <div class="card-body">
                            <h3 class="text-center card-title">Rencana Pembelian</h3>
                            <p class="text">Daftar Kebutuhan &nbsp; <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambahkan</button> 
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrasi Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

                        <div class="row mb-3 mt-3">
                            <div class="col-4">
                                <p class="text-end">Nama : </p>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" name="nmbrng" id="nmbrng" style="width:150%;"/>
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

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
        <Button class="btn btn-primary" type="submit" name="submit" value="tambahkan">Tambahkan</button>
                            
      </div>
    </div>
  </div>
</div>
                         <div class="table-responsive tableFixHead" id="tblee">
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
                                   <div style="max-height:500px;">
                                    <tbody>
                                        <?php
                                           $Rncn = "SELECT pembelian.* , stock.stock_name , harga.beli, harga.jual
                                           FROM pembelian
                                           JOIN stock ON pembelian.stock_id = stock.stock_id
                                           JOIN harga ON pembelian.stock_id = harga.stock_id
                                           WHERE pembelian.RAB = 0
                                           order by pembelian.id asc
                                           ";
                                           $RNCNRUN = mysqli_query($servConnQuery, $Rncn);
                                           $ARG = array();
                                           while($kol = mysqli_fetch_assoc($RNCNRUN)){
                                            $ARG[] = $kol;
                                            }
                                            $no = 1;
                                            foreach($ARG as $data){ ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td class='fw-bold'><?php echo $data['stock_name']; ?></td>
                                                    <td><?php echo $data['link'];?></td>
                                                    <td><?php echo $data['beli'];?></td>
                                                    <td><?php echo $data['jumlah'];?></td>
                                                    <td><?php echo $data['totalhrg'];?></td>
                                                </tr>
                                            <?php $no++;} ?>
                                    </tbody>
                                   </div>
                                </table>
                                <?php
                                    if(mysqli_num_rows($RNCNRUN)== 0){
                                        echo'
                                            <div class="w-100 color-tertiary p-2 text-center fw-bold">---------</div>
                                        ';
                                    }
                                ?>
                            </div>
                            <form action="" method="post">
                            <div class='row'>
                                <div class="col text-center mt-3">
                                <button class="btn btn-primary" onClick="window.print(format)" type="submit" name="buat" value="buat">Buat RAB</button>
                                </div>
                            </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

         </div>
        </div>

        <div id="format">
        <div class="page-header mb-3">
            <div class="row">
            <div class="col">
                <a target="_blank"\>
                <img src="img/caktot.png" alt="logo" class="d-block w-100" />
                </a>
            </div>
            <div class="col company-details">
                <h2 class="name">
                <a target="_blank">
                    Toko Murah
                </a>
                </h2>
                <div>JL City Home Regency E8 Keputih, Sukolilo, Surabaya 60111</div>
                <div>085158422477</div>
                <div>Tokomurah77714@gmail.com</div>
            </div>
            </div>
        </div>

            <div class="page-footer">
            </div>

            <table>

                <thead>
                <tr>
                    <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                    </td>
                </tr>
                </thead>

                <?php $now = date("Y-m-d");
                ?>

                <tbody>
                    <tr>
                        <td>
                        <!--*** CONTENT GOES HERE ***-->
                        <div class="page">

                            <p class="text-center fs-4 fw-bold mt-3">Rencana Anggaran Belanja</p>
                            <div class="row mt-3">
                                <div class="col-2">
                                <span>Akun Pengambil </br></span>
                                <span>Peran </br></span>
                                <span>Tanggal </br></span>
                                </div>
                                <div class="col-3">
                                : <?php echo $userData['user']?></br>
                                : <?php echo $userData['tingkat'];?></br>
                                : <?php echo $now;?>
                                </div>
                            </div>                                    
                                                <div class="table-responsive" id="tblee">
                                                <table class="tblw table table-striped table-sm" id="Rncn">
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
                                                <div>
                                                    <tbody>
                                                        <?php
                                                        $Rncn = "SELECT pembelian.* , stock.stock_name , harga.beli, harga.jual
                                                        FROM pembelian
                                                        JOIN stock ON pembelian.stock_id = stock.stock_id
                                                        JOIN harga ON pembelian.stock_id = harga.stock_id
                                                        WHERE pembelian.RAB = 0
                                                        order by pembelian.id asc
                                                        ";
                                                        $RNCNRUN = mysqli_query($servConnQuery, $Rncn);
                                                        $ARG = array();
                                                        while($kol = mysqli_fetch_assoc($RNCNRUN)){
                                                            $ARG[] = $kol;
                                                            }
                                                            foreach($ARG as $data){ ?>
                                                                <tr>
                                                                    <td><?php echo $data['id']; ?></td>
                                                                    <td class='fw-bold'><?php echo $data['stock_name']; ?></td>
                                                                    <td><?php echo $data['link'];?></td>
                                                                    <td><?php echo $data['beli'];?></td>
                                                                    <td><?php echo $data['jumlah'];?></td>
                                                                    <td><?php echo $data['totalhrg'];?></td>
                                                                </tr>
                                                            <?php } ?>
                                                    </tbody>
                                                </div>
                                                </table>
                                        <?php
                                            if(mysqli_num_rows($RNCNRUN)== 0){
                                                echo'
                                                    <div class="w-100 tblw color-tertiary p-2 text-center fw-bold">---------</div>
                                                ';
                                            }
                                        ?>
                                    </div>

                        </div>

                        </td>
                    </tr>
                </tbody>

                <tfoot>
                <tr>
                    <td>
                    <!--place holder for the fixed-position footer-->
                    <div class="page-footer-space"></div>
                    </td>
                </tr>
                </tfoot>

            </table>
        </div>


        <script>
            $(function(){
		        $("#nmbrng").autocomplete({
			    source: 'backend/autocomplete.php'
		        });
	        });
        </script>
    </body>
</html>
