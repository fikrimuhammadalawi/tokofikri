<?php 
session_start();
$koneksi=new mysqli("localhost","root","","GoParfum");
$No_Faktur=$_GET['id'];
$ambil=$koneksi->query("SELECT * FROM faktur WHERE No_Faktur='$_GET[id]'");
$detbay=$ambil->fetch_assoc();
if($_SESSION['pembeli']['Username']!==$detbay['Username'])
{
	echo "<script>alert('Anda tidak berhak melihat pembayaran orang lain');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lihat Pembayaran</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
	<?php include 'menu.php'; ?>
	<div class="container">
		<h3>Lihat Pembayaran</h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-bordered" style="background-color:cornsilk;">
					<tr>
						<th>Nama</th>
						<th><?php echo $_SESSION['pembeli']['Nm_Pembeli'] ?></th>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th>Rp.<?php echo number_format($detbay['Total_Bayar']); ?></th>
					</tr>
					<tr>
						<th>Tanggal Pembayaran</th>
						<th><?php echo $detbay['Tgl_Bayar']; ?></th>
					</tr>
				<table>
			</div>
			<div class="col-md-6">
				<img src="Bukti_Pembayaran/<?php echo $detbay["Bukti_Pembayaran"] ?>" alt="" class="img-responsive">
			</div>
		</div>
	</div>
</body>
</html>