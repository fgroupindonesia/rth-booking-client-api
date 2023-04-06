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
	<script src="/js/rth-mobile.js"></script>
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
<header data-role="header" data-position="fixed" ><h1>Selamat Datang!</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Booking Jadwal Terapi</h3>
	<img src="/images/logo2.png"/> <br>
	<h4>Pilih Menu</h4>
	<ul data-role="listview">
		<li><a id="link-peserta-baru-tunggal" >Untuk Peserta Baru</a></li>
		<li><a id="peserta-lama-login" href="#page-peserta-lama-login">Untuk Peserta Lama</a></li>
		<li data-role="divider">-</li>
		<li><a id="link-workshop" href="">Workshop</a></li>
	</ul>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-peserta-lama-login" data-role="page">
<header data-role="header" data-position="fixed"><h1>Peserta Lama</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Akses Login</h3>
	<img src="/images/logo.png"/>
	<form id="form-login" action="" method="post" data-ajax="false" >
	
	<div data-role="fieldcontain">
	<label for="username">Email atau nomor hp:</label>
	<input type="text" name="username" placeholder="ketik disini" id="username" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="pass">Password:</label>
	<input type="password" name="pass" placeholder="ketik disini" id="pass" />
	</div>
	
	<input id="tombol-login-submit" data-inline="true" data-role="submit" type="submit" value="login">
	
	<a href="#page-forgot-password" data-inline="true" data-role="link">Lupa password</a>
	
	</form>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-pilih-aksi" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Tanggal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Selamat Datang!</h3><span id="sembunyi-username" hidden>peserta</span>
	<p>Pilih Menu dari sini ya <b><span id="txt-fullname">peserta</span></b>! </p>
	
	<a id="link-page-riwayat" data-inline="true" data-role="button" data-icon="riwayat" >Semua Riwayat</a>
	
	<a id="link-buka-profil" data-inline="true" data-role="button" data-icon="profil" >Profil Saya</a>
	
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button" data-icon="booking" >Mau Booking</a>
	
	<br>
	
	<a id="link-page-all-anggota" data-inline="true" data-role="button" data-icon="anggota-semua" >Semua Anggota</a>
	
	<a id="link-daftar-anggota" data-inline="true" data-role="button" data-icon="anggota-baru" >Daftarkan Anggota</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>


<section id="page-profil-anda" data-role="page">
<header data-role="header" data-position="fixed"><h1>Profil Anda</h1></header>
<div id="container" class="content" data-role="content" >
	<h3><span id="profil_fullname_span">Profil</span></h3>
	<img id="image-profil" src="/images/user_48.png"/>
	
	<div id="profil-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<form id="form-profil" method="post" data-ajax="false" >
	
	<input id="profil_id" name="profil_id" type="hidden" value="" />
	<input id="profil_status" name="profil_status" type="hidden" value="" />
	<input id="profil_membership" name="profil_membership" type="hidden" value="" />
	<input id="profil_full_name" name="profil_membership" type="hidden" value="" />
	
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
	<label for="profil_date_created">Tanggal Mendaftar:</label>
	<span id="profil_date_created"> </span>
	</div>
	

	<input id="tombol-profil-submit" data-inline="true" data-role="submit" type="submit" value="save">
	
	</form>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>


<section id="page-pilih-tanggal" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Tanggal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Booking Jadwal</h3>
	<label for="pilih-tanggal">Klik salah satu tanggal pilihan :</label>
	<select id="pilih-tanggal" name="pilih-tanggal">
	</select>
	
	<a href="#page-pilih-aksi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	<a id="link-pilih-anggota" data-inline="true" data-role="button">&#62;&#62; selanjutnya</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-pilih-terapi" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Treatment Terapi</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Anda perlu tindakan terapi apa?</h3>
	<fieldset data-role="controlgroup">
	<legend >Centang 1 atau beberapa pilihan:</legend>
	<input type="checkbox" name="checkbox-umum" id="checkbox-umum">
	<label for="checkbox-umum">Tindakan Umum</label>
	<input type="checkbox" name="checkbox-bekam" id="checkbox-bekam">
	<label for="checkbox-bekam">Bekam Basah / Api / Basah</label>
	<input type="checkbox" name="checkbox-elektrik" id="checkbox-elektrik">
	<label for="checkbox-elektrik">Elektrik</label>
	<input type="checkbox" name="checkbox-lintah" id="checkbox-lintah">
	<label for="checkbox-lintah">Lintah</label>
	<input type="checkbox" name="checkbox-fashdu" id="checkbox-fashdu">
	<label for="checkbox-fashdu">Fashdu</label>
	<input type="checkbox" name="checkbox-pijat-fullbody" id="checkbox-pijat-fullbody">
	<label for="checkbox-pijat-fullbody">Pijat FullBody</label>
	<input type="checkbox" name="checkbox-ruqyah" id="checkbox-ruqyah">
	<label for="checkbox-ruqyah">Ruqyah</label>
	</fieldset>
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	
	<a id="link-pilihan-terapi" href="" data-inline="true" data-role="button">&#62;&#62; selanjutnya</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-pilih-anggota" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Peserta Therapy</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Siapa saja yang akan mendapat treatment terapi?</h3>
	<label>Klik salah satu pilihan ini :</label>
	
	<select id="pilih_anggota_siapa" name="pilih_anggota_siapa" >
		<option value="saya-sendiri">Saya Sendiri</option>
		<!-- this will be added by jquery -->
		<!-- <option value="saya-bersama-anggota">Saya bersama anggota</option>
		<option value="anggota-saja">Anggota saja tanpa Saya</option> -->
	</select>
	
	</fieldset>
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	
	<a id="link-pilihan-terapi" href="" data-inline="true" data-role="button">&#62;&#62; selanjutnya</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-riwayat" data-role="page">
<header data-role="header" data-position="fixed"><h1>Riwayat Booking</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Seluruh Jadwal Booking anda</h3>
	
	
	<div id="riwayat-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="warning-data" hidden>
	<img src="/images/error.png" />
	<p>Anda Belum memiliki data booking jadwal!</p>
	</div>
	
	<div id="riwayat-table-container">
	
	<p>Klik jika ingin mengganti 2 jam sebelum waktunya</p>
	
	<div class="ui-grid-c" id="data-table-head">
		<div class="ui-block-a"><b>CODE</b></div>
		<div class="ui-block-b"><b>JADWAL</b></div>
		<div class="ui-block-c"><b>STATUS</b></div>
		<div class="ui-block-d"><b> -- </b></div>
	</div>
	
	</div>
	
<a href="#page-pilih-aksi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>	


<section id="page-semua-anggota" data-role="page">
<header data-role="header" data-position="fixed"><h1>Semua Anggota</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Seluruh Anggota Family/Kerabat anda</h3>
	
	<div id="anggota-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="warning-anggota" hidden>
	<img src="/images/error.png" />
	<p>Anda Belum memiliki data anggota lain!</p>
	</div>
	
	<div id="anggota-table-container">
	
	<p>Klik jika ingin menghapus data anggota berikut :</p>
	
	<div class="ui-grid-c" id="anggota-table-head">
		<div class="ui-block-a"><b>TANGGAL DAFTAR</b></div>
		<div class="ui-block-b"><b>FULLNAME</b></div>
		<div class="ui-block-c"><b>HUBUNGAN</b></div>
		<div class="ui-block-d"><b> -- </b></div>
	</div>
	
	</div>
	
<a href="#page-pilih-aksi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>	

<section id="page-pilih-jam" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Jam Terapi</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Pilihan Jam Tersedia</h3>
	
	<div id="pilihan-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div id="warning-booking" hidden>
	<img src="/images/error.png" />
	<p>Jadwal Saat ini Belum tersedia!</p>
	</div>
	
	<div class="ui-grid-b" >
		<div class="ui-block-a"><b>JAM</b></div>
		<div class="ui-block-b"><b>STATUS</b></div>
		<div class="ui-block-c"><b> --- </b></div>
	</div>
	
	<div class="ui-grid-b" id="jam8">
		<div class="ui-block-a">08:00</div>
		<div class="ui-block-b"><span class="status">Tersedia</span></div>
		<div class="ui-block-c"><input class="tombol-booking" data-jam="08:00" type="button" value="booking" /></div>
	</div>
	
	<div class="ui-grid-b" id="jam10" >
		<div class="ui-block-a">10:00</div>
		<div class="ui-block-b"><span class="status">Tersedia</span></div>
		<div class="ui-block-c"><input class="tombol-booking" data-jam="10:00" type="button" value="booking" /></div>
	</div>
	
	<div class="ui-grid-b" id="jam13" >
		<div class="ui-block-a">13:00</div>
		<div class="ui-block-b"><span class="status">Tersedia</span></div>
		<div class="ui-block-c"><input class="tombol-booking" data-jam="13:00" type="button" value="booking" /></div>
	</div>
	
	<div class="ui-grid-b" id="jam16" >
		<div class="ui-block-a">16:00</div>
		<div class="ui-block-b"><span class="status">Tersedia</span></div>
		<div class="ui-block-c"><input class="tombol-booking" data-jam="16:00" type="button" value="booking" /></div>
	</div>
	
	<div class="ui-grid-b" id="jam20" >
		<div class="ui-block-a">20:00</div>
		<div class="ui-block-b"><span class="status">Tersedia</span></div>
		<div class="ui-block-c"><input class="tombol-booking" data-jam="20:00" type="button" value="booking" /></div>
	</div>
	
	<a href="#page-pilih-terapi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-peserta-baru" data-role="page">
<header data-role="header" data-position="fixed" ><h1>Pendaftaran Peserta Baru</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Formulir Peserta Baru</h3>
	<img src="/images/write.png"/>
	<p>Harap diisi dengan lengkap.</p>
	
	<form id="form-registrasi"  method="post" data-ajax="false" >
	
	<div data-role="fieldcontain" id="hubungan-peserta">
	<label for="peserta_baru_hubungan">Hubungan Dengan Anda:</label>
	<select name="peserta_baru_hubungan"  id="peserta_baru_hubungan" >
		<option value="1">Ayah saya</option>
		<option value="2">Ibu saya</option>
		<option value="3">Istri saya</option>
		<option value="4">Suami saya</option>
		<option value="5">Anak saya</option>
		<option value="6">Saudara Kandung saya</option>
		<option value="7">Saudara Angkat saya</option>
		<option value="8">Keluarga Jauh saya</option>
		<option value="9">Keluarga Dekat saya</option>
		<option value="10">Tetangga saya</option>
	</select>
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_nama">Nama Lengkap:</label>
	<input type="text" name="peserta_baru_nama" placeholder="nama lengkap sesuai KTP" id="peserta_baru_nama" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_nomorhp">No. Whatsapp:</label>
	<input type="text" name="peserta_baru_nomorhp" id="peserta_baru_nomorhp" placeholder="whatsapp yang aktif" />
	</div>
	
	<div data-role="fieldcontain" id="hubungan-tanpa-email">
	<label for="peserta_baru_tanpa_email">Tidak Punya Email:</label>
	<input name="peserta_baru_tanpa_email" id="peserta_baru_tanpa_email" type="checkbox" value="0" />
	</div>
	
	<div data-role="fieldcontain" id="peserta_baru_bagian_email">
	<label for="peserta_baru_email">Email:</label>
	<input type="text" name="peserta_baru_email" id="peserta_baru_email" placeholder="email yang masih aktif" />
	</div>
	
	
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_kelamin">Jenis Kelamin:</label>
	<select name="peserta_baru_kelamin" data-role="slider" id="peserta_baru_kelamin" >
		<option value="1">pria</option>
		<option value="0">wanita</option>
	</select>
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_nikah">Status Nikah:</label>
	<select name="peserta_baru_nikah" id="peserta_baru_nikah" >
		<option value="single">belum menikah</option>
		<option value="married">bersuami-istri</option>
		<option value="divorce">bercerai</option>
		<option value="almarhum">ditinggal wafat</option>
	</select>
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_ttl">Tempat, Tanggal Lahir Lengkap:</label>
	<input type="text" name="peserta_baru_ttl" placeholder="format: Jakarta, 12 Maret 1988" id="peserta_baru_ttl" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_pekerjaan">Pekerjaan saat ini:</label>
	<input type="text" name="peserta_baru_pekerjaan" id="peserta_baru_pekerjaan" placeholder="pekerjaan sehari-hari" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_alamat">Alamat Tempat Tinggal:</label>
	<input type="text" name="peserta_baru_alamat" id="peserta_baru_alamat" placeholder="Jl.tempat tinggal no rt rw, kota, provinsi" />
	</div>
	
	
	<input type="button" id="tombol-kesehatan-umum" value="isi data kesehatan umum" />
	
	<div id="data-kesehatan-umum">
	
	<h4>Data Kesehatan Umum</h4>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_keluhan">Keluhan saat ini:</label>
	<input type="text" name="kesehatan_umum_keluhan" id="kesehatan_umum_keluhan" placeholder="tuliskan rincian keluhan yang dialami" />
	</div>
	
	<span>1. Apakah anda merokok?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_merokok">Jawaban 1:</label>
	<select name="kesehatan_umum_merokok" data-role="slider" id="kesehatan_umum_merokok" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>2. Apakah dalam 3 tahun terakhir pernah rawat inap di rumah sakit</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahinap">Jawaban 2:</label>
	<select name="kesehatan_umum_pernahinap" data-role="slider" id="kesehatan_umum_pernahinap" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>3. Apakah menggunakan obat bius / narkotik?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahbius">Jawaban 3:</label>
	<select name="kesehatan_umum_pernahbius" data-role="slider" id="kesehatan_umum_pernahbius" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>4. Apakah anda pernah divonis TBC?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahdivonistbc">Jawaban 4:</label>
	<select name="kesehatan_umum_pernahdivonistbc" data-role="slider" id="kesehatan_umum_pernahdivonistbc" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>5. Apakah anda pernah divonis Kanker?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahdivoniskanker">Jawaban 5:</label>
	<select name="kesehatan_umum_pernahdivoniskanker" data-role="slider" id="kesehatan_umum_pernahdivoniskanker" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>6. Apakah anda pernah divonis Serangan Jantung?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahdivonisjantung">Jawaban 6:</label>
	<select name="kesehatan_umum_pernahdivonisjantung" data-role="slider" id="kesehatan_umum_pernahdivonisjantung" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>7. Apakah anda pernah divonis Stroke?</span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahdivonisstroke">Jawaban 7:</label>
	<select name="kesehatan_umum_pernahdivonisstroke" data-role="slider" id="kesehatan_umum_pernahdivonisstroke" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	<span>8. Apakah anda kemari dengan anjuran dokter / terapis tertentu? </span>
	<div data-role="fieldcontain">
	<label for="kesehatan_umum_pernahanjuran">Jawaban 8:</label>
	<select name="kesehatan_umum_pernahanjuran" data-role="slider" id="kesehatan_umum_pernahanjuran" >
		<option value="1">ya</option>
		<option value="0">tidak</option>
	</select>
	</div>
	
	
	</div>

	<input type="button" id="tombol-kesehatan-khusus" value="isi data kesehatan khusus" />
	
	<div id="data-kesehatan-khusus">
	
		<h4>Data Kesehatan Khusus</h4>
		<span>1.Apakah anda pernah melakukan ritual adat syirik?</span>
		<div data-role="fieldcontain">
		<label for="kesehatan_khusus_pernahritual">Jawaban 1:</label>
		<select name="kesehatan_khusus_pernahritual" data-role="slider" id="kesehatan_khusus_pernahritual" >
			<option value="1">ya</option>
			<option value="0">tidak</option>
		</select>
		</div>
		
		<span>2.Apakah anda atau keluarga pernah ikut perguruan tenaga dalam?</span>
		<div data-role="fieldcontain">
		<label for="kesehatan_khusus_pernahtd">Jawaban 2:</label>
		<select name="kesehatan_khusus_pernahtd" data-role="slider" id="kesehatan_khusus_pernahtd" >
			<option value="1">ya</option>
			<option value="0">tidak</option>
		</select>
		</div>
		
		<span>3.Apakah anda atau keluarga sering mimpi buruk berturut-turut?</span>
		<div data-role="fieldcontain">
		<label for="kesehatan_khusus_pernahmimpi">Jawaban 3:</label>
		<select name="kesehatan_khusus_pernahmimpi" data-role="slider" id="kesehatan_khusus_pernahmimpi" >
			<option value="1">ya</option>
			<option value="0">tidak</option>
		</select>
		</div>
		
		<span>4.Apakah anda atau keluarga pernah kunjungan ke paranormal (dukun)?</span>
		<div data-role="fieldcontain">
		<label for="kesehatan_khusus_pernahkunjungan">Jawaban 4:</label>
		<select name="kesehatan_khusus_pernahkunjungan" data-role="slider" id="kesehatan_khusus_pernahkunjungan" >
			<option value="1">ya</option>
			<option value="0">tidak</option>
		</select>
		</div>
		
		<span>5.Apakah anda atau keluarga pernah melihat penampakan ghaib (wujud/suara)?</span>
		<div data-role="fieldcontain">
		<label for="kesehatan_khusus_pernahghaib">Jawaban 5:</label>
		<select name="kesehatan_khusus_pernahghaib" data-role="slider" id="kesehatan_khusus_pernahghaib" >
			<option value="1">ya</option>
			<option value="0">tidak</option>
		</select>
		</div>
	
		<input id="tombol-pendaftaran-baru-submit" data-inline="true" data-role="submit" type="submit" value="Save">
	
	</div>

	
	</form>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-reset-failed" data-role="page">
<header data-role="header" data-position="fixed"><h1>Reset Password Gagal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Data Tersebut tidak kami temukan!</h3>
	<img src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, <strong>email itu tidak pernah dipakai disini!</strong> </p>
	<p>Saat ini silahkan coba membuat akun baru!</p>
	<a href="#page1" data-inline="true" data-role="button">Bismillah</a>
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
	<a href="#page-peserta-lama-login" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-login-pending" data-role="page">
<header data-role="header" data-position="fixed"><h1>Status Login</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Akses Terbatas</h3>
	<img src="/images/error.png"/>
	<p>Klik link aktifasi yang didapat pada email saat mendaftar, lalu coba login kembali.</p>
	<a href="#page-peserta-lama-login" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-login-disabled" data-role="page">
<header data-role="header" data-position="fixed"><h1>Status Login</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Akses Tidak Berhasil</h3>
	<img src="/images/error.png"/>
	<p>Hubungi pihak admin untuk mengaktifkan akun anda kembali normal.</p>
	<a id="link-kontak-admin" href="" data-inline="true" data-role="button">Kontak Whatsapp</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-forgot-password" data-role="page">
<header data-role="header" data-position="fixed"><h1>Reset Password</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Lupa kata kunci (password)</h3>
	<img src="/images/ask.png"/>
	<p>Input email saat pertama kali mendaftar untuk me-reset password:</p>
	
	<form id="form-reset" action="" method="post" data-ajax="false" >
	
	<div data-role="fieldcontain">
	<label for="reset_email">Email</label>
	<input type="text" name="reset_email" placeholder="ketik disini" id="reset_email" />
	</div>
	
	<a href="#page1" data-inline="true" data-role="button">kembali &#60;&#60;</a>
	<input id="tombol-reset-submit" data-inline="true" data-role="submit" type="submit" value="reset">
	
	</form>
	
	
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-error-server" data-role="page">
<header data-role="header" data-position="fixed"><h1>Error</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Server Error</h3>
	<img src="/images/error.png"/>
	<p>Innalillahi wa innailaihi roji'un, server sedang sibuk! </p>
	<p>Cobalah <strong> lagi kemari dalam 30 menit setelah ini</strong> untuk dapat melanjutkan akses booking jadwal kembali!</p>
	<a href="#page0" data-inline="true" data-role="button">Bismillah</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-anggota-delete-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Data Anggota</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Berhasil Dihapus!</h3>
	<img src="/images/sad.png"/>
	<p>Nama Anggota : <strong id="anggota-fullname">xxxx</strong></p>
	
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-anggota-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pendaftaran Anggota</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Berhasil!</h3>
	<img src="/images/success.png"/>
	<p>Walhamdulillah data <strong id="success-anggota-nama">xxxx</strong> dari <strong id="success-anggota-hubungan" > xxxx</strong> sukses disimpan!</p>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-booking-cancel-success" data-role="page">
<header data-role="header" data-position="fixed"><h1>Booking Jadwal Terupdate</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Berhasil Dibatalkan</h3>
	<img src="/images/sad.png"/>
	<p>Kode Booking : <strong id="booking-cancel-code">xxxx</strong> dengan Jadwal anda : <strong id="booking-cancel-date" > xxxx</strong> </p>
	<p>Sayang sekali, jadwal booking <b>sudah dibatalkan!</b> </p>
	
	
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

<section id="page-profil-updated" data-role="page">
<header data-role="header" data-position="fixed"><h1>Profil Updated</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Data Terupdate!</h3>
	<img src="/images/success.png"/>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-reset-continue" data-role="page">
<header data-role="header" data-position="fixed"><h1>Reset Password</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Ikuti Langkah Berikutnya</h3>
	<img src="/images/email.png"/>
	<p>Walhamdulillah, selangkah lagi untuk mereset password anda </p>
	<p>Check <strong>inbox email</strong> dan klik email yang kami berikan segera!</p>
	<a href="https://mail.google.com" data-role="button">&#62;&#62; selanjutnya</a>
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
