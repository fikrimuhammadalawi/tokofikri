<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "GoParfum";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
session_start();

$idpem= $_GET["id"];
$ambil=$koneksi->query("SELECT *FROM faktur JOIN pembeli ON faktur.Username=pembeli.Username WHERE No_Faktur='$idpem'");
$detpem=$ambil->fetch_assoc();

$idpemygbeli=$detpem["Username"];
$idpemyglogin=$_SESSION["pembeli"]["Username"];
if ($idpemyglogin!==$idpemygbeli)
{
	echo "<script>alert('Tidak dapat diproses ');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Konfirmasi Belanja</title>
		<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<?php include 'menu.php'; ?>
	</head>
	<body STYLE="BACKGROUND-IMAGE:URL(4.jpg)">
	<div class="container">
	<font color="white">
		<h3>Konfirmasi Komplain Barang </h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th>No Faktur</th>
						<td><?php echo $detpem["No_Faktur"]; ?></td>
					</tr>
					<tr>
						<th>Nama</th>
						<td><?php echo $detpem["Nm_Pembeli"]; ?></td>
					</tr>
					<tr>
						<th>Tanggal Pembayaran</th>
						<td><?php echo  date("d F Y",strtotime($detpem["Tgl_Bayar"])); ?></td>
					</tr>					
					<tr>
						<th>Jumlah</th>
						<td>Rp. <?php echo number_format($detpem["Total_Bayar"]); ?></td>
					</tr>

				</table>
				</br>
			</div>
			<div class="col-md-5">
			<div class="alert alert-danger"> <strong>Terima kasih telah berbelanja di toko kami! Silakan hubungi No. WhatsApp 089627870348. Dengan mengisi penilaian ini dan klik konfirmasi, itu artinya Anda
			telah mengonfirmasi bahwa Anda telah komplain barang yang Anda pesan</strong> </div>
			</div></font>
			<div class="col-md-5">
				<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Penilaian Anda</label>
							<textarea class="form-control" name="penilaian" placeholder="Berikan Penilaian Anda" rows="3" required></textarea>
						</div>

					<button class="btn btn-primary" name="konfirmasi">Konfirmasi</button>
					<a href="penilaian.php?id=<?php echo $detpem["No_Faktur"]; ?>" class="btn btn-success">Kembali</a>
				</form>
			</div>
		</div>
		<?php 
			if(isset($_POST["konfirmasi"]))
			{
				$nilai =$_POST["penilaian"];
				$Id_Status="ST006";
				$koneksi->query("UPDATE faktur SET Id_Status='$Id_Status',Penilaian_Produk='$nilai' WHERE No_Faktur='$idpem'");
			
				echo "<script>alert('Terima kasih atas penilaian anda :) ');</script>";
				echo "<script>location='riwayat.php';</script>";
			}
		?>
	</div>
</body>
</html>