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
        .modl{
            width:120%;
        }
        .cntrl{
            width:150%
        }
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
	ul.ui-autocomplete.ui-menu {
        z-index: 1600;
        }
	@media screen and (max-width:800px) {
        .modl{
	    width:100%;
        }
        .modal-backdrop{
            z-index:0;
        }
        .cntrl{
            width:100%
        }
        .text-end{
            text-align:center!important;
        }
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

#signature {
  height: 30px;
  word-spacing: 1px;
  text-align: right;
}
}

#signaturea {
  height: 30px;
  word-spacing: 1px;
  text-align: right;    
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
							<p class="text"><big>Daftar Kebutuhan</big> &nbsp; <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambahkan</button> 
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				    

  <div class="modal-dialog">
    <div class="modal-content mdl">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrasi Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  
					<form action="" method="post">
                        <div class="row mb-3 mt-3">
                            <div class="col-sm-4">
                                <p class="text-end">Nama Barang : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="text" name="nmbrng" id="nmbrng"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Keterangan pembelian : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="text" name="link" id=""/>
                            </div>
                        </div>
                
						<div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Toko : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="text" name="toko" id=""/>
                            </div>
                        </div>
				
						<div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Alamat Toko : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="text" name="alamat" id=""/>
                            </div>
                        </div>
				
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Harga satuan : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="number" name="harga" id=""/>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Harga pengiriman : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="number" name="ongkir" id=""/>
                            </div>
                        </div>    
						
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-end">Jumlah : </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control cntrl" type="number" name="JMLH" id=""/>
                            </div>
                        </div>                        

      </div>
      <div class="modal-footer">
		<div class="d-flex flex-row-reverse">
			<div class="bd-highlight p-2">
				<input class="btn btn-primary" type="submit" name="submit" value="tambahkan">
			</div>
			</form>
			<div class="bd-highlight p-2">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
				    
                         <div class="table-responsive tableFixHead" id="tblee">
                                <table class="table table-striped table-sm" id="Rncn">
                                    <thead>
                                    <tr>
									<!--tabel display/tampilan-->
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Keterangan pembelian</th>
										<th scope="col">Toko</th>
										<th scope="col">Alamat Toko</th>
                                        <th scope="col">Harga satuan</th>
                                        <th scope="col">Harga pengiriman</th>
                                        <th scope="col">PPN</th>
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
                                                    <td><?php echo $data['toko'];?></td>
													<td><?php echo $data['alamat'];?></td>
													<td><?php echo $data['harga'];?></td>
                                                    <td><?php echo $data['Ongkir'];?></td>
                                                    <td><?php echo $data['ppn'];?></td>
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
                                <button class="btn btn-primary" onClick="window.print(format)" type="submit" name="buat" value="buat">Purchase Order</button>
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

                            <p class="text-center fs-1 fw-bold mt-3">Rencana Anggaran Belanja</p>
                            <div class="row mt-3 mb-3 fs-4">
                                <div class="col-3">
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
													<!--tabel print purchase order-->
                                                        <th scope="col">No</th>
                                                        <th scope="col">Nama Barang</th>
                                                        <th scope="col">Keterangan pembelian</th>
														<th scope="col">Toko</th>
														<th scope="col">Alamat Toko</th>
                                                        <th scope="col">Harga satuan</th>
                                                        <th scope="col">Harga pengiriman</th>
                                                        <th scope="col">PPN</th>
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
                                                            foreach($ARG as $data){ $no--; ?>
                                                                <tr>
                                                                    <td><?php echo $no; ?></td>
                                                                    <td class='fw-bold'><?php echo $data['stock_name']; ?></td>
                                                                    <td><?php echo $data['link'];?></td>
																	<td><?php echo $data['toko'];?></td>
																	<td><?php echo $data['alamat'];?></td>
                                                                    <td><?php echo $data['harga'];?></td>
                                                                    <td><?php echo $data['Ongkir'];?></td>
                                                                    <td><?php echo $data['ppn'];?></td>
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
               <div class="row d-flex justify-content-between">
                <div class="col-3 text-center">
                    <div class="row">                    
                        <span>Disetujui oleh:</span>
                    </div>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    <div class="row border-top border-secondary">
                        <span>Kepala Perusahaan</span>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <div class="row">
                        <span>Diajukan oleh:</span>
                    </div>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    <div class="row border-top border-secondary">
                        <span><?php echo $userData['user'];?></span>
                    </div>
                </div>
               </div>

                                        
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
