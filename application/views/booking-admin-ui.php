<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	
	<title>Booking Jadwal Terapi - RTH - Rumah Terapi Herbal</title>
	<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="/js/jquery.mobile-1.4.5.min.js<?= $myKey; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
	<script src="/js/moment.js<?= $myKey; ?>"></script>
	<script src="/js/calendar.js<?= $myKey; ?>"></script>
	<script src="/js/rth-mobile-admin-ui.js<?= $myKey; ?>"></script>
	<link rel="stylesheet" href="/css/layout.css<?= $myKey; ?>" />
	<link rel="stylesheet" href="/css/layout-admin.css<?= $myKey; ?>" />
	<link rel="stylesheet" href="/css/calendar-theme.css<?= $myKey; ?>" />
	<link rel="stylesheet" href="/css/calendar-style.css<?= $myKey; ?>" />


</head>
<body>

<section id="page0" data-role="page">
<header data-role="header" data-position="fixed" ><h1>RTH - Rumah Terapi Herbal</h1></header>
<div class="content" data-role="content" >
	
	<img alt="bismillah image" src="/images/bismillah.png" /> <br>
	<img alt="loading image" src="/images/loading.gif"/>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page1" data-role="page">
<header data-role="header" data-position="fixed"><h1>Administrator</h1></header>
<div  class="content" data-role="content" >
	<h3>Akses Login</h3>
	<img alt="rth logo" src="/images/logo.png"/>
	<form id="form-login"  method="post" data-ajax="false" >
	
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

<section id="page-management-pasien" data-role="page">
<header data-role="header" data-position="fixed"><h1>Management Pasien</h1></header>
<div  class="content" data-role="content" >
	<h3>Pilih Akses Pasien</h3>
	<p>Aktifkan masing-masing pasien (pengguna web portal ini)</p>
	
	<div id="management-loading-pasien"><img alt="loading image" src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="management-control-pasien">
		<a id="link-reset" href="" data-transition="pop" >Reset Password</a>
		<a href="" id="link-aktifasi">Aktifasi</a>
		<a href="" id="link-non-aktifasi">Kunci</a>
		<a href="" id="refresh-pasien">Refresh</a>
	</div>
	
	<div class="ui-grid-d" id="pasien-table-head" >
		<div class="ui-block-a"><b>ID</b></div>
		<div class="ui-block-b"><b>FULLNAME</b></div>
		<div class="ui-block-c"><b>CONTACT</b></div>
		<div class="ui-block-d"><b>STATUS</b></div>
		<div class="ui-block-e"><b>GENDER</b></div>
	</div>
	<a href="#page-menu-aksi"  data-inline="true" data-role="button">&lt;&lt; Kembali </a>
	<a href="" class="link-calendar" data-inline="true" data-role="button">Kalendar</a>
	<a href="" id="link-logout" data-inline="true" data-role="button">- Logout -</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-management-booking" data-role="page">
<header data-role="header" data-position="fixed"><h1>Management Booking Request</h1></header>
<div  class="content" data-role="content" >
	<h3>Pilih Booking Request</h3>
	<p>Aktifkan status masing-masing pelayanan</p>
	
	<div id="management-loading"><img alt="loading image" src="/images/loading.gif" /><span>Loading...
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
	<a href="#page-menu-aksi"  data-inline="true" data-role="button">&lt;&lt; Kembali </a>
	<a href="" class="link-calendar" data-inline="true" data-role="button">Kalendar</a>
	<a href="" id="link-logout" data-inline="true" data-role="button">- Logout -</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-update-stat" data-close-btn="right" data-role="page" data-dialog="true">
<header data-role="header" data-position="fixed"><h1>Booking Request</h1></header>
<div  class="content" data-role="content" >
	<h3>Update Status</h3>
	<span hidden id="upstat-id-treatment" ></span>
	<span hidden id="upstat-computer-date-treatment" ></span>
	<span hidden id="upstat-computer-hour-treatment" ></span>
	<span hidden id="upstat-gender-treatment" ></span>
	<img alt="write image" src="/images/write.png"/>
	<p><b>Kode : <span id="upstat-code-treatment">xxx</span></b> untuk 
	<b><span id="upstat-username-treatment">xxx </span></b> pada <br>
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

<section id="page-menu-aksi" data-close-btn="right" data-role="page" >
<header data-role="header" data-position="fixed"><h1>Management</h1></header>
<div  class="content" data-role="content" >
	<h3>Menu Aksi</h3>
	<p>Klik salah satu pilihan untuk mengatur data </p>
<a href="#page-management-pasien" id="link-management-pasien" data-inline="true" data-role="button">Seluruh Pasien</a>	
<a href="#page-management-booking" data-inline="true" data-role="button">Seluruh Booking</a>
<a href="#page-settings" id="link-settings" data-inline="true" data-role="button">Settings</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-detail" data-role="page">
<header data-role="header" data-position="fixed"><h1>Detail Spesifik</h1></header>
<div  class="content" data-role="content" >
	<h3>Tanggal : <span id="detail-tanggal" > </span>
	<span id="detail-loading" class="pesan-loading" >Loading...</span>
	<span id="detail-error" class="pesan-error" >Error!</span>	</h3>
	<span id="detail-tanggal-computer" hidden>  </span>
	
	<div class="ui-grid-a" id="data-jam8">
		<div class="ui-block-a">
		<label for="flip-jam8" >08:00</label>
		</div>
		<div class="ui-block-b"> 
		<select name="slider" data-id="" data-jam="08:00" id="flip-jam8" class="slider-jam" data-role="slider">
			<option value="0">Off</option>
			<option value="1">On</option>
		</select>
		</div>
		<div class="ui-block-c">
		<textarea data-id="" data-jam="08:00" id="detail-description-jam8" class="detail-description">
		</textarea>
		</div>
	</div>
	
	<div class="ui-grid-a" id="data-jam10">
		<div class="ui-block-a">
		<label for="flip-jam10" >10:00</label>
		</div>
		<div class="ui-block-b"> 
		<select name="slider" data-id="" data-jam="10:00" id="flip-jam10" class="slider-jam" data-role="slider">
			<option value="0">Off</option>
			<option value="1">On</option>
		</select>
		</div>
		<div class="ui-block-c">
		<textarea data-id="" data-jam="10:00" id="detail-description-jam10" class="detail-description" >
		</textarea>
		</div>
	</div>
	
	
	<div class="ui-grid-a" id="data-jam13">
		<div class="ui-block-a">
		<label for="flip-jam13" >13:00</label>
		</div>
		<div class="ui-block-b"> 
		<select name="slider" data-id="" data-jam="13:00" id="flip-jam13" class="slider-jam" data-role="slider">
			<option value="0">Off</option>
			<option value="1">On</option>
		</select>
		</div>
		<div class="ui-block-c">
		<textarea data-id="" data-jam="13:00" id="detail-description-jam13" class="detail-description" >
		</textarea>
		</div>
	</div>
	
	
	<div class="ui-grid-a" id="data-jam16">
		<div class="ui-block-a">
		<label for="flip-jam16" >16:00</label>
		</div>
		<div class="ui-block-b"> 
		<select name="slider" data-id="" data-jam="16:00" id="flip-jam16" class="slider-jam" data-role="slider">
			<option value="0">Off</option>
			<option value="1">On</option>
		</select>
		</div>
		<div class="ui-block-c">
		<textarea data-id="" data-jam="16:00" id="detail-description-jam16" class="detail-description" >
		</textarea>
		</div>
	</div>
	
	
	<div class="ui-grid-a" id="data-jam20">
		<div class="ui-block-a">
		<label for="flip-jam20" >20:00</label>
		</div>
		<div class="ui-block-b"> 
		<select name="slider" data-id="" data-jam="20:00" id="flip-jam20" class="slider-jam" data-role="slider">
			<option value="0">Off</option>
			<option value="1">On</option>
		</select>
		</div>
		<div class="ui-block-c">
		<textarea data-id="" data-jam="20:00" id="detail-description-jam20" class="detail-description" >
		</textarea>
		</div>
	</div>
	
	<div>
		<label></label>
	</div>
	
	<a href="#" id="link-kembali-kalendar" data-inline="true" data-role="button">&lt;&lt; Kembali</a>
	<a href="#page-terapkan-serupa" data-transition="dialog" id="link-terapkan-lainnya" data-inline="true" data-role="button">Terapkan Serupa Lainnya</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-terapkan-serupa" data-role="page">
<header data-role="header" data-position="fixed"><h1>Terapkan Serupa</h1></header>
<div  class="content" data-role="content" >
	<h3>Duplikasi Data</span></h3>
	<center class="tengah-medium">
	<label for="banyak-hari-duplikasi">Berapa hari kedepan?</label>
	<input type="range" name="banyak-hari-duplikasi" id="banyak-hari-duplikasi" 
	min="0" max="100" value="0">
	</center>
	
	<a href="#" id="link-duplikasi-apply" data-inline="true" data-role="button">Terapkan</a>
	<a href="#page-management-booking" data-inline="true" data-role="button">Kembali</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-kalendar" data-role="page">
<header data-role="header" data-position="fixed"><h1>Jadwal Keseluruhan</h1></header>
<div  class="content" data-role="content" >
	<h3>Kalendar 
	<span id="calendar-error"> error!</span> 
	<span id="calendar-loading"> loading ... </span></h3>
	<select name="slider" id="flip-gender"  data-role="slider">
			<option value="1">Ikhwan</option>
			<option value="0">Akhwat</option>
	</select>
	<div class="calendar-container"></div>

	<a href="#page-management-booking" data-inline="true" data-role="button">Kembali</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-failed" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Gagal</h1></header>
<div  class="content" data-role="content" >
	<h3>Terdapat Kesalahan Server</h3>
	<img alt="error image" src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, booking gagal! </p>
	<p>Saat ini server <strong>sedang sibuk</strong> silahkan coba lagi setelah 1 jam kembali.</p>
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-login-failed" data-role="page">
<header data-role="header" data-position="fixed"><h1>Login Gagal</h1></header>
<div  class="content" data-role="content" >
	<h3>Akses Salah</h3>
	<img alt="error image" src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, apakah kamu lupa akses login? </p>
	<p>Cobalah pakai <strong>email atau nomor whatsapp </strong> yg masih valid untuk bisa login di sistem booking jadwal!</p>
	<a href="#page1" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-error-server" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pendaftaran Gagal</h1></header>
<div  class="content" data-role="content" >
	<h3>Pembuatan Akun Gagal</h3>
	<img alt="error image" src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, server sedang error! </p>
	<p>Cobalah <strong> kembali lagi kemari dalam 30 menit setelah ini</strong> untuk dapat melakukan booking jadwal!</p>
	<a href="#page0" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Jadwal Berhasil</h1></header>
<div  class="content" data-role="content" >
	<h3>Jadwal Sukses di-booking!</h3>
	<img alt="success image" src="/images/success.png"/>
	<p>Walhamdulillah, jadwal booking anda berhasil! </p>
	<p>Kode Booking : <strong id="booking-success-code">xxxx</strong> dengan Jadwal anda :<strong id="booking-success-date" > xxxx</strong> </p>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-check-email" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pendaftaran Berhasil</h1></header>
<div  class="content" data-role="content" >
	<h3>Aktifasi Akun</h3>
	<img alt="email image" src="/images/email.png"/>
	<p>Walhamdulillah, data anda telah tersimpan di-server! </p>
	<p>Check <strong>inbox email</strong> anda untuk aktifasi akun booking jadwal!</p>
	<a href="https://mail.google.com" data-role="button">&#62;&#62; selanjutnya</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-detail" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Detail</h1></header>
<div  class="content" data-role="content" >
	
	<div id="booking-detail-loading"><img alt="loading image" src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="booking-detail-data">
	<h3>Code : <span id="booking-detail-code"> </span></h3>
	<img alt="write image" src="/images/write.png"/>
	<p>Dibooking untuk jadwal : <b><span id="booking-detail-schedule-date"> </span></b> 
	oleh : <b><span id="booking-detail-fullname" > </span></b> .</p>
	<p id="booking-detail-treatment">Untuk Treatment: <br></p>
	</div>
	
	<a href="#page-management-booking" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-settings" data-role="page">
<header data-role="header" data-position="fixed"><h1>System Settings</h1></header>
<div  class="content" data-role="content" >
	
	<div id="settings-detail-loading"><img alt="loading image" src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="settings-detail-data">
	<form id="form-settings" method="post" data-ajax="false" >

	<div data-role="fieldcontain">
		<label for="auto_accept">Auto Accept Booking Request:</label>
		<select id="auto_accept" name="auto_accept" >
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
	</div>
	
	<div data-role="fieldcontain">
		<label for="holiday">Holiday:</label>
		<select id="holiday" name="holiday" >
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
	</div>

	<input id="tombol-settings-submit" data-inline="true" data-role="submit" type="submit" value="save">
		
	</form>
	</div>
	
	<a href="#page-menu-aksi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>


<section id="page-user-detail" data-role="page">
<header data-role="header" data-position="fixed"><h1>User Detail</h1></header>
<div  class="content" data-role="content" >
	<h3><span id="profil_fullname_span">Profil</span></h3>
	<img alt="image profil" id="image-profil" src="/images/user_48.png"/>
	
	<div id="user-detail-loading"><img alt="loading image" src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="user-detail-data">
	<form id="form-profil" method="post" data-ajax="false" >
	
	<input id="profil_id" name="profil_id" type="hidden" value="" />
	<input id="profil_status" name="profil_status" type="hidden" value="" />
	<input id="profil_membership" name="profil_membership" type="hidden" value="" />
	<input id="profil_full_name" name="profil_full_name" type="hidden" value="" />
	
	<div data-role="fieldcontain">
	<label for="profil_username">Username:</label>
	<input type="text" readonly name="profil_username" placeholder="ketik disini" id="profil_username" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="profil_pass">Password:</label>
	<input type="password" name="profil_pass" placeholder="ketik disini" id="profil_pass" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="profil_email">Email:</label>
	<input type="text" name="profil_email" placeholder="ketik disini" id="profil_email" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="profil_home_address">Address:</label>
	<input type="text" name="profil_home_address" placeholder="ketik disini" id="profil_home_address" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="profil_contact">No Whatsapp:</label>
	<input type="text" name="profil_contact" placeholder="ketik disini" id="profil_contact" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="profil_gender">Gender:</label>
	<select id="profil_gender" name="profil_gender" >
		<option value="1">Ikhwan</option>
		<option value="0">Akhwat</option>
	</select>
	</div>
	
	<div data-role="fieldcontain">
	<label >Tanggal Mendaftar:</label>
	<span id="profil_date_created"> </span>
	</div>
	

	<input id="tombol-profil-submit" data-inline="true" data-role="submit" type="submit" value="save">
	
	</form></div>
	
	<a href="#page-management-pasien" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>


</body>
</html>
