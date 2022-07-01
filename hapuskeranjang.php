<?php
session_start();
$Id_Produk = $_GET["id"];
unset($_SESSION["keranjang"]["$Id_Produk"]);

echo "<script>location='keranjang.php';</script>";
?>
