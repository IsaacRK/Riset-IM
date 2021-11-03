<?php
	require'backend/conn.php';
	require'backend/usersession.php';
?>
<!DOCTYPE html>
<head>
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

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
}
</style>
    <?php
	include"layout/header.php";
	?> 
</head>
<body>
<?php
	if(isset($_POST['submit'])){
		$user = $_POST['username'];
		$pass = $_POST['pass'];
		$email = $_POST['email'];
		$telp = $_POST['telp'];
		$confPass = $_POST['pass_confirmation'];
		
		$fetchSql = "select * from pengguna where id=$userId";
		$fetchRun = mysqli_query($servConnQuery, $fetchSql);
		$fetch = mysqli_fetch_assoc($fetchRun);
		
		if($user==null){
			$user = $fetch['user'];
		}
		if($pass==null){
			$pass = $fetch['pass'];
		}
		if($email==null){
			$email = $fetch['email'];
		}
		if($telp==null){
			$email = $fetch['telp'];
		}
		
		$userPass = $fetch['pass'];
		if($userPass == $confPass){
			echo $sql = "update pengguna set user='$user', pass='$pass', email='$email', telp='$telp' where id=".$userId;
			mysqli_query($servConnQuery, $sql);
		}else{
			echo"
				<script>
					alert('Konfirmasi Password salah!');
				</script>
			";
		}
		
	}
?>

<form method="post" action="">
<div class="wrapper bg-white mt-sm-5">
    <h4 class="pb-4 border-bottom">Kelola Profil</h4>
    <div class="py-2">
        <div class="row py-2">
            <div class="col-md-6"> <label for="firstname">Name</label> <input type="text" class="bg-light form-control" name="username"> </div>
            <div class="col-md-6 pt-md-0 pt-3"> <label for="email">Email</label> <input type="email" class="bg-light form-control" name="email"> </div>
        </div>
        <div class="row py-2">
            <div class="col-md-6"> <label for="Password">Password</label> <input type="password" class="bg-light form-control" name="pass"> </div>
            <div class="col-md-6 pt-md-0 pt-3"> <label for="phone">Nomor Telefon</label> <input type="number" class="bg-light form-control" name="telp"> </div>
        </div>
		<div class="row py-2">
			<div class="col-md-6"> <label for="pass_confirmation">Konfirmasi Password</label> 
			<input class="bg-light form-control" required type="password" name="pass_confirmation" id=""/>
			</div>
		</div>
		<div class="row py-2">
			<div class="col-md-6">
				<input type="submit" class="btn btn-primary" name="submit" value="Simpan">
			</div>
			<div class="col-md-6">
				<a href="dashboard.php" class="btn btn-primary">Kembali</a>
			</div>
		</div>
	</div>
</div>
</form>

</body>
</html>