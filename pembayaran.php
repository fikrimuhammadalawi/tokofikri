<?php 
session_start();
$koneksi=new mysqli("localhost","root","","GoParfum");
//Jika tidak ada session pembeli (belum login)
if(!isset($_SESSION['pembeli']) OR empty($_SESSION['pembeli']))
{
	echo "<script>alert('Silakan Login');</script>";
	echo "<script>location='login.php';</script>";
	exit();
}
//Mendapatkan No_Faktur dari URL
$idpem=$_GET["id"];
$ambil=$koneksi->query("SELECT * FROM faktur WHERE No_Faktur='$idpem'");
$detpem=$ambil->fetch_assoc();
//Mendapatkan Username yang beli
$pembeliyangbeli=$detpem["Username"];
//Mendapatkan Username yang login
$pembeliyanglogin= $_SESSION["pembeli"]["Username"];
if($pembeliyangbeli!==$pembeliyanglogin)
{
	echo "<script>alert('Pembayaran milik pembeli yang lain');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}
?>
<!DOCTYPE html>
<html>
<body background="3.jpg"></body>
<head>
	<title> Pembayaran </title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<?php include'menu.php'?>
<div class="container">
<font color="white">	 
	<h2>Konfirmasi Pembayaran</h2>
	<p>Kirim bukti pembayaran Anda di sini</p>
	<div class="alert alert-info"> Total yang harus dibayarkan: <strong> 
	Rp.<?php echo number_format($detpem["Total_Bayar"])?></strong></div>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label> Nama Pembeli</label>
			<input autocomplete="off" type="text" class="form-control" readonly value="<?php echo $_SESSION['pembeli']['Nm_Pembeli'] ?>">
		</div>
		<div class="form-group">
			<label> Bukti Pembayaran </label></font>
			<input  type="file" class="form-control" name="bukti" required>
		</div>
		<button class="btn btn-primary" name="kirim"> Kirim</button>
	</form>
</div>
<?php
//jika tombol kirim diklik
if(isset($_POST["kirim"]))
{
	//uploadfotobukti
	$namabukti=$_FILES["bukti"]["name"];
	$lokasibukti=$_FILES["bukti"]["tmp_name"];
	$namafiks=date("YmdHis").$namabukti;
	move_uploaded_file($lokasibukti,"Bukti_Pembayaran/$namafiks");
	$tanggal=date("Y-m-d");
	
	$koneksi->query("UPDATE faktur SET Bukti_Pembayaran='$namafiks',Tgl_Bayar='$tanggal' WHERE No_Faktur='$idpem'");			
	//update status pembayaran
	$koneksi->query("UPDATE faktur SET Id_Status='ST002' WHERE No_Faktur='$idpem'");
	
	echo "<script>alert('Terima kasih sudah melakukan pembayaran');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
</body>
</html>