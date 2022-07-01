<!-- Navbar -->
	<nav class="navbar navbar-default">
		<div class ="container">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><b><font face="algeria" size="3" color="black">HOME</a></li></font></b>
				<li><a href="keranjang.php"><b><font face="algeria" size="3" color="black">KERANJANG</a></li></font></b>
				<li><a href="checkout.php"><b><font face="algeria" size="3"color="black">CHECKOUT</a></li></font></b>
				<!-- Jika Sudah Login (ada session pembeli)-->
				<?php if (isset($_SESSION['pembeli'])): ?>
					<li><a href="riwayat.php"><b><font face="algeria" size="3"color="black">RIWAYAT BELANJA</a></li></font></b>
					<li><a href="logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Logout?')"><b><font face="algeria" size="3"color="black">LOGOUT</a></li></font></b>
				<!-- Jika Belum Login (tidak ada session pembeli)-->
					<?php else: ?>
				<li><a href="daftar.php"><b><font face="algeria" size="3"color="black">DAFTAR</a></li></font></b>
				<li><a href="login.php"><b><font face="algeria" size="3"color="black">LOGIN</a></li></font></b>
				<?php endif ?>
			</ul>
			<form action="pencarian.php" method="get" class="navbar-form navbar-right">
				<input type="text" class="form-control" name="keyword">
				<button class="btn btn-primary">Cari</button>
			</form>
		</div>
	</nav>