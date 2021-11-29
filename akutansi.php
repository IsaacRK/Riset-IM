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
<title>Akunting proto</title>
<?php include "layout/header.php"?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>
<body>

<?php
	include "layout/sidebar.php";
?>

<div class="content">
 <div class="container mr-0">

    <div class="p-1 mb-3">
		<div class="row">
			<div class="col juk">
				<h1>Akunting</h1>
			</div>
        </div>
    </div>


    <div class="card shadow-sm">
	<div class="card-body">
    <table class="table">
        <thead>
            <tr class="table-info">
                <th scope="col">Nama</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Tanggal input</th>
                <th scope="col">Harga beli</th>
                <th scope="col">Harga jual</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>
    </div>
    
 </div>
</div>
</body>
</html>
