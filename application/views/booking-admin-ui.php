<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Booking Jadwal Terapi - RTH - Rumah Terapi Herbal</title>
	<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
	<script src="/js/moment.js"></script>
	<script src="/js/rth-mobile-admin-ui.js"></script>
	<link rel="stylesheet" href="/css/layout.css" />


</head>
<body>

<section id="page0" data-role="page">
<header data-role="header" data-position="fixed" ><h1>RTH - Rumah Terapi Herbal</h1></header>
<div id="container" class="content" data-role="content" >
	
	<img src="/images/bismillah.png" /> <br>
	<img src="/images/loading.gif"/>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page1" data-role="page">
<header data-role="header" data-position="fixed"><h1>Administrator</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Akses Login</h3>
	<img src="/images/logo.png"/>
	<form id="form-login" action="" method="post" data-ajax="false" >
	
	<input type="hidden" name="as"  id="as" value="admin" />
	
	<div data-role="fieldcontain">
	<label for="username">Email atau nomor hp:</label>
	<input type="text" name="username" placeholder="ketik disini" id="username" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="pass">Password:</label>
	<input type="password" name="pass" placeholder="ketik disini" id="pass" />
	</div>
	
	<input id="tombol-login-submit" data-inline="true" data-role="submit" type="submit" value="login">
	
	</form>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-management-booking" data-role="page">
<header data-role="header" data-position="fixed"><h1>Management Booking Request</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Pilih Booking Request</h3>
	<p>Aktifkan status masing-masing pelayanan</p>
	
	<div id="management-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="management-control">
		<a id="link-update" href="" data-transition="pop" >Update Status</a>
		<a href="" id="link-delete">Delete Selected</a>
		<a href="" id="refresh-all">Refresh</a>
	</div>
	
	
	<div class="ui-grid-d" id="data-table-head" >
		<div class="ui-block-a"><b>ID</b></div>
		<div class="ui-block-b"><b>CODE</b></div>
		<div class="ui-block-c"><b>USERNAME</b></div>
		<div class="ui-block-d"><b>SCHEDULE DATE</b></div>
		<div class="ui-block-e"><b>STATUS</b></div>
	</div>
	
	
	<a href="" id="link-logout" data-inline="true" data-role="button">Logout &#60;&#60;</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-update-stat" data-close-btn="right" data-role="page" data-dialog="true">
<header data-role="header" data-position="fixed"><h1>Booking Request</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Update Status</h3>
	<img src="/images/write.png"/>
	<p >Kode : <span id="upstat-code-treatment">xxx</span> untuk 
	<b><span id="upstat-username-treatment">xxx </span></b> pada
	<b><span id="upstat-schedule-treatment">xxx </span></b>.
	</p>
	
	<select id="status-treatment" >
		<option value="cancel">cancel</option>
		<option value="changed">changed</option>
		<option value="approved">approved</option>
		<option value="completed">completed</option>
	</select>
	
	<a href="" id="confirm-data-terpilih" data-inline="true" data-role="button">Update ya!</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-failed" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Gagal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Terdapat Kesalahan Server</h3>
	<img src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, booking gagal! </p>
	<p>Saat ini server <strong>sedang sibuk</strong> silahkan coba lagi setelah 1 jam kembali.</p>
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-login-failed" data-role="page">
<header data-role="header" data-position="fixed"><h1>Login Gagal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Akses Salah</h3>
	<img src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, apakah kamu lupa akses login? </p>
	<p>Cobalah pakai <strong>email atau nomor whatsapp </strong> yg masih valid untuk bisa login di sistem booking jadwal!</p>
	<a href="#page1" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-error-server" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pendaftaran Gagal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Pembuatan Akun Gagal</h3>
	<img src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, server sedang error! </p>
	<p>Cobalah <strong> kembali lagi kemari dalam 30 menit setelah ini</strong> untuk dapat melakukan booking jadwal!</p>
	<a href="#page0" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Jadwal Berhasil</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Jadwal Sukses di-booking!</h3>
	<img src="/images/success.png"/>
	<p>Walhamdulillah, jadwal booking anda berhasil! </p>
	<p>Kode Booking : <strong id="booking-success-code">xxxx</strong> dengan Jadwal anda :<strong id="booking-success-date" > xxxx</strong> </p>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-check-email" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pendaftaran Berhasil</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Aktifasi Akun</h3>
	<img src="/images/email.png"/>
	<p>Walhamdulillah, data anda telah tersimpan di-server! </p>
	<p>Check <strong>inbox email</strong> anda untuk aktifasi akun booking jadwal!</p>
	<a href="https://mail.google.com" data-role="button">&#62;&#62; selanjutnya</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

</body>
</html>
