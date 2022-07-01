<?php
session_start();
$koneksi=new mysqli("localhost" , "root" , "" , "GoParfum"); 
if (!isset($_SESSION['pembeli']))
{
	echo "<script>alert('Silakan Login');</script>";
	echo "<script>location='login.php';</script>";
}
if (empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang']))
{
	echo "<script>alert('Produk kosong, silakan belanja terlebih dahulu');</script>";
	echo "<script>location='index.php';</script>";
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Go Parfum | Checkout</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<BODY STYLE="BACKGROUND-IMAGE:URL(4.JPG)">
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
						<th class="text-center">Subharga</th>						
					</tr>
				</thead>
				<tbody>
					<?php $nomor=1;?>
					<?php $total_belanja=0;?>
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
						<td>Rp.<?php echo number_format($subharga);?> </td>
					</tr>
					<?php $nomor++;?>
					<?php $total_belanja+=$subharga; ?>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<th class="text-center" colspan="4">Total</th>
					<th class="text-center">Rp. <?php echo number_format($total_belanja); ?></th>
				</tfoot>
			</table>
			<form method="POST">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" readonly class="form-control text-center" value="<?php echo $_SESSION['pembeli']['Nm_Pembeli']; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group" name="Almt_Pembeli">
							<input type="text" readonly class="form-control text-center" value="<?php echo $_SESSION['pembeli']['Almt_Pembeli']; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" readonly class="form-control text-center" value="<?php echo $_SESSION['pembeli']['No_HPPembeli']; ?>">
						</div>
					</div>
					<div class="col-md-4">
					<select class="form-control" name="Id_DaftarKirim">
						<option value="">Pilih Pengiriman</option>
						<?php
						$Almt_Pembeli=$_SESSION["pembeli"]["Almt_Pembeli"];
						$ambil=$koneksi->query("SELECT * FROM daftarkirim JOIN tujuan 
												ON daftarkirim.Id_Tujuan=tujuan.Id_Tujuan JOIN sistemjasa
												ON daftarkirim.Id_SistemJasa=sistemjasa.Id_SistemJasa JOIN jasakirim
												ON sistemjasa.Id_JasaKirim=jasakirim.Id_JasaKirim JOIN jenisjasakirim
												ON sistemjasa.Id_JenisJasaKirim=jenisjasakirim.Id_JenisJasaKirim WHERE Nm_Tujuan='$Almt_Pembeli'");
						while($perongkir=$ambil->fetch_assoc()){
						?>
						<option value="<?php echo $perongkir['Id_DaftarKirim']; ?>">
							<?php echo $perongkir['Nm_Tujuan'];?> - 
							<?php echo $perongkir['Nm_JasaKirim'];?> - 
							<?php echo $perongkir['Nm_JenisJasaKirim'];?> - 
							Rp.<?php echo number_format($perongkir['Tarif']);?>
						</option>
						<?php }?>
					</select>
					</div>
					<div class="col-md-4">
					<select class="form-control" name="Id_Bayar">
						<option value="">Pilih Jenis Pembayaran</option>
						<?php
						$ambil=$koneksi->query("SELECT * FROM bayar");
						while($pembayaran=$ambil->fetch_assoc()){
						?>
						<option value="<?php echo $pembayaran['Id_Bayar']; ?>">
						<?php echo $pembayaran['Nm_Bayar'];?>
						</option>
						<?php }?>
					</select>
					</div>
				</div>
				<br>
				<div class="form-group">
					<label> Alamat Lengkap Pengiriman</label>
					<textarea class="form-control" name="Almt_Pengiriman" placeholder="Masukkan Alamat Lengkap Pengiriman" required></textarea>
				</div>
				<button class="btn btn-success" name="checkout">Checkout</button>
			</form>
			<?php
			if(isset($_POST['checkout']))
			{
				$Username=$_SESSION["pembeli"]["Username"];
				$Id_DaftarKirim=$_POST["Id_DaftarKirim"];
				$Tgl_Beli=date("Y-m-d");
				$Almt_Pengiriman=$_POST["Almt_Pengiriman"];
				$Id_Bayar=$_POST["Id_Bayar"];
				$Id_Status="ST001";
				
				$ambil=$koneksi->query("SELECT * FROM daftarkirim WHERE Id_DaftarKirim='$Id_DaftarKirim'");
				$array_daftarkirim=$ambil->fetch_assoc();
				$tarif=$array_daftarkirim['Tarif'];
				$Total_Bayar=$total_belanja + $tarif;
				
				$query=mysqli_query($koneksi, "SELECT max(No_Faktur) as kodeTerbesar FROM faktur");
				$data=mysqli_fetch_array($query);
				$No_Faktur=$data['kodeTerbesar'];
				$urutan=(int) substr($No_Faktur,3,3);
				$urutan++;
				$huruf="FK";
				$No_Faktur = $huruf . sprintf("%03s", $urutan);
				//menyimpan data ke tabel faktur
				$koneksi->query("INSERT INTO faktur (No_Faktur,Id_Status,Id_Bayar,Id_DaftarKirim,Username,Tgl_Beli,Total_Bayar,Almt_Pengiriman) 
				VALUES ('$No_Faktur','$Id_Status','$Id_Bayar','$Id_DaftarKirim','$Username','$Tgl_Beli','$Total_Bayar','$Almt_Pengiriman')");
				foreach($_SESSION["keranjang"] as $Id_Produk=>$Qty)
				{
					//Mendapatkan data produk berdasarkan Id_Produk
					$ambil=$koneksi->query("SELECT * FROM produk WHERE Id_Produk = '$Id_Produk'");
					$perproduk=$ambil->fetch_assoc();
					
					$nama=$perproduk["Nm_Produk"];
					$harga=$perproduk["Harga"];
					$subharga=$perproduk["Harga"]*$Qty;
					$koneksi->query("INSERT INTO transaksi (Id_Produk,No_Faktur, Qty, Nama, Harga, Subharga) 
					VALUES ('$Id_Produk','$No_Faktur','$Qty','$nama','$harga','$subharga')");
					//skrip update stok
					$koneksi->query("UPDATE produk SET Stok=Stok-$Qty WHERE Id_Produk='$Id_Produk'");
				}
				//mengosongkan keranjang belanja
				unset($_SESSION["keranjang"]);
				
				//tampilan dialihkan ke faktur pembelian barusan
				echo "<script>alert('Pembelian Sukses');</script>";
				echo "<script>location='faktur.php?id=$No_Faktur';</script>";
			}		
			?>
		</div>
	</section>
</body>
</html>