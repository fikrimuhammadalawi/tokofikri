<?php
session_start();
//mendapatkan Id_Produk dari url
$Id_Produk = $_GET['id'];


// jika sudah ada produk itu di keranjang maka produk itu jumlahnya ditambah 1
if(isset($_SESSION['keranjang'][$Id_Produk]))
{
	$_SESSION['keranjang'][$Id_Produk]+=1;
}
//selain itu(blm ada dikeranjang, maka produk dianggap dibeli 1
else
{
	$_SESSION['keranjang'][$Id_Produk]=1;
}

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";


//larikan ke halaman keranjang
echo "<script>alert('Produk Telah Masuk Ke Keranjang Belanja!');</script>";
echo "<script>location='keranjang.php';</script>";

?>