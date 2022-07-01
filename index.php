<?php
session_start();
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
$merk = "";
$ukuran = "";
$jenis = "";
$strq = "";
$strw = "";
$jmlget = 0;

	if(isset($_GET['merk']))
	{
      $merk = $_GET['merk'];
      $strc[] = "produk.Id_Merk = '$merk'";
      $jmlget++;
    }
    if(isset($_GET['ukuran']))
	{
      $ukuran = $_GET['ukuran'];
      $strc[] = "produk.Id_Ukuran = '$ukuran'";
      $jmlget++;
    }
	if(isset($_GET['jenis']))
	{
		$jenis = $_GET['jenis'];
		$strc[] = "produk.Id_Jenis = '$jenis'";
		$jmlget++;
	  }
    // susun string
    $i = 1;
    if($jmlget > 0)
	{
      $strw = "WHERE ";
      foreach($strc as $strs)
	  {
        $strw .= $strs;
        if($i < $jmlget)
		{
          $strw .= " AND ";
          $i++;
        }
      }
    }
    $query = "SELECT * FROM `produk` inner join merk on produk.Id_Merk=merk.Id_Merk
			 inner join ukuran on produk.Id_Ukuran=ukuran.Id_Ukuran inner join 
			 jenis on produk.Id_Jenis=jenis.Id_Jenis
    $strw";
    $result=mysqli_query($koneksi,$query);
    $resnum = mysqli_num_rows($result);
	
	$query_jenis  = "SELECT * FROM jenis";
    $result_jenis = mysqli_query($koneksi,$query_jenis);

    $query_merk  = "SELECT * FROM merk";
    $result_merk = mysqli_query($koneksi,$query_merk);

	$query_ukuran  = "SELECT * FROM ukuran";
	$result_ukuran = mysqli_query($koneksi,$query_ukuran);

    $title = "GoParfum"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Go Parfum</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<BODY STYLE="BACKGROUND-IMAGE:URL(2.jpg)">
<?php include'menu.php'?>
<!--konten-->
<section class="konten">
	<div class="container">
		<center><b><font face="cornsilk" color="white" size="30"> Welcome to Go Parfum </font></b></center>
	<div class="row">
    <form action="index.php" method="GET">
        <div class="row">
            <div class="col-sm">
				<div class="col-md-12 col-lg-3 products-number-sort">
					<div class="products-sort-by mt-2 mt-lg-0">
						<select name="jenis" class="form-control">
							<option selected disabled>-- PILIH JENIS -- </option>
								<?php while($row = mysqli_fetch_assoc($result_jenis)) { ?>
									<option value="<?php echo $row['Id_Jenis']; ?>"> <?php echo $row['Nm_Jenis']; ?></option>
								<?php } ?>
						</select>
                    </div>
				</div>
				<div class="col-md-12 col-lg-3 products-number-sort">
					<div class="products-sort-by mt-2 mt-lg-0">
						<select name="merk" class="form-control">
							<option selected disabled>-- PILIH MERK -- </option>
							 <?php while($row = mysqli_fetch_assoc($result_merk)) { ?>
								<option value="<?php echo $row['Id_Merk']; ?>"> <?php echo $row['Nm_Merk']; ?></option>
							 <?php } ?>
						</select>
                     </div>
				</div>
				<div class="col-md-12 col-lg-3 products-number-sort">
					<div class="products-sort-by mt-2 mt-lg-0">
						<select name="ukuran" class="form-control">
							<option selected disabled>-- PILIH UKURAN -- </option>
							 <?php while($row = mysqli_fetch_assoc($result_ukuran)) { ?>
								<option value="<?php echo $row['Id_Ukuran']; ?>"> <?php echo $row['Nm_Ukuran']; ?></option>
							 <?php } ?>
						</select>
                     </div>
				</div>	  
			</div>
			<div class="row">
				<div class="col-sm">
					<input type="submit" class="btn btn-primary mb-4" name="submit" value="Search">
				</div>
			</div>
			<?php if($resnum == 0){ ?>
			<div clas="row">
				<div class="alert alert-danger"><strong><font size="4">Produk tidak tersedia</strong></div>
			</div>
			<?php } ?>
		</div>
	</form>
	<br>
		<div class="row">
			<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<div class="col-md-3">
				<div class="thumbnail">
					<img src="Foto/<?php echo $row['Foto'];?>" alt="">
					<div class="caption text-center">
						<h4><strong> <?php echo $row['Nm_Produk'];?></strong> </h4>
						<h5> Rp.<?php echo number_format($row['Harga']);?></h5>
						<h5>Stok: <?php echo $row['Stok']; ?></h5>
						<a href="beli.php?id=<?php echo $row['Id_Produk'];?>" class="btn btn-success">Beli Sekarang</a>
						<a href="detail.php?id=<?php echo $row["Id_Produk"]?>" class="btn btn-primary">Detail Produk</a>
					</div>
				</div>
			</div>
			<?php }?>	
		</div>
	</div>
	</div>
</section>
</body>
</html>



