<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Reset Password</title>
	<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />
	<link rel="icon" type="image/png" href="<?php base_url() ?>images/logo.png">
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="/js/pass-recovery.js"></script>
</head>
<body>



<section id="page0" data-role="page">
<header data-role="header" data-position="fixed" ><h1>RTH - Rumah Terapi Herbal</h1></header>
<div class="content" data-role="content" >
	
	 <h4 id="error_message" hidden >Error! Kata kunci tidak sama....</h4>
	
	<form id="form-recovery" method="post" data-ajax="false" >
	 <input id="token" name="token" type="text" value="<?= $token ?>" />
		<label for="pass">Password:</label>
		<input class="inputan" type="password" id="pass" name="pass" placeholder="ketik kata kunci terbaru disini" /> <br>
		<label for="pass2">Ketik lagi Password tadi:</label>
		<input class="inputan" type="password" id="pass2" name="pass2" placeholder="ketik lagi kata kunci disini" />
		<input id="tombol-submit" type="submit" value="save" />
	</form>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-error-server" data-role="page">
<header data-role="header" data-position="fixed"><h1>System Error</h1></header>
<div  class="content" data-role="content" >
	<h3>Data Gagal Diproses</h3>
	<img alt="error image" src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, server sedang error! </p>
	<p>Cobalah <strong> kembali lagi kemari dalam 30 menit setelah ini</strong> untuk dapat melakukan proses data!</p>
	<a href="#page0" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-password-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Password Status</h1></header>
<div  class="content" data-role="content" >
	<h3>Data berhasil Diproses</h3>
	<img alt="success image" src="/images/success.png"/>
	<p>Walhamdulillah, password berhasil diperbarui...!</p>
	<p>Silahkan coba kembali login... dengan data terbaru!</p>
	<a href="#" id="link-relogin" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>
   

</body>
</html>