<?php
session_start();
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
if (empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang']))
{
	echo "<script>alert('Produk kosong, silakan belanja terlebih dahulu');</script>";
	echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang ="en">
<head>
	<meta charset="UTF-8">
	<title>Go Parfum | Keranjang</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<BODY STYLE="BACKGROUND-IMAGE:URL(3.JPG)">
	<?php include 'menu.php'; ?>
	
	<section class="konten">
		<div class="container">
			<center><h1><b><font face ="cornsilk"color="white">Keranjang Belanja </font></b></h1></center>
			<table class="table table-bordered text-center" style="background-color:cornsilk;">
				<thead>
					<tr>
						<th class="text-center">No.</th>
						<th class="text-center">Produk</th>
						<th class="text-center">Harga</th>
						<th class="text-center">Jumlah</th>
						<th class="text-center">Ubah Jumlah Produk</th>								
						<th class="text-center">Subharga</th>
						<th class="text-center">Aksi</th>				
					</tr>
				</thead>
				<tbody>
					<?php $nomor=1;?>
					<?php foreach ($_SESSION['keranjang'] as $Id_Produk => $jumlah):?>
					<?php
					$ambil=$koneksi->query("SELECT * FROM produk WHERE Id_Produk = '$Id_Produk'");
					$pecah=$ambil->fetch_assoc();
					$subharga=$pecah['Harga']*$jumlah;
					?>
					<tr>
						<td><?php echo $nomor;?></td>
						<td><?php echo $pecah['Nm_Produk']; ?></td>
						<td>Rp.<?php echo number_format ($pecah['Harga']); ?></td>
						<td><?php echo $jumlah; ?></td>
						<td>
							<form method="post">
								<div class="form-group">
									<div class="input-group">
										<input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $pecah["Stok"]?>">
										<div class="input-group-btn">
											<button class="btn btn-primary" name="beli">ubah</button>
										</div>
									</div>
								</div>
							</form>
						</td>
						<td>Rp.<?php echo number_format($subharga);?> </td>
						<td>
							<a href="hapuskeranjang.php?id=<?php echo $Id_Produk?>" class="btn btn-danger btn-xs" 
							onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
						</td>
					</tr>
					<?php $nomor++;?>
					<?php endforeach ?>
				</tbody>
			</table>
			<a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
			<a href="checkout.php" class="btn btn-succes"><button class="btn btn-success" name="checkout">Checkout</button></a>
		</div>
	</section>
	<?php 
			
			if (isset($_POST["beli"]))
			{
				$jumlah =$_POST["jumlah"];
				//masukkan dikeranjang
				$_SESSION["keranjang"][$Id_Produk]=$jumlah;
				
				echo "<script>alert('Produk telah masuk ke keranjang belanja');</script>";
				echo "<script>location='keranjang.php';</script>";
			}
	?>
</body>
</html>
