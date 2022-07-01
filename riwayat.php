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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>Go Parfum | Riwayat Belanja</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<BODY STYLE="BACKGROUND-IMAGE:URL(6.jpg)">
	<?php include 'menu.php'; ?>
	<section class="riwayat">
		<div class="container">
			<h3><font color="white"><b> Riwayat Belanja <?php echo $_SESSION["pembeli"]["Nm_Pembeli"]?> </font></b></h3>
			<table class="table table-bordered" style="background-color:cornsilk;">
				<thead>
					<tr>
						<th> No. </th>
						<th> Tanggal</th>
						<th> Status</th>
						<th> Total</th>
						<th> Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$nomor=1;
					//mendapatkan username pelanggan yg login
					$Username= $_SESSION["pembeli"]["Username"];
					$ambil=$koneksi->query("SELECT * FROM faktur JOIN status ON faktur.Id_Status=status.Id_Status WHERE Username='$Username'");
					while($pecah=$ambil->fetch_assoc()){
					?>
					<tr>
						<td><?php echo $nomor;?></td>
						<td><?php echo $pecah["Tgl_Beli"]?></td>
						<td>
							<?php echo $pecah["Nm_Status"]?>
							<br>
							<?php if(!empty($pecah['Resi_Pengiriman'])):?>
							Resi: <?php echo $pecah['Resi_Pengiriman']; ?>
							<?php endif ?>
						</td>
						<td>Rp.<?php echo number_format($pecah["Total_Bayar"]);?></td>
						<td>
							<?php if($pecah['Nm_Status']=="Belum Dibayar"):?>
							<a href="faktur.php?id=<?php echo $pecah["No_Faktur"]?>" class="btn btn-danger">Faktur</a>
							<a href="pembayaran.php?id=<?php echo $pecah['No_Faktur']?>" class="btn btn-success">Input Pembayaran</a>
							<?php endif?>
							
							<?php if($pecah['Nm_Status']=="Sudah Kirim Pembayaran" ):?>
							<a href="faktur2.php?id=<?php echo $pecah["No_Faktur"]?>" class="btn btn-success">Faktur</a>
							<a href="lihat_pembayaran.php?id=<?php echo $pecah['No_Faktur']?>" class="btn btn-primary">Lihat Pembayaran</a>
							<?php endif?>
						
							<?php if($pecah['Nm_Status']=="Barang Dikirim" OR $pecah['Nm_Status']=="Barang Dikemas" ):?>
							<a href="faktur2.php?id=<?php echo $pecah["No_Faktur"]?>" class="btn btn-success">Faktur</a>
							<a href="lihat_pembayaran.php?id=<?php echo $pecah['No_Faktur']?>" class="btn btn-primary">Lihat Pembayaran</a>
							<a href="penilaian.php?id=<?php echo $pecah['No_Faktur']?>" class="btn btn-warning">Konfirmasi</a>
							<?php endif?>
							
							<?php if($pecah['Nm_Status']=="Complain"):?>
							<a href="faktur3.php?id=<?php echo $pecah["No_Faktur"]?>" class="btn btn-warning">Faktur</a>
							<?php endif?>
							
							<?php if($pecah['Nm_Status']=="Selesai"):?>
							<a href="faktur2.php?id=<?php echo $pecah["No_Faktur"]?>" class="btn btn-success">Faktur</a>
							<?php endif?>
						</td>
					</tr>
					<?php $nomor++;?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</section>
</body>
</html>