-----------------------------------------------------------
Barusan Pasien Baru Terdaftar!
-----------------------------------------------------------

Berikut data pasien yang mendaftar pada: <?= $tanggal ?>

Nama Lengkap	: <?= $fullname ?> 
Jenis Kelamin	: <?= $gender ?> 
Status 			: <?= $married ?>
Kontak HP		: <?= $nohp ?> 
Alamat			: <?= $address ?> 


Memiliki Keluhan :
- <?= $keluhan ?>

Dengan Data Kesehatan Umum :
- Merokok 								: <?= $stat_merokok ?> 
- Pernah Rawat Inap 3 thn terakhir 		: <?= $stat_inap ?> 
- Pernah menggunakan Bius / Narkotik 	: <?= $stat_bius ?> 
- Pernah divonis TBC 					: <?= $stat_tbc ?> 
- Pernah divonis Kanker 				: <?= $stat_kanker ?> 
- Pernah divonis Serangan Jantung 		: <?= $stat_jantung ?> 
- Pernah divonis Stroke					: <?= $stat_stroke ?> 
- Dapat anjuran dokter / terapis 		: <?= $stat_anjuran ?> 


Dan Data Kesehatan Khusus :
- Pernah melakukan ritual syirik		: <?= $stat_ritual ?> 
- Pernah mengikuti tenaga dalam			: <?= $stat_td ?> 
- Pernah mimpi buruk berturut-turut		: <?= $stat_mimpi ?> 
- Pernah kunjungan ke paranormal		: <?= $stat_paranormal ?> 
- Pernah penampakan ghaib				: <?= $stat_ghaib ?> 


Konfirmasi segera untuk memudahkan komunikasi & Treatment selanjutnya.

Automatic Support System
RTH - Rumah Terapi Herbal.

<?php
	$this->load->view('template/_footer');
?>