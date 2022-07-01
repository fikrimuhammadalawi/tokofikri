<?php 
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title> Go Parfum | Faktur </title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body background="2.jpg">
<?php include 'menu.php'; ?>
	<section class="konten">
		<div class="container">
			<h2><font face ="algerian"color="white">Detail Pembelian</font></h2>
				<?php 
				$ambil= $koneksi->query("SELECT * FROM faktur JOIN pembeli 
										ON faktur.Username=pembeli.Username
										WHERE faktur.No_Faktur='$_GET[id]'");
				$detail = $ambil->fetch_assoc();
				?>
				<?php 
				$ambill= $koneksi->query("SELECT * FROM faktur JOIN bayar on faktur.Id_Bayar=bayar.Id_Bayar JOIN daftarkirim 
										ON faktur.Id_DaftarKirim=daftarkirim.Id_DaftarKirim JOIN tujuan 
										ON daftarkirim.Id_Tujuan=tujuan.Id_Tujuan JOIN sistemjasa
										ON daftarkirim.Id_SistemJasa=sistemjasa.Id_SistemJasa JOIN jasakirim
										ON sistemjasa.Id_JasaKirim=jasakirim.Id_JasaKirim JOIN jenisjasakirim
										ON sistemjasa.Id_JenisJasaKirim=jenisjasakirim.Id_JenisJasaKirim
										WHERE faktur.No_Faktur='$_GET[id]'");
				$detaill = $ambill->fetch_assoc();
				?>
				<!-- Jika pelanggan yang beli tidak sama dengan pelanggan yang login, maka dilarikan ke riwayat.php-->
				<?php
				//Mendapatkan Username yang beli
				$pembeliyangbeli=$detail["Username"];
				//Mendapatkan Username yang login
				$pembeliyanglogin= $_SESSION["pembeli"]["Username"];
				if($pembeliyangbeli!==$pembeliyanglogin)
				{
					echo "<script>alert('Faktur milik pembeli yang lain');</script>";
					echo "<script>location='riwayat.php';</script>";
					exit();
				}
				?>
				<div class="row">
					<div class="col-md-4">
					<font color="white"><h3>Pembelian</h3>
						<strong>No. Faktur: <?php echo $detail['No_Faktur'];?></strong><br> 
						Tanggal: <?php echo $detail['Tgl_Beli']; ?> <br>
						Total: Rp. <?php echo number_format($detail['Total_Bayar']); ?><br>
						Jenis Pembayaran: <?php echo $detaill['Nm_Bayar']; ?> <br>
					</div>
					<div class="col-md-4">
						<h3>Pembeli</h3>
						<strong><?php echo $detail['Nm_Pembeli'];?></strong><br> 
						<p>
							<?php echo $detail['No_HPPembeli'];?><br>
						</p>
					</div>
					<div class="col-md-4">
						<h3>Pengiriman</h3>
						<strong><?php echo $detaill['Nm_Tujuan']; ?></strong> <br>
						<p>
							Jasa Kirim: <?php echo $detaill['Nm_JasaKirim']; ?> <br>
							Jenis Jasa Kirim: <?php echo $detaill['Nm_JenisJasaKirim']; ?> <br>
							Tarif: Rp. <?php echo number_format ($detaill['Tarif']); ?><br>
							Alamat: <?php echo $detail['Almt_Pengiriman']; ?></font>
						</p>
					</div>
				</div>
				<table class="table table-bordered"style="background-color:darkkhaki;">
					<thead>
						<tr>
							<th class="text-center"> No. </th>
							<th class="text-center"> Nama Produk </th>
							<th class="text-center"> Harga </th>
							<th class="text-center"> Jumlah Produk </th>
							<th class="text-center"> Sub Total </th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor=1; ?>
						<?php $totalbelanja=0;?>
						<?php $ambil=$koneksi->query("SELECT * FROM transaksi WHERE transaksi.No_Faktur='$_GET[id]'");?>
						<?php while($pecah=$ambil->fetch_assoc()){ ?>
						<tr>
							<td><?php echo $nomor; ?> </td>
							<td><?php echo $pecah['Nama']; ?> </td>
							<td> Rp.<?php echo number_format ($pecah['Harga']); ?></td>
							<td><?php echo $pecah['Qty']; ?></td>
							<td>Rp.<?php echo number_format($pecah['Subharga']); ?> </td>
						</tr>
						<?php $nomor++ ?>
						<?php $totalbelanja+=($pecah['Harga']*$pecah['Qty']);?>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4"> Total Belanja</th>
							<th>Rp.<?php echo number_format( $totalbelanja)?>
						</tr>
						<tr>
							<th colspan="4"> Biaya Pengiriman</th>
							<th>Rp.<?php echo number_format( $detaill["Tarif"]); ?> 
						</tr>
						<tr>
							<th colspan="4"> Total Bayar</th>
							<th>Rp.  <?php echo number_format($detail['Total_Bayar']); ?></th>
						</tr>
					</tfoot>
				</table>
				<div class="row">
					<div class="col-md-7">
						<div class="alert alert-info">
							<p>
								<strong>Silakan hubungi No. WhatsApp 089627870348 untuk mengajukan complain ! </strong>
							</p>
						</div>	
					</div>
				</div>
		</div>
</body>
</html>