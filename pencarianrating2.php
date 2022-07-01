<?php
if(isset($_POST['cari']))
{
	$_SESSION['session_pencarian'] = $_POST["keyword"];
	$keyword=$_SESSION['session_pencarian'];
}
else
{
	$keyword=$_SESSION['session_pencarian'];
}
$query=mysqli_query($koneksi, "SELECT * FROM faktur WHERE bintang LIKE '%$keyword%' ")
?>
<div class="row">
    <div class="col-lg-12">
        <h2>Pencarian Rating</h2>   
</div>
    </div>              
<!-- /. ROW  -->
<hr />
<form class="form-horizontal" role="search" method="post" action="index2.php?halaman=pencarianrating2">
		<div class="col-md-3">
		<div class="form-group">
				<input type="text" class="form-control" name="keyword" placeholder="Masukkan Nama Rating" autofocus autocomplete="off">
			</div>
		</div>
		<div class="col-md-2">
			<label></label>
			<button class="btn btn-primary" name="cari">Cari</button>
		</div>
</form>
<table class="table table-bordered "background="bg.jpg">
	<thead>
		<tr>
			<th> No. </th>
			<th> No.Faktur </th>
			<th> Username </th>	
			<th> Rating </th>
			<th> Ulasan </th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$koneksi->query("SELECT*FROM faktur WHERE Bintang LIKE '%$keyword%'");?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td> <?php echo $pecah['No_Faktur']; ?></td>
			<td> <?php echo $pecah['Username']; ?></td>
			<td><?php echo $pecah['Bintang']; ?></td>
			<td><?php echo $pecah['Penilaian_Produk']; ?></td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>