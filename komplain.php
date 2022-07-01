<?php
	session_start ();
	include 'koneksi.php';

	if(!isset($_SESSION["konsumen"]))
	{
		echo "<script>alert('Silahkan Login');</script>";
		echo "<script>location='login.php';</script>";
	}

	//mendapatkan kode faktur dari url
	$idpem = $_GET["id"];
	$ambil = $koneksi->query("SELECT * FROM faktur JOIN konsumen on faktur.Kode_Konsumen = konsumen.Kode_Konsumen WHERE Kode_Faktur='$idpem'");
	$detpem = $ambil->fetch_assoc();

	//medapatkan id pembeli
	$id_cus = $detpem["Kode_Konsumen"];
	//mendapatka id yg login
	$id_log = $_SESSION["konsumen"]["Kode_Konsumen"];

	if ($id_log !== $id_cus) 
	{
		echo "<script>alert('Anda tidak diizinkan melihat data orang lain');</script>";
		echo "<script>location='riwayat.php';</script>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Konfirmasi Belanja</title>
		<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
		<?php include 'menu.php'; ?>
	</head>
	<body STYLE="BACKGROUND-IMAGE:URL(faktur.jpg)">
</br>
</br>

	<div class="container">
		<h3>Konfirmasi Komplain Barang </h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th>No Faktur</th>
						<td><?php echo $detpem["Kode_Faktur"]; ?></td>
					</tr>
					<tr>
						<th>Nama</th>
						<td><?php echo $detpem["nama_lengkap"]; ?></td>
					</tr>
					<tr>
						<th>Tanggal Pembayaran</th>
						<td><?php echo  date("d F Y",strtotime($detpem["Tanggal"])); ?></td>
					</tr>					
					<tr>
						<th>Jumlah</th>
						<td>Rp. <?php echo number_format($detpem["Jumlah_Pembayaran"]); ?></td>
					</tr>

				</table>
				</br>
			</div>
			
			<div class="col-md-5">
			<div class="alert alert-info"> <strong>Terimakasih telah berbelanja di toko kami! Silahkan hubungi No Wa 082283172931. Dengan mengisi penilaian ini dan klik konfirmasi, itu artinya Anda
			telah mengkonfirmasi bahwa anda telah komplain barang yang anda pesan</strong> </div>
			</div>
			
			<div class="col-md-5">
				<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Penilaian Anda</label>
							<textarea class="form-control" name="nilai" placeholder="Berikan Penilaian Anda" rows="3" required></textarea>
						</div>

					<button class="btn btn-primary" name="konfirmasi">Konfirmasi</button>
					<a href="terima.php?id=<?php echo $detpem["Kode_Faktur"]; ?>" class="btn btn-success">Kembali</a>
				</form>
			</div>
		</div>
		<?php 
			if(isset($_POST["konfirmasi"]))
			{
				$nilai =$_POST["nilai"];
				$Kode_Statkirim="SK004";
				$koneksi->query("UPDATE faktur SET Kode_Statkirim='$Kode_Statkirim',Penilaian='$nilai' WHERE Kode_Faktur='$idpem'");
			
				echo "<script>alert('Terimakasih atas penilaian anda :) ');</script>";
				echo "<script>location='riwayat.php';</script>";
			}
		?>
	</div>
</body>
</html>