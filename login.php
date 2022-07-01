<?php
session_start();
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Go Parfum | Login</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<BODY STYLE="BACKGROUND-IMAGE:URL(6.JPG)">
	<?php include 'menu.php'; ?>
	<div class="container">
		<div class="row" style="margin-top: 50px">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default" style="background-color:LemonChiffon;">
					<div class="panel-heading">
						<div class="panel-title text-center">
							<label>Go Parfum | Login</label>
						</div>
					</div>
					<div class="panel-body">
						<form method="POST">
							<div class="form group">
								<label>Username</label>
								<input type ="user" class ="form-control" name="Username"></input>
							</div>
							
							<div class="form group">
								<label>Password</label>
								<input type ="pass" class ="form-control" name="Password"></input>
							</div>
							<br>
							<button class="btn btn-primery btn-lg btn-block" name="login">Login</button><br>
							<p>Belum Terdaftar? <a href="daftar.php" style="text-decoration: none;"><b>Daftar di sini</a></p>
						</form>
						<?php
						if(isset($_POST['login']))
						{		
							$Username = $_POST["Username"];
							$Password = $_POST["Password"];
							
							$ambil=$koneksi->query("SELECT * FROM pembeli WHERE Username ='$Username' AND Password='$Password'");
							$akun_cocok=$ambil->num_rows;
							if($akun_cocok==1)
							{
								$akun = $ambil->fetch_assoc();
								$_SESSION["pembeli"]=$akun;
								echo "<div class='alert alert-succes text-center'>Login Berhasil</div>";
								if(isset($_SESSION['keranjang'])OR !empty($_SESSION['keranjang']))
								{
									echo "<meta http-equiv='refresh' content='1;url=checkout.php'>";	
								}
								else
								{
									echo "<meta http-equiv='refresh' content='1;url=riwayat.php'>";	
								}
								
							}
							else
							{
								echo "<div class='alert alert-danger text-center'>Login Gagal, Silakan Periksa Akun Anda</div>";
								echo "<meta http-equiv='refresh' content='1;url=login.php'>";	
							}
						}
						?>	
				</div>
			</div>
		</div>
	</div>			
</body>
</html>