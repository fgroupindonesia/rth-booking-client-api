var username_sembunyi = "";
var fullname_sembunyi = "";
var jadwal_sembunyi = "";
var gender_sembunyi = "";
var month_year_sembunyi = "";
var hubungan_sembunyi = "";
var modePendaftaran = "";
var kiriman = "";
var pakaiEmail = true;
var anggotaNa = false;
var jumlahAnggota = 0;


$(document).ready(function(){

	createSelectOption2Weeks();
	toggleAllTindakan();
	
	sembunyi('data-kesehatan-umum');
	sembunyi('data-kesehatan-khusus');
	
	clickEventFormKesehatan();
	clickEventAwal();
	clickEventAllAnggota();
	clickEventAllBooking();
	clickEventCancelBooking();
	clickEventDeleteAnggota();
	clickEventPilihJadwalTerapi();
	clickEventPilihTanggal();
	clickEventBukaProfil();
	clickEventDaftarkanAnggota();
	clickEventDaftarkanTunggal();
	clickEventTanpaEmail();
	
	
	setTimeout(nextPage1, 3000);
	
	// false because not for anggota
	// anggota doesnt need email verification
	formRegistrationValidation(false);
	formLoginValidation();
	formResetPassValidation();
	formProfilValidation();
	
	aktifkanLinkKontakAdmin();
	
	aktifkanPilihanSiapaTerapi();
	
	pilihJam();
	
});

function clearFormRegistrasi(){
	
	$("#form-registrasi").each(function(){this.reset();});
	
}

function clearFormProfil(){
	
	$("#form-profil").each(function(){this.reset();});
	
}


function clearFormLogin(){
	
	$("#form-login").each(function(){this.reset();});
	
}

function aktifkanPilihanSiapaTerapi(){
	
	
	$("#link-pilih-anggota").click(function() {
	
		var namaUser = $('#sembunyi-username').text();
		
		kiriman = {};
		kiriman.username_incharge = namaUser;
		
		// this will eventually check how many members anggota
		// to show the select (option)
		grabDataJumlahAnggotaServer();
	
	});
}

function aktifkanLinkKontakAdmin(){
	
	$("#link-kontak-admin").click(function() {
	
		window.parent.location.href = goToWhatsappKontak();
	
	});
	
	
}



function clickEventPilihTanggal(){
	
	// default na
	var formatDiinginkan = "MMMM YYYY";
	var formatDipakePC = "YYYY-MM-DD";
	
	month_year_sembunyi = moment().format(formatDiinginkan).toLowerCase();
	
	
	$('#pilih-tanggal').change(function() {
		// this date should be reformatted 
		var tgl = $('#pilih-tanggal option:selected').val();
		//alert(tgl);
		var terima = moment(tgl, formatDipakePC).format(formatDiinginkan);
		month_year_sembunyi = terima.toLowerCase();
		//alert('dipilih skrg ' + terima);
	 });
	
	
}

function apakahMuncul (namaID){
	var nama = "#" + namaID;
	return $(nama).is(":hidden");
}

function clickEventTanpaEmail(){
	
	 $(document).on("change", "#peserta_baru_tanpa_email", function () {
     
	 //alert('a');
	
			if(pakaiEmail){
				sembunyi('peserta_baru_bagian_email');
				pakaiEmail = false;
			}else{
				pakaiEmail = true;
				tampilin('peserta_baru_bagian_email');
			}
		
		
		//alert('b');
	});
	
	
}

function clickEventPilihJadwalTerapi(){
	
	
	$("#link-pilihan-terapi").click(function() {
	
		refreshDataPilihanBooking();
		
		
		$.mobile.changePage("#page-pilih-jam");
		
		
	});
	
	
}


function refreshDataAnggotaTable(){
	
	// clear the div
	$('#anggota-table-head').nextAll('div').remove();
	
	tampilin('anggota-loading');
	tampilin('anggota-table-container');
	sembunyi('warning-anggota');
		
	// grab after 3 seconds
	setTimeout(	grabDataAnggotaServer, 3000);

	
}

function clickEventAllAnggota(){
	
	$("#link-page-all-anggota").click(function() {
	
		kiriman = {
			username_incharge : username_sembunyi
		};
	
		refreshDataAnggotaTable();
		
		$.mobile.changePage("#page-semua-anggota");
		
		
	});
	
	
}

function clickEventAllBooking(){
	
	
	$("#link-page-riwayat").click(function() {
	
		refreshDataTable();
		
		tampilin('riwayat-loading');
		tampilin('riwayat-table-container');
		sembunyi('warning-data');
		
		$.mobile.changePage("#page-riwayat");
		
		kiriman = {
			username : username_sembunyi
		};
		
		//console.log('kirim dulu ' + JSON.stringify(kiriman));
		
		
	});
	
	
}

function clickEventBukaProfil(){
	//alert('lkii');
	sembunyi('form-profil');
	
	$("#link-buka-profil").click(function() {
	
		refreshDataProfil();
		
		$.mobile.changePage("#page-profil-anda");
		
		
	});
	
	
}

function aktifkanModeAnggota(){
	// munculkan hubungan keluarga
	// dan checkbox matikan email
	tampilin('hubungan-peserta');
	tampilin('hubungan-tanpa-email');
	
	modePendaftaran = "anggota";
	
}

function aktifkanModeTunggal(){
	
	sembunyi('hubungan-peserta');
	sembunyi('hubungan-tanpa-email');
	
	modePendaftaran = "tunggal";
	
}


function clickEventDaftarkanAnggota(){
	//alert('lkii');
	
	$("#link-peserta-baru-tunggal").click(function() {
	
		aktifkanModeTunggal();
		$.mobile.changePage("#page-peserta-baru");
		
		
	});
	
	
}

function clickEventDaftarkanTunggal(){
	//alert('lkii');
	
	$("#link-daftar-anggota").click(function() {
	
		// validationnya harus true untuk anggota
		formRegistrationValidation(true);
		aktifkanModeAnggota();
		
		$.mobile.changePage("#page-peserta-baru");
		
		
	});
	
	
}

function refreshDataProfil(){
	
	tampilin('profil-loading');
	
	kiriman = {
			username : username_sembunyi
	};
	
	
	//alert('akan kirim '  + JSON.stringify(kiriman));
	
	// grab data after 3 seconds
	setTimeout( grabDataProfilServer, 3000);
	
}

function refreshDataPilihanBooking(){
	
	// hide semua tombol, warning-booking
	// lalu munculkan loading
	tampilin('pilihan-loading');
		sembunyiParentDiv('.tombol-booking');
		sembunyi('warning-booking');
	
	// the data tobe passed into server	
	kiriman = {
		month_year : month_year_sembunyi,
		gender_therapist : gender_sembunyi		
	};
	
	//alert('akan kirim '  + JSON.stringify(kiriman));
	
	// grab data after 3 seconds
	setTimeout( grabDataSchedulesServer, 3000);
	
}

function refreshDataTable(){
	
	// clear the div
	$('#data-table-head').nextAll('div').remove();
	
	// show the loading
	tampilin('riwayat-loading');
		
	// grab after 3 seconds
	setTimeout(	grabDataServer, 3000);

	
}

function aktifinTombolJam(dataJSON){
	
	
	
}

function opsiTerapiBersamaAnggota(tampilkan){
	
	$('#pilih_anggota_siapa').selectmenu();
	
	if(!tampilkan){
		$("#pilih_anggota_siapa option[value='saya-bersama-anggota']").remove();
		$("#pilih_anggota_siapa option[value='anggota-saja']").remove();
	}else{
		
		// will be added only if the select option doesnt have earlier
		var isianOpsi = $('#pilih_anggota_siapa option').length;
		
		if(isianOpsi==1){
			var btn1 = "<option value='anggota-saja'>Anggota saja tanpa Saya</option";
			var btn2 = "<option value='saya-bersama-anggota'>Saya bersama anggota</option";
			$('#pilih_anggota_siapa').append(btn1); 
			$('#pilih_anggota_siapa').append(btn2); 
		}
	}
	
	$('#pilih_anggota_siapa').selectmenu('refresh', true);
	
}

function grabDataJumlahAnggotaServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/family/all',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						// we set the number of family
						var n = JSON.stringify(result);
						var dataJSON = JSON.parse(n);
						jumlahAnggota = dataJSON.multi_data.length;
						
						if(jumlahAnggota>0){
							// sediakan select option
							opsiTerapiBersamaAnggota(true);
						}else {
							// lenyapkan select option
							opsiTerapiBersamaAnggota(false);
						}
						
					}else{
						// lenyapkan select option
						opsiTerapiBersamaAnggota(false);
					}
					
					$.mobile.changePage("#page-pilih-anggota");
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function grabDataProfilServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/profile',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataProfil(result);
						tampilin('form-profil');
						
					}
					
					sembunyi('profil-loading');
					
					//console.log(result);
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function grabDataSchedulesServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/schedule/all',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						aktifinTombolJam(result);
						
					}else{
						sembunyiParentDiv('.tombol-booking');
						tampilin('warning-booking');
					}
					
						sembunyi('pilihan-loading');
					
					
					console.log(result);
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function grabDataServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/booking/all',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataToTable(result);
						
					}else{
						sembunyi('riwayat-table-container');
						tampilin('warning-data');
					}
					
						sembunyi('riwayat-loading');
					
					
					//console.log(result);
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}


function grabDataAnggotaServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/family/all',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataAnggotaTable(result);
						
					}else{
						sembunyi('anggota-table-container');
						tampilin('warning-anggota');
					}
					
						sembunyi('anggota-loading');
					
					
					//console.log(result);
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function visitWhatsapCancel(){
	window.parent.location.href = goToWhatsappCancel(kiriman);
}

function deleteDataAnggotaServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/family/delete',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						$.mobile.changePage("#page-anggota-delete-success");
						
						$('#anggota-fullname').text(kiriman.full_name);
						
						setTimeout(backToMenuAksi, 3000);
						
					}else{
						// if error
					console.log('error for delete anggota!\n' + result);	
					
					}
					
					
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function updateDataServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/booking/edit',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						$.mobile.changePage("#page-booking-cancel-success");
						
						$('#booking-cancel-code').text(kiriman.code);
						$('#booking-cancel-date').text(kiriman.human_date);
						
						// open whatsapp dalam 5 detik untuk konfirmasi
						// dengan text yg sudah ada di object 'kiriman'
							setTimeout(visitWhatsapCancel, 5000);
						
					}else{
						// if error
					console.log('error for updating booking status!\n' + result);	
					
					}
					
					
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function generateRandomString(length){
	 var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    var counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}

function pilihJam(){
	
	
	$(".tombol-booking").click(function() {
	
		var jam =	$(this).attr('data-jam');
		collectBookingOrder(jam);
		
	});
	
}


function collectBookingOrder(jamMasuk){
	var codeNa =	generateRandomString(4) + "-" + generateRandomString(3);
	
	var usernameNa = username_sembunyi;
	var fullNa = fullname_sembunyi;
	var schedDate = $('#pilih-tanggal').val();
	
	
	jadwal_sembunyi = $('#pilih-tanggal option:selected').text();
	jadwal_sembunyi += " " + jamMasuk;
	
	schedDate += " " + jamMasuk;
	
		// overall there are 4 status:
		// a. pending
		// b. completed
		// c. cancel
		// d. changed
		
		// the values of treatment are true / false
		// and then converted to number 1 or 0
		var objTreatment = {};

	objTreatment.tindakan_umum = Number($('#checkbox-umum').prop('checked'));
	objTreatment.bekam = Number($('#checkbox-bekam').prop('checked'));
	objTreatment.ruqyah = Number($('#checkbox-ruqyah').prop('checked'));
	objTreatment.elektrik = Number($('#checkbox-elektrik').prop('checked'));
	objTreatment.fashdu = Number($('#checkbox-fashdu').prop('checked'));
	objTreatment.lintah = Number($('#checkbox-lintah').prop('checked'));
	objTreatment.pijat = Number($('#checkbox-pijat-fullbody').prop('checked'));
	
	//var dataTreatement = JSON.stringify(objTreatment);
	
	
	
	//alert(dataTreatement);
	// lets create the post data
	var postData = {
		username : usernameNa,
		code : codeNa,
		fullname : fullNa,
		treatment: objTreatment,
		schedule_date : schedDate,
		human_date : jadwal_sembunyi
	};
	
	console.log(postData);
	
	postDataBookingRequest(postData, codeNa, jadwal_sembunyi );
	
}

function extractDataProfil(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n); // Try to parse the response as JSON
	
	var isiNa = data.multi_data;
	
	$('#profil_username').val(isiNa.username);
	$('#profil_pass').val(isiNa.pass);
	$('#profil_email').val(isiNa.email);
	$('#profil_home_address').val(isiNa.home_address);
	$('#profil_contact').val(isiNa.contact);
	$('#profil_full_name').val(isiNa.full_name);
	$('#profil_fullname_span').text(isiNa.full_name);
	
	$('#profil_date_created').text(konversiAsHuman(isiNa.created_date));
	
	// this is hidden
	$('#profil_id').val(isiNa.id);
	$('#profil_membership').val(isiNa.membership);
	$('#profil_status').val(isiNa.status);
	
	
	var opsi = 'value=' + isiNa.gender;
	$('#profil_gender option['+opsi+']').prop('selected', true);
	$('#profil_gender').selectmenu('refresh', true);
	
	
	var imageNa = "";
	// change the img of this elemen
	if(isiNa.gender == 0){
			imageNa = "female.png";
	}else{
			imageNa = "male.png";
	}
	
	$('#image-profil').attr('src', '/images/'+imageNa);
	
}

function extractDataToTable(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n); // Try to parse the response as JSON
	
	var isiNa = data.multi_data;
	var p = 0;
	for(p = 0; p < isiNa.length; p++){
		//console.log(isiNa[p]);
		/*
		CREATING NEW DIV BELOW THIS ONE
		<div class="ui-grid-c" id="data-table-head">
			<div class="ui-block-a"><b>CODE</b></div>
			<div class="ui-block-b"><b>JADWAL</b></div>
			<div class="ui-block-c"><b>STATUS</b></div>
			<div class="ui-block-d"><b> -- </b></div>
		</div>
		
		*/
		var encloser1a = "<div class='ui-grid-c data-table-cell'>";
		var encloser1b = "</div>";
		
		var code = "<div class='ui-block-a treatment-code'>" + isiNa[p].code + "</div>";
		var sdate = "<div class='ui-block-b treatment-schedule-date' hidden>" + isiNa[p].schedule_date + "</div>";
		
		var tglManusiawi = konversiAsHuman(isiNa[p].schedule_date);
		
		var hdate = "<div class='ui-block-b'>" + tglManusiawi  + "</div>";
		
		var stat = "<div class='ui-block-c'>" + isiNa[p].status + "</div>";
		
		if(isiNa[p].status == 'completed'){
			var logoOK = "<img src='/images/success_28.png' />";
			stat = "<div class='ui-block-c'>" + logoOK + "</div>";
		}
		
		var btn = "<input type='button' value='Batal' class='treatment-cancel' data-inline='true' />";
		
		if(isiNa[p].status != "pending"){
			btn = "";
		}
		
		var cancel = "<div class='ui-block-d'>" + btn + "</div>";
		
		var combined = encloser1a + code + sdate + hdate + stat  + cancel + encloser1b;
		
		$(combined).insertAfter("#data-table-head");
		
	}
	
}

function konversiAsHubungan(nomerHub){
	
	/* as defined in UI
	
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
	
	*/
	
	var textHasil  = '';
	
	if(nomerHub == 1){
		textHasil = "Ayah saya";
	}else if(nomerHub == 2){
		textHasil = "Ibu saya";
	}else if(nomerHub == 3){
		textHasil = "Istri saya";
	}else if(nomerHub == 4){
		textHasil = "Suami saya";
	}else if(nomerHub == 5){
		textHasil = "Anak saya";
	}else if(nomerHub == 6){
		textHasil = "Saudara Kandung saya";
	}else if(nomerHub == 7){
		textHasil = "Saudara Angkat saya";
	}else if(nomerHub == 8){
		textHasil = "Keluarga Jauh saya";
	}else if(nomerHub == 9){
		textHasil = "Keluarga Dekat saya";
	}else if(nomerHub == 10){
		textHasil = "Tetangga saya";
	} 
	
	return textHasil;
	
	
}

function extractDataAnggotaTable(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n); // Try to parse the response as JSON
	
	var isiNa = data.multi_data;
	var p = 0;
	for(p = 0; p < isiNa.length; p++){
		//console.log(isiNa[p]);
		/*
		CREATING NEW DIV BELOW THIS ONE
		<div class="ui-grid-c" id="anggota-table-head">
			<div class="ui-block-a"><b>TANGGAL DAFTAR</b></div>
			<div class="ui-block-b"><b>FULLNAME</b></div>
			<div class="ui-block-c"><b>HUBUNGAN</b></div>
			<div class="ui-block-d"><b> -- </b></div>
		</div>
		
		*/
		var encloser1a = "<div class='ui-grid-c data-table-cell'>";
		var encloser1b = "</div>";
		
		var tglManusiawi = konversiAsHuman(isiNa[p].created_date);
		
		var cdate = "<div class='ui-block-a anggota-created-date'>" + tglManusiawi + "</div>";
		
		var fname = "<div class='ui-block-b anggota-fullname'>" + isiNa[p].full_name + "</div>";
		
		var hubunganNa = konversiAsHubungan(isiNa[p].rel_connection);
		
		var hub = "<div class='ui-block-c anggota-hubungan'>" + hubunganNa + "</div>";
		
		var nomerID = isiNa[p].id;
		
		var btn = "<input type='button' anggota-id='"+ nomerID +"' value='Delete' class='anggota-delete' data-inline='true' />";
		
		var hapus = "<div class='ui-block-d'>" + btn + "</div>";
		
		var combined = encloser1a + cdate + fname + hub + hapus + encloser1b;
		
		$(combined).insertAfter("#anggota-table-head");
		
	}
	
}


function extractTreatment(dataObject){
	
	var nLine = "ENTER";
	var pesanManusiawi = "";
	
	var tdk_umum = dataObject.treatment.tindakan_umum;
	var bekam = dataObject.treatment.bekam;
	var ruqyah = dataObject.treatment.ruqyah;
	var elektrik = dataObject.treatment.elektrik;
	var fashdu = dataObject.treatment.fashdu;
	var lintah = dataObject.treatment.lintah;
	var pijat = dataObject.treatment.pijat;
	
	
	if(tdk_umum == 1){
		pesanManusiawi += "- Tindakan Umum" + nLine;
	}
	
	if(pijat == 1){
		pesanManusiawi += "- Pijat FullBody" + nLine;
	}
	
	if(bekam == 1){
		pesanManusiawi += "- Bekam" + nLine;
	}
	
	if(lintah == 1){
		pesanManusiawi += "- Therapy Lintah" + nLine;
	}
	
	if(fashdu == 1){
		pesanManusiawi += "- Fashdu" + nLine;
	}
	
	if(elektrik == 1){
		pesanManusiawi += "- Therapy Elektrik" + nLine;
	}
	
	if(ruqyah == 1){
		pesanManusiawi += "- Plus Ruqyah" + nLine;
	}
	
	return pesanManusiawi;
	
	
}

function asHumanTrouble(){
	var nLine = "ENTER";
	var pesanAkhir = "Hello *admin RTH!*" + nLine +
				"saya *perlu bantuan akun login*" + nLine;
					
	return pesanAkhir;
}

function asHumanSadMessage(dataObject){
	
	var kode = dataObject.code;
	var jadwal = dataObject.human_date;
	var namaPenuh = dataObject.fullname;
	var nLine = "ENTER";
	var pesanAkhir = "Hello *admin RTH!*" + nLine +
				"saya *" + namaPenuh + "* sudah membatalkan booking untuk *Kode : " + kode +"* "+ nLine +
				"untuk jadwal *" + jadwal +"*" + nLine + 
				" Mohon Maaf ya...";
					
	
	return pesanAkhir;
}

function asHumanMessage(dataObject){
	
	var kode = dataObject.code;
	var jadwal = dataObject.human_date;
	var namaPenuh = dataObject.fullname;
	var treatmentPilihan = extractTreatment(dataObject);
	
	var nLine = "ENTER";
	var pesanAkhir = "Hello *admin RTH!*" + nLine +
				"saya *" + namaPenuh + "* sudah booking dengan *Kode : " + kode +"* "+ nLine +
				"untuk jadwal *" + jadwal + "* dengan tindakan *Treatment :* " + nLine +
				treatmentPilihan + "." + nLine + nLine + 
				"  mohon dikonfirmasi, *apakah bisa?*";
					
	
	return pesanAkhir;
}

function goToWhatsappKontak(){
	
	var message = asHumanTrouble();
	
	var pesan = encodeURI(message).replaceAll("ENTER", "%0a");
	var nomerAdmin = "6285871341474";
	//https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext
	var url = "https://api.whatsapp.com/send?phone=" + nomerAdmin + "&text=" + pesan;
	console.log("WHATSAPP : " + url);
	return url;
	
}

function goToWhatsapp(dataObject){
	
	var message = asHumanMessage(dataObject);
	
	var pesan = encodeURI(message).replaceAll("ENTER", "%0a");
	var nomerAdmin = "6285871341474";
	//https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext
	var url = "https://api.whatsapp.com/send?phone=" + nomerAdmin + "&text=" + pesan;
	console.log("WHATSAPP : " + url);
	return url;
}

function goToWhatsappCancel(dataObject){
	
	var message = asHumanSadMessage(dataObject);
	
	var pesan = encodeURI(message).replaceAll("ENTER", "%0a");
	var nomerAdmin = "6285871341474";
	//https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext
	var url = "https://api.whatsapp.com/send?phone=" + nomerAdmin + "&text=" + pesan;
	console.log("WHATSAPP : " + url);
	return url;
}

function updateSuccess(codeNa, tglNa){
	
	$('#booking-success-date').text(tglNa);
	$('#booking-success-code').text(codeNa);
	
}

function postDataBookingRequest(dataObject, codeNa, tglNa ){
	
		$.ajax({
                type: 'POST',
				dataType: 'json',
                url: '/booking/add',
                data: dataObject,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						$.mobile.changePage("#page-booking-success");
						
						window.parent.location.href = goToWhatsapp(dataObject);
						
						updateSuccess(codeNa, tglNa);
					
					}else{
						$.mobile.changePage("#page-booking-failed");
						console.log(JSON.stringify(result));
					}
					
					
					
                    
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-booking-failed");
                }
            });
	
}

function checkValidity(dataCome){
	
	var val = false;
	
	try {
	  var n = JSON.stringify(dataCome);
      var data = JSON.parse(n); // Try to parse the response as JSON
      
	  if(data.status == "valid"){
		  val = true;
	  }
	  
    } catch(err) {
      val = false;
    }
	
	return val;
	
}

function formResetPassValidation(){
	
	
	// this is for form-login
	 $("#form-reset").validate({
        rules: {
            reset_email: "required"
        },
        messages: {
            reset_email: "Isilah pake email saat mendaftar!"
        },
		submitHandler: function(form) {
			
			$.ajax({
                type: 'POST',
                url: '/user/resetpass',
                dataType: 'json',
                data: $('#form-reset').serialize(),
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						
					$.mobile.changePage("#page-reset-continue");
						
					
					}else{
						$.mobile.changePage("#page-reset-failed");
					}
					
                    
                },
                error : function(error) {
					console.log(error);
					alert(error);
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
}



function formLoginValidation(){
	
	
	// this is for form-login
	 $("#form-login").validate({
        rules: {
            username: "required",
			pass: "required"
        },
        messages: {
            username: "Isilah pake email atau no whatsapp!",
			pass: "password jangan kosong"
        },
		submitHandler: function(form) {
			
			$.ajax({
                type: 'POST',
                url: '/user/login',
                dataType: 'json',
                data: $('#form-login').serialize(),
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						//ambil nama username dari json
						var n = JSON.stringify(result);
						var dataNa = JSON.parse(n);
						var dataJSON = dataNa.multi_data;
						
						//console.log('didapat lah ' + JSON.stringify(dataJSON));
						var statNa = dataJSON.status;
						
						if(statNa == 'pending'){
							$.mobile.changePage("#page-login-pending");
						}else if(statNa == 'disabled') {
							$.mobile.changePage("#page-login-disabled");
						}else if(statNa == 'active'){
							$.mobile.changePage("#page-pilih-aksi");
						}
						
						$('#txt-fullname').text(dataJSON.full_name);
						$('#sembunyi-username').text(dataJSON.username);
						
						// this is a hack only
						username_sembunyi = dataJSON.username;
						fullname_sembunyi = dataJSON.full_name;
						gender_sembunyi = dataJSON.gender;
					
						// clearup
						clearFormLogin();
					
					}else{
						$.mobile.changePage("#page-login-failed");
					}
					
                    
                },
                error : function(error) {
					console.log(error);
					alert(error);
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
}

function remakeDataFormPesertaBaru(untukAnggota){
	
	kiriman = {};
	
	if(untukAnggota){
		
		// pakai hubungan keluarga
		// dan kosongkan email
		kiriman.email = '';
		kiriman.username_incharge = $('#sembunyi-username').text();
		
		hubungan_sembunyi = $('#peserta_baru_hubungan option:selected').text();
		kiriman.rel_connection = $('#peserta_baru_hubungan').val();
		
	}else{
		kiriman.email = $('#peserta_baru_email').val();
		hubungan_sembunyi = "";
	}
	
		kiriman.home_address = $('#peserta_baru_alamat').val();
		kiriman.contact = $('#peserta_baru_nomorhp').val();
		kiriman.gender = $('#peserta_baru_kelamin').val();
		kiriman.full_name = $('#peserta_baru_nama').val();
		
		kiriman.keluhan = $('#kesehatan_umum_keluhan').val();
		kiriman.merokok = $('#kesehatan_umum_merokok').val();
		kiriman.pernahinap = $('#kesehatan_umum_pernahinap').val();
		kiriman.pernahbius = $('#kesehatan_umum_pernahbius').val();
		kiriman.pernahdivonistbc = $('#kesehatan_umum_pernahdivonistbc').val();
		kiriman.pernahdivoniskanker = $('#kesehatan_umum_pernahdivoniskanker').val();
		kiriman.pernahdivonisjantung = $('#kesehatan_umum_pernahdivonisjantung').val();
		kiriman.pernahdivonisstroke = $('#kesehatan_umum_pernahdivonisstroke').val();
		kiriman.pernahanjuran = $('#kesehatan_umum_pernahanjuran').val();
		
		kiriman.pernahritual = $('#kesehatan_khusus_pernahritual').val();
		kiriman.pernahtd = $('#kesehatan_khusus_pernahtd').val();
		kiriman.pernahmimpi = $('#kesehatan_khusus_pernahmimpi').val();
		kiriman.pernahkunjungan = $('#kesehatan_khusus_pernahkunjungan').val();
		kiriman.pernahghaib = $('#kesehatan_khusus_pernahghaib').val();
		
	return kiriman;
}

function remakeDataFormProfil(){
	
	kiriman = {};
	kiriman.id = $('#profil_id').val();
	kiriman.membership = $('#profil_membership').val();
	kiriman.status = $('#profil_status').val();
	kiriman.username = $('#profil_username').val();
	kiriman.pass = $('#profil_pass').val();
	kiriman.email = $('#profil_email').val();
	kiriman.home_address = $('#profil_home_address').val();
	kiriman.contact = $('#profil_contact').val();
	kiriman.full_name = $('#profil_fullname_span').text();
	kiriman.gender = $('#profil_gender').val();
	
	return kiriman;
	
}


function formProfilValidation(){
	
	//alert('sedang validating...');
	
	// this is for form-login
	 $("#form-profil").validate({
        rules: {
			profil_pass: "required",
			profil_email: "required",
			profil_full_name: "required",
			profil_home_address: "required",
			profil_contact: "required"
        },
        messages: {
			profil_pass: "Tulis password pakai kombinasi huruf dan angka!",
			profil_email: "Tulis email anda yang masih aktif!",
			profil_full_name: "Tulis nama lengkapnya",
			profil_home_address: "Alamat lengkap anda dimana?",
			profil_contact: "Nomor whatsappnya?"
        },
		submitHandler: function(form) {
			
			// remake the data from the form-profil
			kiriman = remakeDataFormProfil();
			
			$.ajax({
                type: 'POST',
                url: '/user/update',
                dataType: 'json',
				data: kiriman,
                //data: $('#form-profil').serialize(),
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						$.mobile.changePage("#page-profil-updated");
						
						// next get back to menu
						setTimeout(backToMenuAksi, 2000);
						
						// sembunyiin form nya
						sembunyi('form-profil');
					
					}else{
						$.mobile.changePage("#page-pilih-aksi");
					}
					
					// clearup
					clearFormProfil();
                    
                },
                error : function(error) {
					console.log(error);
					//alert(error);
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
}



function formRegistrationValidation(anggota){
	
	anggotaNa = anggota;
	
	var untukEmail = "required";
	if(anggotaNa){
		untukEmail = "";
	}
	
     // this is for form-registrasi
	 $("#form-registrasi").validate({
        rules: {
            peserta_baru_nama: "required",
			peserta_baru_nomorhp: "required",
			peserta_baru_email: untukEmail,
			peserta_baru_ttl: "required",
			peserta_baru_pekerjaan: "required",
			peserta_baru_alamat: "required",
			kesehatan_umum_keluhan: "required"
        },
        messages: {
            peserta_baru_nama: "Isilah nama lengkap dengan benar!",
			peserta_baru_nomorhp: "Isilah nomor aktif whatsapp!",
			peserta_baru_email: "Email aktif anda?",
			peserta_baru_ttl: "Tempat dan tanggal lahir!",
			peserta_baru_pekerjaan: "Tuliskan pekerjaan anda!",
			peserta_baru_alamat: "Dimana anda tinggal sekarang?",
			kesehatan_umum_keluhan: "Tuliskan keluhan anda saat ini!"
        },
		submitHandler: function(form) {
			
			// take the form based on anggota or not?
				kiriman = remakeDataFormPesertaBaru(anggotaNa);
			
				//console.log('kita mau kirim ' + JSON.stringify(kiriman));
			
			$.ajax({
                type: 'POST',
                url: '/user/register',
                dataType: "json",
				data: kiriman,
                //data: $('#form-registrasi').serialize(),
                success: function(result) {
					if(anggotaNa){

						$.mobile.changePage("#page-anggota-success");
						
						$('#success-anggota-nama').text(kiriman.full_name);
						$('#success-anggota-hubungan').text(hubungan_sembunyi);
						
						setTimeout(backToMenuAksi, 2000);
						
					} else{
						$.mobile.changePage("#page-check-email");
					}
					
					// clearup
					clearFormRegistrasi();
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
	
	/*$.ajax({url: '/user/register',
                    data: {action : 'login', formData : $('#form-registrasi').serialize()}, // Convert a form to a JSON string representation
                        type: 'post',                   
                    async: true,
                    beforeSend: function() {
                        // This callback function will trigger before data is sent
                        $.mobile.showPageLoadingMsg(true); // This will show ajax spinner
                    },
                    complete: function() {
                        // This callback function will trigger on data sent/received complete
                        $.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
                    },
                    success: function (result) {
                            resultObject.formSubmitionResult = result;
                                        $.mobile.changePage("#page-check-email");
                    },
                    error: function (request,error) {
                        // This callback function will trigger on unsuccessful action                
                        alert('Network error harap daftar ulang!');
                    }
                });*/
	
	
}

function aktifkanTombolNext(){
	
	var checkterpilih = $('#page-pilih-terapi input:checked').length;
	
	if(checkterpilih > 0){
		$('#link-pilihan-terapi').show();
	}else{
		$('#link-pilihan-terapi').hide();
	}
	
}

function konversiAsHuman(computerDate){
	
	var hasil =  moment(computerDate, 'YYYY-MM-DD HH:mm:ss').format('dddd, DD-MMM-YYYY HH:mm');
	
	var hari = moment(computerDate, 'YYYY-MM-DD HH:mm:ss').format('dddd'); 
	
	hasil = hasil.replace(hari, convertDayEnglishToIndo(hari));
	
	return hasil;
	
}

function clickEventCancelBooking(){
	
	 $(document).on("click", ".treatment-cancel" , function() {
        
		// get the code of that booking
		// and post to server change the status
		 var codePilihan =  $(this).parent().parent().find('.treatment-code').text();
		 var tgl =  $(this).parent().parent().find('.treatment-schedule-date').text();
		 var namaP = $('#txt-fullname').text();
		
			tgl = konversiAsHuman(tgl);
		
		kiriman = {
			code : codePilihan,
			status : 'cancelled',
			fullname : namaP,
			human_date : tgl
		};
	 
		if(codePilihan !== undefined){
			// call data server for updating
			updateDataServer();
		
			refreshDataTable();
		}
		
		// and direct to whatsapp admin
		console.log('trying to open whatsapp admin...');
		
	});
	
}

function clickEventDeleteAnggota(){
	
	 $(document).on("click", ".anggota-delete" , function() {
        
		// get the code of that booking
		// and post to server change the status
		 var idNa =  $(this).attr('anggota-id');
		 var fName = $(this).parent().parent().find('.anggota-fullname').text();
		
		kiriman = {
			id: idNa,
			full_name : fName
		};
	 
		if(idNa !== undefined){
			// call data server for updating
			deleteDataAnggotaServer();
		
			refreshDataAnggotaTable();
		}
		
		// and direct to whatsapp admin
		console.log('trying to delete anggota member...');
		
	});
	
}


function clickEventAwal(){
	
	$("#link-workshop").click(function() {
		
		// jump to 
		// https://www.rumahterapiherbal.web.id/p/pendaftaran-pelatihan.html
		var url = "https://www.rumahterapiherbal.web.id/p/pendaftaran-pelatihan.html";
		window.parent.location.href = url;
		
		
	});
	
}

function clickEventFormKesehatan(){
	
	$("#tombol-kesehatan-umum").click(function() {
		tampilin('data-kesehatan-umum');
		$('#tombol-kesehatan-umum').closest('.ui-btn').hide();
	});
	
	$("#tombol-kesehatan-khusus").click(function() {
		tampilin('data-kesehatan-khusus');
		$('#tombol-kesehatan-khusus').closest('.ui-btn').hide();
	});
	
}

function sembunyiParentDiv(idNa){
	var namina = "";
	
	if(!idNa.includes('#') && !idNa.includes('.')){
	
		namina = '#' + idNa;
	
	}else{
		namina = idNa;
	}
	
	//console.log('sembunyiin ' + namina);
	
	$(namina).parent().hide();
}

function sembunyi(idNa){
	
	
	var namina = "";
	
	if(!idNa.includes('#') && !idNa.includes('.')){
	
		namina = '#' + idNa;
	
	}else{
		namina = idNa;
	}
	
	//console.log('sembunyiin ' + namina);
	
	$(namina).hide();
}

function tampilin(idNa){
	
	var namina = "";
	
	if(!idNa.includes('#') && !idNa.includes('.')){
	
		namina = '#' + idNa;
	
	}else{
		namina = idNa;
	}
	
	$(namina).show();
}

function toggleAllTindakan(){

	 $("#checkbox-umum").click(function() {
		 toggleCheckbox('checkbox-bekam');
		 toggleCheckbox('checkbox-lintah');
		  toggleCheckbox('checkbox-fashdu');
		   toggleCheckbox('checkbox-elektrik');
		    toggleCheckbox('checkbox-pijat-fullbody');
			 toggleCheckbox('checkbox-ruqyah');
			 
			 aktifkanTombolNext();
	 });
	 
	$("#checkbox-bekam").click(function() {
		  aktifkanTombolNext();
	});
	
	$("#checkbox-elektrik").click(function() {
		  aktifkanTombolNext();
	});
	
	$("#checkbox-fashdu").click(function() {
		  aktifkanTombolNext();
	});
	
	$("#checkbox-lintah").click(function() {
		  aktifkanTombolNext();
	});
	
	$("#checkbox-ruqyah").click(function() {
		  aktifkanTombolNext();
	});
	
	$("#checkbox-pijat-fullbody").click(function() {
		  aktifkanTombolNext();
	});
	
	
		
}

function backToMenuAksi(){
	
	$.mobile.changePage("#page-pilih-aksi", "flip", true, true);

}

function nextPage1(){
	
	$.mobile.changePage("#page1", "flip", true, true);

}

function toggleCheckbox(idna){
	var nami = '#' + idna;
	var chk = $(nami);
	
	var stat = chk.prop('checked');
	
	if(stat == true){
		chk.prop('checked', false).checkboxradio('refresh');
	}
	
}


function createSelectOption2Weeks(){
	var limit = 14;
	var x=0;
	var formatDiinginkan = 'dddd, D-MMM-YYYY';
	var formatDB = 'YYYY-MM-DD';
	var formatHariAja = 'dddd';
	//let dateFormat1 = moment().format(formatDiinginkan);
	
	
	for(x=-1; x<limit; x++){
		var tglDB = moment().add(x+1, "day").format(formatDB);
		var tgl = moment().add(x+1, "day").format(formatDiinginkan);
		var hariAja = moment().add(x+1, "day").format(formatHariAja);
		var hariIndo = convertDayEnglishToIndo(hariAja);
		tgl = tgl.replace(hariAja, hariIndo);
		var elemen = "<option value='"+ tglDB +"'>" + tgl +" </option>";
		$('#pilih-tanggal').append(elemen);
		
	}
	
}

function convertDayEnglishToIndo(dayName){
	
	var english = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	
	var indo = ["Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
	
	var i=0;
	var hariIndo = "";
	
	for(i=0; i<7; i++){
		
		if(dayName == english[i]){
			hariIndo = indo[i];
			break;
		}
		
	}
	
	return hariIndo;
	
	
}