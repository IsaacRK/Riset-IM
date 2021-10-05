<?php
include"../backend/conn.php";

?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery3.6.0.min.js"></script>
<script src="js/jquery-ui.js"></script>
</head>
<body>

<div class="container">
    <br>
    <h4>Autocomplete dengan PHP dan MYSQL</h4>
        <script>
            $(function() {
                $("#nama").autocomplete({
                    source: 'post.php'
                });
            });
        </script>
        <div class="form-group">
            <label for="sel1">Nama Mahasiswa:</label>
            <input type="text" id="nama" name="nama" value="" class="form-control"  required/>
        </div>
    <div class="form-group">
        <input type="submit" class="btn btn-info" value="Cari">
    </div>
</div>

</body>
</html>