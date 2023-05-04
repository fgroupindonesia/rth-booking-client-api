<hr>
<h1>Barusan Pasien Baru Terdaftar!</h1>
<hr>
<br/>
Berikut data pasien yang mendaftar pada: <?= $tanggal ?> <br/>
<br/> 
Nama Lengkap	: <?= $fullname ?> <br/>
Jenis Kelamin	: <?= $gender ?> <br/>
Status 			: <?= $married ?> <br/>
Kontak HP		: <?= $nohp ?> <br/>
Alamat			: <?= $address ?> <br/>
<br/>
<br/>
Memiliki Keluhan : <br/>
- <?= $keluhan ?> <br/>
 <br/>
Dengan Data Kesehatan Umum : <br/>
- Merokok 								: <?= $stat_merokok ?> <br/>
- Pernah Rawat Inap 3 thn terakhir 		: <?= $stat_inap ?> <br/>
- Pernah menggunakan Bius / Narkotik 	: <?= $stat_bius ?> <br/>
- Pernah divonis TBC 					: <?= $stat_tbc ?> <br/>
- Pernah divonis Kanker 				: <?= $stat_kanker ?> <br/>
- Pernah divonis Serangan Jantung 		: <?= $stat_jantung ?> <br/>
- Pernah divonis Stroke					: <?= $stat_stroke ?> <br/>
- Dapat anjuran dokter / terapis 		: <?= $stat_anjuran ?> <br/>
<br/>
<br/>
Dan Data Kesehatan Khusus :
- Pernah melakukan ritual syirik		: <?= $stat_ritual ?> <br/>
- Pernah mengikuti tenaga dalam			: <?= $stat_td ?> <br/>
- Pernah mimpi buruk berturut-turut		: <?= $stat_mimpi ?> <br/>
- Pernah kunjungan ke paranormal		: <?= $stat_paranormal ?> <br/>
- Pernah penampakan ghaib				: <?= $stat_ghaib ?> <br/>
<br/>
<br/>
Konfirmasi segera untuk memudahkan komunikasi & Treatment selanjutnya. <br/>
<br/>
Automatic Support System <br/>
RTH - Rumah Terapi Herbal. <br/>

<?php
	$this->load->view('template/_footer');
?>