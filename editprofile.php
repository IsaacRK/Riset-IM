<head>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: aliceblue
}

.wrapper {
    padding: 30px 50px;
    border: 1px solid #ddd;
    border-radius: 15px;
    margin: 10px auto;
    max-width: 600px
}

h4 {
    letter-spacing: -1px;
    font-weight: 400
}

.img {
    width: 70px;
    height: 70px;
    border-radius: 6px;
    object-fit: cover
}

#img-section p,
#deactivate p {
    font-size: 12px;
    color: #777;
    margin-bottom: 10px;
    text-align: justify
}

#img-section b,
#img-section button,
#deactivate b {
    font-size: 14px
}

label {
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 500;
    color: #777;
    padding-left: 3px
}

.form-control {
    border-radius: 10px
}

input[placeholder] {
    font-weight: 500
}

.form-control:focus {
    box-shadow: none;
    border: 1.5px solid #0779e4
}

select {
    display: block;
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
    height: 40px;
    padding: 5px 10px
}

select:focus {
    outline: none
}

.button {
    background-color: #fff;
    color: #0779e4
}

.button:hover {
    background-color: #0779e4;
    color: #fff
}

.btn-primary {
    background-color: #0779e4
}

.danger {
    background-color: #fff;
    color: #e20404;
    border: 1px solid #ddd
}

.danger:hover {
    background-color: #e20404;
    color: #fff
}

@media(max-width:576px) {
    .wrapper {
        padding: 25px 20px
    }

    #deactivate {
        line-height: 18px
    }
}    </style>
    <?php include"layout/header.php"; ?> 
</head>
<div class="wrapper bg-white mt-sm-5">
    <h4 class="pb-4 border-bottom">Kelola Profil</h4>
    <div class="py-2">
        <div class="row py-2">
            <div class="col-md-6"> <label for="firstname">Name</label> <input type="text" class="bg-light form-control" placeholder=""> </div>
            <div class="col-md-6 pt-md-0 pt-3"> <label for="email">Email</label> <input type="text" class="bg-light form-control" placeholder=""> </div>
        </div>
        <div class="row py-2">
            <div class="col-md-6"> <label for="Password">Password</label> <input type="text" class="bg-light form-control" placeholder=""> </div>
            <!DOCTYPE html>
<html>
<head>
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
</head>
<body>
</html>

            <div class="col-md-6 pt-md-0 pt-3"> <label for="phone">Nomor Telefon</label> <input type="number" class="bg-light form-control" placeholder=""> </div>
        </div>
        <div class="py-3 pb-4 border-bottom"> <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#modalkonfirm">Terapkan</button> <button class="btn border button">Cancel</button> </div>
            </div><a href="dashboard.php">Kembali</a>
        </div>
    </div>
</div>

<div id="modalkonfirm" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">
                <h1>Konfirmasi Password</h1>
            </div>
            <div class="modal-body">
            <input class="form-control" required type="password" name="pass" id=""/>
			</br>
            <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#modalkonfirm">Simpan</button> 
        </div>
            <div class="modal-footer">
            </div>
		</div>
	</div>
</div>