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
	<body STYLE="BACKGROUND-IMAGE:URL(.jpg)">
	<div class="container">
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
			<div class="alert alert-danger"> <strong>Terima kasih telah berbelanja di toko kami! Dengan klik konfirmasi, itu artinya Anda
			telah mengonfirmasi bahwa Anda telah membatalkan barang yang Anda pesan</strong> </div>
			</div>
			<div class="col-md-5">
				<button class="btn btn-primary" name="konfirmasi">Konfirmasi</button>
			</div>
		</div>
		<?php 
			if(isset($_POST["konfirmasi"]))
			{
				$nilai =$_POST["penilaian"];
				$Id_Status="ST007";
				$koneksi->query("UPDATE faktur SET Id_Status='$Id_Status',Penilaian_Produk='$nilai' WHERE No_Faktur='$idpem'");
			
				echo "<script>alert('Terima kasih atas transaksi yang telah Anda lakukan');</script>";
				echo "<script>location='riwayat.php';</script>";
			}
		?>
	</div>
</body>
</html>