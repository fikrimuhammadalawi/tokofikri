<?php 
session_start();
$koneksi=new mysqli("localhost","root","","GoParfum");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>Go Parfum | Detail</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<BODY STYLE="BACKGROUND-IMAGE:URL(detail.JPG)">
	<?php include 'menu.php'; ?>
	<section class="konten">
		<div class="container">
			<h1><b><font face ="algerian">Detail Produk</font></b></h1>
			<?php
				$Id_Produk=$_GET["id"];			
				$ambil= $koneksi->query("SELECT * FROM produk JOIN merk ON produk.Id_Merk=merk.Id_Merk
										JOIN jenis ON produk.Id_Jenis=jenis.Id_Jenis WHERE produk.Id_Produk='$_GET[id]'");
				$detail = $ambil->fetch_assoc();
			?>
			<div class="row">
				<div class="col-md-6">
					<img src="Foto/<?php echo $detail["Foto"];?>" class="img-responsive">
				</div>
				<div class="col-md-6">
					<h3><?php echo $detail['Nm_Produk'];?></h3>
					<h4> Harga: Rp.<?php echo number_format($detail['Harga']);?></h4>
					<h4> Stok: <?php echo $detail['Stok'];?></h4>
					<h4> Merk: <?php echo $detail['Nm_Merk'];?></h4>
					<h4> Jenis: <?php echo $detail['Nm_Jenis'];?></h4>
				</div>
				<form method="post">
					<div class="form-group">
						<div class="input-group">
							<input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['Stok']?>">
							<div class="input-group-btn">
								<button class="btn btn-success" name="beli">Beli Sekarang</button>
							</div>
						</div>
					</div>
				</form>
				<?php
				if (isset($_POST['beli']))
				{
					$jumlah =$_POST["jumlah"];
					//masukkan ke keranjang belanja
					$_SESSION["keranjang"][$Id_Produk]=$jumlah;
					
					echo "<script>alert('Produk Telah Masuk Ke Keranjang Belanja!');</script>";
					echo "<script>location='keranjang.php';</script>";
				}
				?>
				<a href="index.php"class="btn btn-warning">Kembali</a>
			</div>
		</div>
	</section>
<body>
</html>