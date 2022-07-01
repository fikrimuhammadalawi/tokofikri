<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "GoParfum";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
session_start();

$idpem= $_GET["id"];
$ambil=$koneksi->query("SELECT *FROM faktur WHERE No_Faktur='$idpem'");
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
<body background="6.jpg"></body>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
	<title> Penilaian </title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include'menu.php'?>
<div class="container">
<font color="white">
	<h2>Penilaian Produk</h2>
	<div class="alert alert-info"> <strong>Terima kasih telah berbelanja di toko kami! Dengan mengisi penilaian artinya Anda
	telah mengonfirmasi bahwa produk telah sampai</strong></div>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label> Silakan beri penilaian Anda ! </label>
			<textarea class="form-control" name="penilaian" placeholder="Berikan Penilaian Anda" required></textarea>
		</div>
			<div class="rateyo" id= "rating"
			data-rateyo-rating="4"
			data-rateyo-num-stars="5"
			data-rateyo-score="3">
        </div>
		<span class='result'></span>
		<input type="hidden" name="rating">
		<button class="btn btn-primary" name="kirim"> Kirim</button>
	</form>
	<br>
	<div class="alert alert-danger"><strong>Jika Anda merasa tidak puas terhadap produk yang telah sampai atau terdapat permasalahan dalam pengiriman produk
	silakan ajukan complain<span><a href="complain.php?id=<?php echo $detpem["No_Faktur"];?>"> di sini</a></span></strong></div>	
</div></font>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $(function () {
        $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('rating :'+ rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });

</script>
</body>
</html>
<?php
//jika tombol kirim diklik
if(isset($_POST["kirim"]))
{
	$nilai =$_POST["penilaian"];
	$rating =$_POST["rating"];
	$koneksi->query("UPDATE faktur SET Penilaian_Produk='$nilai',Bintang='$rating' WHERE No_Faktur='$idpem'");			
	//update status pembayaran
	$koneksi->query("UPDATE faktur SET Id_Status='ST005' WHERE No_Faktur='$idpem'");

	echo "<script>alert('Terima kasih sudah memberi penilaian ');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>