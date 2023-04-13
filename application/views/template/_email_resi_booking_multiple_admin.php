-----------------------------------------------------------
Booking Jadwal Order
-----------------------------------------------------------

Barusan System menerima Booking Jadwal Order
dengan detail peserta & Anggotanya :

Kode Booking	: <?=$kodebooking;?> 
Nama Pasien 	: <?=$fullname;?>
Beserta Anggota	: <?=$anggota;?>
Booking Jadwal 	: <?=$jadwalbooking;?> 
Tindak Terapi 	:  
<?=$tindakterapi;?> 

Segera diproses untuk ditindaklanjuti atau konfirmasi lainnya demi kemudahan secara menyeluruh.

Automatic Support System
RTH - Rumah Terapi Herbal.

<?php
	$this->load->view('template/_footer');
?>