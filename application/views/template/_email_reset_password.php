<hr> 
<h1>Reset Password Akun</h1>
<hr>
<br/>
Assalamu'alaikum, <br/>
<br/>
Barusan anda melakukan request Reset Password pada <?= $date; ?> untuk akun milik: <br/>
<br/>
Username : <?= $username; ?> <br/>
<br/>
<a href="https://rumahterapiherbal.web.id/p/reset-akun.html?token=<?=$token;?>">Klik disini</a> untuk melakukan reset password segera!<br/>
<br/>
Setelah memberikan reset password baru dari link diatas, kamu dapat kembali menggunakan web booking Jadwal RTH seperti biasa dengan mudah! <br/>
<br/>
Mohon lakukan reset password sebelum 12 jam berlalu! <br/>
<br/>
Terima kasih, <br/>
Wa barakallahu fiikum. <br/> 
<br/>
Automatic Support System <br/>
RTH - Rumah Terapi Herbal. <br/>

<?php
	$this->load->view('template/_footer');
?>