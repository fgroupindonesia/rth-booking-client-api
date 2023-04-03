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
		<li><a href="#page-peserta-baru">Untuk Peserta Baru</a></li>
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
	
	</form>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-pilih-aksi" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Tanggal</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Selamat Datang!</h3><span id="sembunyi-username" hidden>peserta</span>
	<p>Pilih Menu dari sini ya <b><span id="txt-fullname">peserta</span></b>! </p>
	
	<a id="link-page-riwayat" href="" data-inline="true" data-role="button" data-icon="riwayat" >Semua Riwayat</a>
	<a href="#page-pilih-tanggal" data-inline="true" data-role="button" data-icon="booking" >Mau Booking</a>
	
	
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
	<a href="#page-pilih-terapi" data-inline="true" data-role="button">&#62;&#62; selanjutnya</a>
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
	<a id="link-pilihan-terapi" href="#page-pilih-jam" data-inline="true" data-role="button">&#62;&#62; selanjutnya</a>
	
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>

<section id="page-riwayat" data-role="page">
<header data-role="header" data-position="fixed"><h1>Riwayat Booking</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Seluruh Jadwal Booking anda</h3>
	<p>Klik jika ingin mengganti 2 jam sebelum waktunya</p>
	
	<div id="riwayat-loading"><img src="/images/loading.gif" /><span>Loading...
	</span></div>
	
	<div class="ui-grid-c" id="data-table-head">
		<div class="ui-block-a"><b>CODE</b></div>
		<div class="ui-block-b"><b>JADWAL</b></div>
		<div class="ui-block-c"><b>STATUS</b></div>
		<div class="ui-block-d"><b> -- </b></div>
	</div>
	
<a href="#page-pilih-aksi" data-inline="true" data-role="button">kembali &#60;&#60;</a>
</div>
<footer data-role="footer" data-position="fixed"><h1>RTH - Rumah Terapi Herbal </h1></footer>
</section>	

<section id="page-pilih-jam" data-role="page">
<header data-role="header" data-position="fixed"><h1>Pilihan Jam Terapi</h1></header>
<div id="container" class="content" data-role="content" >
	<h3>Pilihan Jam Tersedia</h3>
	<p>Klik salah satu saja...</p>
	<div class="ui-grid-b" id="jam8">
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
	
	<form id="form-registrasi" action="" method="post" data-ajax="false" >
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_nama">Nama Lengkap:</label>
	<input type="text" name="peserta_baru_nama" placeholder="nama lengkap sesuai KTP" id="peserta_baru_nama" />
	</div>
	
	<div data-role="fieldcontain">
	<label for="peserta_baru_nomorhp">No. Whatsapp:</label>
	<input type="text" name="peserta_baru_nomorhp" id="peserta_baru_nomorhp" placeholder="whatsapp yang aktif" />
	</div>
	
	<div data-role="fieldcontain">
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
