<?php 
session_start();
$koneksi=new mysqli("localhost","root","","GoParfum");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>Eunoia SHOP | Daftar</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<BODY STYLE="BACKGROUND-IMAGE:URL(login.JPG)">
	<?php include 'menu.php'; ?>
	<div class="container" style="margin-top: 50px">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default" style="background-color:LemonChiffon;">
					<div class="panel-heading">
						<h3 class="panel-title text-center"><b>Eunoia SHOP | Daftar Pelanggan<b></h3>
					</div>
					<div class="panel-body">
						<form method="POST" class="form-horizontal">
							<div class="form-group">
								<label class="col-md-3 control-label">Nama Lengkap</label>
								<div class="col-md-6">
									<input type="text" class="form-control"name="Nama"required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Username</label>
								<div class="col-md-6">
									<input type="text" class="form-control"name="Username"required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control"name="Password"required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Konfirmasi Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control"name="Password2"required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Alamat</label>
								<div class="col-md-6">
									<textarea name="Alamat" rows="2" class="form-control" style="resize: none;"required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">No. Telepon</label>
								<div class="col-md-6">
									<input type="text" class="form-control"name="Telepon" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
									<button class="btn btn-primary" name="daftar">Daftar</button>
								</div>
							</div>
							<div>
							<center>Sudah Punya Akun? <span><a href="login.php"> Login di sini </span> </center>		
							</div>
						</form>
						<?php
						if(isset($_POST['daftar']))
						{
							
							$Nama = $_POST['Nama'];
							$Username = $_POST['Username'];
							$Password = $_POST['Password'];
							$Password2 = $_POST['Password2'];
							$Alamat = $_POST['Alamat'];
							$Telepon = $_POST['Telepon'];
							
							//cek apakah username sudah digunakan atau belum
							$ambil=$koneksi->query("SELECT * FROM pembeli WHERE Username=$Username'");
							$cocok=$ambil->num_rows;
							if($cocok==1)
							{
								echo "<script>alert('Pendaftaran Gagal, Username Sudah Digunakan');</script>";
								echo "<script>location='daftar.php';</script>";
							}
							elseif($Password != $Password2)
							{
								echo "<script>alert('Konfirmasi Password Anda Tidak Cocok');</script>";
								echo "<script>location='daftar.php';</script>";
							}
							else
							{
								//Query Memasukkan Ke Dalam Database
								$koneksi->query("INSERT INTO pembeli (Username, Nm_Pembeli, Password, No_HPPembeli, Almt_Pembeli) 
												VALUES ('$Username', '$Nama','$Password','$Telepon','$Alamat')");
												
								echo "<script>alert('Pendaftaran Berhasil, Silakan Login');</script>";
								echo "<script>location='login.php';</script>";	
							}								
						}		
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<body>
</html>