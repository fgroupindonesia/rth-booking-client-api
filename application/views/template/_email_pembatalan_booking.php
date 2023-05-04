<hr>
<h1>Pembatalan Booking Jadwal</h1>
<hr>
<br/>
Sayang sekali, <br/>
Jadwal Booking Anda telah dibatalkan: <br/>
<br/>
Kode Booking	: <?=$kodebooking;?> <br/>
Nama Pasien 	: <?=$fullname;?> <br/>
Booking Jadwal 	: <?=$jadwalbooking;?> <br/>
Tindak Terapi 	: <br/>
<?=$tindakterapi;?> <br/>
<br/>
Status			: DIBATALKAN <br/>
<br/>
Semoga anda bisa melakukan booking jadwal terapi berikutnya dengan penyesuaian yang telah diberikan lebih baik lagi. <br/>
<br/>
Terima kasih, <br/> 
Wa barakallahu fiikum. <br/>
<br/>
Automatic Support System <br/>
RTH - Rumah Terapi Herbal. <br/>

<?php
	$this->load->view('template/_footer');
?>