<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "GoParfum";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
session_start();

$idpem= $_GET["id"];
$ambil=$koneksi->query("SELECT *FROM faktur WHERE No_Faktur='$idpem'");
$detpem=$ambil->fetch_assoc();

$idpemygbeli=$detpem["Username"];
$idpemyglogin=$_SESSION["pembeli"]["Username"];
if ($idpemyglogin!==$idpemygbeli)
{
	echo "<script>alert('Tidak dapat diproses ');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<html>
<head>
	<title> Konfirmasi Pesanan </title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include'menu.php'?>
<div class="alert alert-info"> <strong>Silakan konfimasi produk yang telah diterima 
	<a href="penilaian.php">di sini</a></strong></div>
<br>
	<div class="alert alert-danger"> <strong>Jika Anda merasa tidak puas akan produk yang telah sampai silakan ajukan complain 
	<a href="complain.php">di sini</a></strong></div>
</body>
</html>