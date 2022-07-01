<?php
session_start();
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
$keyword=$_GET["keyword"];
$semuadata=array();
$ambil=$koneksi->query("SELECT * FROM Produk WHERE Nm_Produk LIKE '%$keyword%' ORDER BY produk.Nm_Produk ASC");
while($pecah=$ambil->fetch_assoc())
{
	$semuadata[]=$pecah;
}	
?>
<html>
<head>
	<title>Pencarian</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'menu.php'; ?>
<BODY STYLE="BACKGROUND-IMAGE:URL(index.jpg)">
	<div class="container">
		<h2><b><center><font face ="algerian" color="white">Hasil Pencarian: <?php echo $keyword ?></font></b></center><h2>
		<?php if(empty($semuadata)):?>
			<div class="alert alert-danger">Produk <strong><?php echo $keyword?></strong> tidak ditemukan</div>
		<?php endif?>
		<?php foreach ($semuadata as $key =>$value):?>
		<div class="col-md-3">
			<div class="thumbnail">
				<img src="Foto/<?php echo $value["Foto"]?>" alt="" class="img-responsive">
				<div class="caption text-center">
					<h3><?php echo $value["Nm_Produk"];?></h3>
					<h5>Rp.<?php echo number_format($value['Harga'])?></h5>
					<h5>Stok: <?php echo $value['Stok']; ?></h5>
					<a href="beli.php?id=<?php echo $value["Id_Produk"];?>" class="btn btn-success">Beli Sekarang</a>
					<a href="detail.php?id=<?php echo $value["Id_Produk"];?>" class="btn btn-primary">Detail Produk</a>
				</div>
			</div>
		</div>
		<?php endforeach?>
	</div>
</body>
</html>