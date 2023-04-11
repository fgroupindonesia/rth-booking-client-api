var kiriman = {};
var dataWhole = [];

// this is for whatsapp purposes (admin notif)
var url_sembunyi = "";

var data5Jam = ["08:00", "10:00", "13:00", "16:00", "20:00"];
var batasJam = data5Jam.length;

$(document).ready(function(){
	
	setTimeout(nextPage1, 3000);
	
	formLoginValidation();
	formProfilValidation();
	
	registerEventClick();
	
	registerEventType();
	
});

function registerEventType(){
	
	$(".detail-description").on('input',function(e){
		
		// update the selected data
		var v = $(this).parent().parent().find('select').val();
		
		var idNa = $(this).attr('data-id');
		var gender = $('#flip-gender').val();
		
		kiriman = {};
		kiriman.id = idNa;
		kiriman.date_chosen = $('#detail-tanggal-computer').text();
		kiriman.specific_hour = $(this).attr('data-jam');
		kiriman.status = v;
		kiriman.description = $(this).val();
		kiriman.gender_therapist = gender;
		
		console.log('coba send type ' + JSON.stringify(kiriman));
		
		updateDataScheduleServer(false);
		
		
		
	});
	
}

function showErrorCalendar(psan){
	tampilin('calendar-error');
	sembunyi('calendar-loading');
	$('#calendar-error').text(psan);
}

function hideErrorCalendar(){
	sembunyi('calendar-error');
}

function updateDummyDataScheduleServer(tglComputer, indexNow){
	
	var indexJam =	indexNow;
	
	let myPromise = new Promise(function(myResolve, myReject) {
	 
		tampilin('calendar-loading');
		sembunyi('calendar-error');
		
		var jam = data5Jam[indexJam];
		addScheduleData(jam, tglComputer);

	  if (indexJam < batasJam-1) {
		indexJam++;
		myResolve(indexJam);
	  } else {
		indexJam=0;
		
		// last request once completely filling the dummy data 
		// now read data from server untuk this data
		grabDataScheduleSpecificServer();
		
		myReject("done");
	  }
	});

	myPromise.then(
	  function(value) { updateDummyDataScheduleServer(tglComputer, value);},
	  function(error) { sembunyi('detail-loading'); 
						sembunyi('calendar-loading'); 
						sembunyi('calendar-error'); }
	);
	
}

function ukuranObject(obj){
        return Object.keys(obj).length;
}

function addScheduleData(jamMasuk, tglComputer){
	
	kiriman = {};
	kiriman.date_chosen = tglComputer;
	kiriman.specific_hour = jamMasuk;
	kiriman.status = 0; // default is OFF which is 0
	kiriman.description = ""; // default is empty
	kiriman.gender_therapist = $('#flip-gender').val();
	
	// kalau data sudah ready dlm 5 key format properties baru
	// maka boleh kirim deh
	if(ukuranObject(kiriman)==5){
	
	console.log('kirim dummy ' + JSON.stringify(kiriman));
	
	$.ajax({
                type: 'POST',
                url: '/schedule/add',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
					}
					grabDataScheduleServer();	
                },
                error : function(error) {
					
                }
    });
	
	}
	
}

function grabDataScheduleSpecificServer(){
	
	var genderna = $('#flip-gender').val();
	var tgl = $('#detail-tanggal-computer').text();
	
	kiriman = {};
	kiriman.date_chosen = tgl;
	kiriman.gender_therapist = genderna;
	
	console.log('nyoba grab ' + JSON.stringify(kiriman));
	
	$.ajax({
                type: 'POST',
                url: '/schedule/detail',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataToDetail(result);
						
						sembunyi('detail-error');
						
					}else{
						
						tampilin('detail-error');
						
						console.log(JSON.stringify(result));
						
					}
					
					sembunyi('detail-loading');
					
                },
                error : function(error) {
						tampilin('detail-error');
						sembunyi('detail-loading');
                }
    });
	
}

function grabDataScheduleServer(){
	
	var genderna = $('#flip-gender').val();
	
	// this is MMMMYYYY
	var formatNa = "MMMMYYYY";
	var bulanTahunNempel = $('.month-container').text();
	
	kiriman = {};
	kiriman.month_year = moment(bulanTahunNempel, formatNa).format('MMMM YYYY').toLowerCase();
	kiriman.gender_therapist = genderna;
	
	//console.log('kirimin ' + JSON.stringify(kiriman));
	
	$.ajax({
                type: 'POST',
                url: '/schedule/all',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						//console.log('untuk schedule' + JSON.stringify(result));
						extractDataToCalendar(result);
						hideErrorCalendar();
					}else{
						// if error
						//console.log('error for updating calendar !\n' + result);
						showErrorCalendar("data not found!");
						// remove all marks on calendar if any
						clearCalendar();
						
						console.log(JSON.stringify(result));
						
					}
					
                },
                error : function(error) {
					showErrorCalendar("error!");
                }
    });
	
}

function updateDataScheduleServer(backToCalendar){
	
	$.ajax({
                type: 'POST',
                url: '/schedule/update',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
							if(backToCalendar){
								$.mobile.changePage("#page-kalendar");
								grabDataScheduleServer();
							}
					}
					
                },
                error : function(error) {
					showErrorCalendar("error!");
                }
    });
	
}

function autoFillData(angkaMasuk){
	
	// from 1 date of this month
	// until 30 end of this month
	var blnTahun = $('.month-container').text();
	var formatNa = "MMMMYYYY";
	var startDayMonth = moment(blnTahun, formatNa).startOf('month');
	var lastDayMonth = moment(blnTahun, formatNa).endOf('month').format('DD');
	
	var hariKe = angkaMasuk;
		
		let myPromise = new Promise(function(myResolve, myReject) {
		
			var dateGiven = moment(startDayMonth).add(hariKe, 'days').format('YYYY-MM-DD');
			
			updateDummyDataScheduleServer(dateGiven, 0);
		
			if(hariKe < lastDayMonth){
				hariKe++;
				myResolve(hariKe);
			}else{
				myReject('done');
			}
		
		});

		// "Consuming Code" (Must wait for a fulfilled Promise)
		myPromise.then(
		  function(value) { autoFillData(value); },
		  function(error) { /* code if some error */ }
		);
	
}

function resetDetailForm(){
	switchClass(8, false);
	switchClass(10, false);
	switchClass(13, false);
	switchClass(16, false);
	switchClass(20, false);
	
	sembunyi('detail-description-jam8');
	sembunyi('detail-description-jam10');
	sembunyi('detail-description-jam13');
	sembunyi('detail-description-jam16');
	sembunyi('detail-description-jam20');
	
	$('.detail-description').val('');
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
	kiriman.full_name = $('#profil_full_name').val();
	kiriman.gender = $('#profil_gender').val();
	
	return kiriman;
	
}

function clearFormProfil(){
	
	$("#form-profil").each(function(){this.reset();});
	
}

function formProfilValidation(){
	
	//alert('sedang validating...');
	
	// this is for form-login
	 $("#form-profil").validate({
        rules: {
			profil_pass: "required",
			profil_full_name: "required",
			profil_home_address: "required",
			profil_contact: "required"
        },
        messages: {
			profil_pass: "Tulis password pakai kombinasi huruf dan angka!",
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
						
						$.mobile.changePage("#page-management-pasien");
						
						refreshDataPasienTable();
					
					}
					
					// clearup
					clearFormProfil();
					console.log('dapet na ' + JSON.stringify(result));
                    
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

function switchClass(jam, tongol3Kolom){
	
	if(tongol3Kolom == false){
		$('#data-jam'+jam).addClass('ui-grid-a');
		$('#data-jam'+jam).removeClass('ui-grid-b');
	}else{
		$('#data-jam'+jam).addClass('ui-grid-b');
		$('#data-jam'+jam).removeClass('ui-grid-a');
	}
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

function grabDataUserProfilServer(){
	
	
	
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
						tampilin('user-detail-data');
						
					}
					
					sembunyi('user-detail-loading');
					
					//console.log(result);
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
}


function registerEventClick(){

$(document).on("click", ".pasien-fullname a" , function() {
			 
			 var fullname = $(this).text();
			 var noID = $(this).attr('data-id');
			 
			 kiriman = {};
			 kiriman.id = noID;
			 
			 console.log('akan kirimkan request user detail ' + JSON.stringify(kiriman));
			 
			 sembunyi('user-detail-data');
			 tampilin('user-detail-loading');
			 
			 setTimeout(grabDataUserProfilServer, 2000);
			 
			 
 });


 $(document).on("click", ".treatment-code a" , function() {
			 
			 var codeNa = $(this).text();
			 var noID = $(this).attr('data-id');
			 
			 kiriman = {};
			 kiriman.code = codeNa;
			 kiriman.id = noID;
			 
			 //console.log('akan kirimkan treatment code ' + JSON.stringify(kiriman));
			 
			 sembunyi('booking-detail-data');
			 tampilin('booking-detail-loading');
			 
			 setTimeout(grabDataBookingDetailServer, 2000);
			 
			 
 });

	
$("#link-kembali-kalendar").bind("click", function() {
	
	$.mobile.changePage("#page-kalendar");
	
	grabDataScheduleServer();
	
});	

$("#link-management-pasien").bind("click", function() {
	
	refreshDataPasienTable();
		
});	

$("#link-aktifasi").bind("click", function() {

	$('.pasien-id:checked').each(function () {
       
	  var emailNa =  $(this).parent().parent().find('.pasien-email').text();
	 
		kiriman = {
			email : emailNa
		};
	 
		console.log('mencoba aktifasi ' + JSON.stringify(kiriman));
	 
		if(emailNa !== ""){
			updateDataActivationServer();
		}else{
			alert('pasien tidak memiliki email!');
		}
	 
  });
	
	
		
});

$("#link-non-aktifasi").bind("click", function() {

	$('.pasien-id:checked').each(function () {
       
	  var idNa =  $(this).val();
	 
		kiriman = {
			id : idNa
		};
	 
		console.log('mencoba penguncian ' + JSON.stringify(kiriman));
	 
		if(idNa !== ""){
			updateDataDisactivationServer();
		}
	 
  });
	
	
		
});		

$("#link-logout").bind("click", function() {
	
	$.mobile.changePage("#page0", {reloadPage : true});
	setTimeout(nextPage1, 5000);
	
});	

$(document).on( "slidestop",  "#flip-gender" ,function( event, ui ) {
        
	grabDataScheduleServer();
	
});

$(document).on( "slidestop",  ".slider-jam" ,function( event, ui ) {
        
	var v =	$(this).val();
	var desc = '';
	
	if(v == '1'){
		$(this).parent().parent().addClass('ui-grid-b');
		$(this).parent().parent().removeClass('ui-grid-a');
		$(this).parent().parent().find('textarea').show();
		
		desc = $(this).parent().parent().find('textarea').val();
	}else if(v == '0'){
		$(this).parent().parent().addClass('ui-grid-a');
		$(this).parent().parent().removeClass('ui-grid-b');
		$(this).parent().parent().find('textarea').hide();
		
		// clear the text area
		$(this).parent().parent().find('textarea').val('');
	}
	
	// update the selected data
	
	var idNa = $(this).attr('data-id');
	var gender = $('#flip-gender').val();
	
	kiriman = {};
	kiriman.id = idNa;
	kiriman.date_chosen = $('#detail-tanggal-computer').text();
	kiriman.specific_hour = $(this).attr('data-jam');
	kiriman.status = v;
	kiriman.description = desc;
	kiriman.gender_therapist = gender;
	
	console.log('mau disend ' + JSON.stringify(kiriman));
	
	updateDataScheduleServer(false);
	
	
	
});

$(".link-calendar").bind("click", function() {
	
	$.mobile.changePage("#page-kalendar");
	
	$('.calendar-container').calendar({
		date:new Date(),
		onClickDate: function (date) {
			console.log(JSON.stringify(date));
			
			var tglManusiawi = konversiAsHuman(date);
			
			$('#detail-tanggal-computer').text(date);
			$('#detail-tanggal').text(tglManusiawi);
			
			// clear detail form
			resetDetailForm();
			
			// send data to server for this date
			// with 5 hours of data OFF
			// etc: 08:00, 10:00, 13:00, 16:00, 20:00
			updateDummyDataScheduleServer(date, 0);
			
			nextDetailPage();
		}
	});
	
	grabDataScheduleServer();	
	
	// create the button near the today button
	createAutomaticFillButton();
	
	// hide the loading info
	sembunyi('calendar-loading');
	
});	

$(document).on( "click",  ".auto-fill-button" ,function() {
        
	// given from day 0 
	autoFillData(0);
		
});

$(document).on( "click",  ".prev-button" ,function() {
        
	grabDataScheduleServer();	
	
	// create the button near the today button
	createAutomaticFillButton();
	
});

$(document).on( "click",  ".next-button" ,function() {
        
	grabDataScheduleServer();	
	
	// create the button near the today button
	createAutomaticFillButton();
	
});
		
$("#refresh-all").bind("click", function() {
	
	refreshDataTable();
	
});	

$("#refresh-pasien").bind("click", function() {
	
	refreshDataPasienTable();
	
});	

$("#link-terapkan-lainnya").bind("click", function() {
	
	// obtain several data from hours of 
	// that date
	console.log('clicked');
	
});	

$("#link-delete").bind("click", function() {
 
	// get selected data
 	$('.treatment-id:checked').each(function () {
       
	  var codePilihan =  $(this).parent().parent().find('.treatment-code').text();
	 
		kiriman = {
			code : codePilihan
		};
	 
		if(codePilihan !== undefined){
				// call data server for deleting
			deleteDataServer();
		
			refreshDataTable();
		}
	 
		
  });
  
  
	
});
	
$("#link-update").bind("click", function() {
 
	// get selected data
 	$('.treatment-id:checked').each(function () {
       
	  var code =  $(this).parent().parent().find('.treatment-code').text();
	  var usname = $(this).parent().parent().find('.treatment-username').text();
	  var sched = $(this).parent().parent().find('.treatment-schedule-date').text();
	  var idNa = $(this).val();
	  
	  var dateNa = $(this).parent().parent().find('.treatment-schedule-date').attr('date');
	  var hourNa = $(this).parent().parent().find('.treatment-schedule-date').attr('hour');
	  
	  var genderNa = $(this).parent().parent().find('.treatment-gender').text();
	  
	  if(code !== undefined){
	  
		$('#upstat-id-treatment').text(idNa);
		$('#upstat-code-treatment').text(code);
		$('#upstat-username-treatment').text(usname);	
		$('#upstat-schedule-treatment').text(sched);	
		
		// computer date 
		$('#upstat-computer-date-treatment').text(dateNa);
		$('#upstat-computer-hour-treatment').text(hourNa);
		$('#upstat-gender-treatment').text(genderNa);
		//alert('piilhan ' + $(this).val());
		
		$.mobile.changePage("#page-update-stat");
		
	  }
	  
  });
  
  
	
});

$("#confirm-data-terpilih").bind("click", function() {

	var statPilihan = $('#status-treatment').val();
	var codePilihan = $('#upstat-code-treatment').text();
	var idNa = $('#upstat-id-treatment').text();
	var gen = $('#upstat-gender-treatment').text();
	var hourNa = $('#upstat-computer-hour-treatment').text();
	var dateNa = $('#upstat-computer-date-treatment').text();
	
	// given the data 
	kiriman = {
		status : statPilihan,
		code : codePilihan,
		gender : gen,
		date: dateNa,
		hour: hourNa,
		id : idNa
	};
	
	console.log('mo konfirmasi ' + JSON.stringify(kiriman));
	
	// call server for updating 
	updateDataServer();
	
	$('#status-treatment').selectmenu();
	$('#status-treatment').selectmenu('refresh', true);
	
	
});

$("#link-reset").bind("click", function() {
 
	// get selected data
 	$('.pasien-id:checked').each(function () {
       
	    var emailNa =  $(this).parent().parent().find('.pasien-email').text();
		var idNa =  $(this).val();
	 
		kiriman = {
			reset_email : emailNa,
			id : idNa
		};
	 
		console.log('mencoba reset password via email ' + JSON.stringify(kiriman));
	 
		if(emailNa !== ""){
			updateDataResetPassEmailServer();
		}else{
			alert('pasien tidak memiliki email! Resetting default...');
			updateDataResetPassChatServer();
		}
	 
		
  });
  
  
	
});
		
}


function grabDataBookingDetailServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/booking/detail',
                dataType: 'json',
                data: kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						// we set the number of family
						var n = JSON.stringify(result);
						var dataJSON = JSON.parse(n);
						
						var data = dataJSON.multi_data;
						var c = data.code;
						var sc = data.schedule_date;
						var fname = data.full_name;
						// extract data
						
						$('#booking-detail-code').text(c);
						$('#booking-detail-schedule-date').text(konversiAsHumanWithHour(sc));
						$('#booking-detail-fullname').text(fname);
						
						console.log('kita ada ' + JSON.stringify(data));
						
						var tr  = "<b>Untuk Treatment:</b> <br>";
						tr += extractTreatment(data);
						tr = tr.replaceAll("ENTER", "<br>");
						
						$('#booking-detail-treatment').html(tr);
						
						tampilin('booking-detail-data');
						sembunyi('booking-detail-loading');
						
					}else{
						// tampilkan error
						
					}
					
                },
                error : function(error) {
					console.log(error);
					$.mobile.changePage("#page-error-server");
                }
            });
	
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

function konversiAsHuman(computerDate){
	
	var hasil =  moment(computerDate, 'YYYY-MM-DD HH:mm:ss').format('dddd, DD-MMM-YYYY');
	
	var hari = moment(computerDate, 'YYYY-MM-DD HH:mm:ss').format('dddd'); 
	
	hasil = hasil.replace(hari, convertDayEnglishToIndo(hari));
	
	return hasil;
	
}

function konversiAsHumanWithHour(computerDate){
	
	var hasil = konversiAsHuman(computerDate);
	// get the hour
	var jam = computerDate.split(" ")[1].substring(0,5);
	return hasil + " " + jam;
}

function refreshDataTable(){
	
	// clear the div
	$('#data-table-head').nextAll('div').remove();
	
	// show the loading
	tampilin('management-loading');
	
	// grab after 3 seconds
	setTimeout(	grabDataAllBookingServer, 3000);

	
}

function refreshDataPasienTable(){
	
	// clear the div
	$('#pasien-table-head').nextAll('div').remove();
	
	// show the loading
	tampilin('management-loading-pasien');
	
	// grab after 3 seconds
	setTimeout(	grabDataAllPasienServer, 3000);

	
}

function tampilinTextarea(val, jam, desc){
	if(val == 1){
			    $('#detail-description-jam'+jam).val(desc);
				tampilin('detail-description-jam'+jam);
				switchClass(jam, true);
	}else{
				sembunyi('detail-description-jam'+jam);
				switchClass(jam, false);
	}
}

function extractDataToDetail(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n);
	
	console.log('dapet dr detail ' + JSON.stringify(dataCome));
	
	var isiNa = data.multi_data;
	// we got 5 hours data
	for(let p = 0; p < isiNa.length; p++){
		
		var dateChosen = isiNa[p].date_choosen;
		var currStatus = isiNa[p].status;
		var desc = isiNa[p].description;
		var id = isiNa[p].id;
		var jam = isiNa[p].specific_hour;
		
		var el = {};
		
		if(jam == '08:00'){
			
			$('#detail-description-jam8').attr('data-id', id);
			$('#flip-jam8').attr('data-id', id);
			
			el = $('#flip-jam8');
			
			tampilinTextarea(currStatus, '8', desc);
			
			
		}else if(jam == '10:00'){
			
			$('#detail-description-jam10').attr('data-id', id);
			$('#flip-jam10').attr('data-id', id);
			
			el = $('#flip-jam10');
			
			tampilinTextarea(currStatus, '10', desc);
			
		}else if(jam == '13:00'){
			
			$('#detail-description-jam13').attr('data-id', id);
			$('#flip-jam13').attr('data-id', id);
			
			el = $('#flip-jam13');
			
			tampilinTextarea(currStatus, '13', desc);
			
		}else if(jam == '16:00'){
		
			$('#detail-description-jam16').attr('data-id', id);
			$('#flip-jam16').attr('data-id', id);
			
			el = $('#flip-jam16');
			
			tampilinTextarea(currStatus, '16', desc);
			
		}else if(jam == '20:00'){
			
			$('#detail-description-jam20').attr('data-id', id);
			$('#flip-jam20').attr('data-id', id);
			
			el = $('#flip-jam20');
		
			tampilinTextarea(currStatus, '20', desc);
		}
		
		el.val(currStatus).slider('refresh');
		//el.selectmenu();
		//el.selectmenu('refresh', true);
		
		
		
	}
	
	
}

function extractDataToCalendar(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n);
	
	// reset
	dataWhole = [];
	clearCalendar();
	
	var isiNa = data.multi_data;
	for(let p = 0; p < isiNa.length; p++){
		
		var statNa = "";
		var dateChosen = isiNa[p].date_chosen;
		var currStatus = isiNa[p].status;
		
		if(!isAlreadyInWholeData(dateChosen)){
			statNa = addIntoWholeData(dateChosen, currStatus);
			//console.log('added into ' + dateChosen);
		}else{
			statNa = updateWholeData(dateChosen, currStatus);
			//console.log('updated from ' + dateChosen);
		}
		
		fillCalendar(dateChosen, statNa);
		
	}
	
	
}

function isAlreadyInWholeData(dateChosen){
	
	var fon = false;
	var i = 0;
	
	for(i = 0; i<dataWhole.length; i++){
		if(dataWhole[i].date == dateChosen){
			fon = true;
			break;
		}
	}
	
	return fon;
	
}

function addIntoWholeData(dataDate, dataStat){
	
	var n = {};
	n.date = dataDate;
	n.availability = 0;
	
	n.availability += parseInt(dataStat);
	
	dataWhole.push(n);
	
	//console.log('add new ' + JSON.stringify(n));
	
	// default
	return "day-filled";
	
}

function createAutomaticFillButton(){
	
	var elemen = "<button class='auto-fill-button'>Automatic</button>";
	$('.special-buttons').append(elemen);
	
	
}

function clearCalendar(){
	
	var blnTahun = $('.month-container').text();
	var formatNa = "MMMMYYYY";
	var startDayMonth = moment(blnTahun, formatNa).startOf('month');
	var lastDayMonth = moment(blnTahun, formatNa).endOf('month').format('DD');
	var i = 0;
	
	for(i=0; i<lastDayMonth; i++){
	
		var dateGiven = moment(startDayMonth).add(i, 'days').format('YYYY-MM-DD');
		
		//console.log('we have ' + dateGiven);
		
		var param = '[data-date='+ dateGiven +']';
		$('.week').find(param).find('span').removeClass('day-full');
		$('.week').find(param).find('span').removeClass('day-filled');
		$('.week').find(param).find('span').removeClass('day-0');
		
	}
	
}

function fillCalendar(dateGiven, stat){
	
	var param = '[data-date='+ dateGiven +']';
	
	if(stat == 'day-full'){
		$('.week').find(param).find('span').removeClass('day-filled');
		$('.week').find(param).find('span').removeClass('day-0');
	}else if(stat == 'day-filled'){
		$('.week').find(param).find('span').removeClass('day-full');
		$('.week').find(param).find('span').removeClass('day-0');
	}else if(stat == 'day-0'){
		$('.week').find(param).find('span').removeClass('day-full');
		$('.week').find(param).find('span').removeClass('day-filled');	
	}
	
	$('.week').find(param).find('span').addClass(stat);
	
}

function updateWholeData(dateGiven, stat){
	
	var status = "";
	var i = 0;
	
	for(i=0; i<dataWhole.length; i++){
	
		if(dataWhole[i].date == dateGiven){
			
			//console.log( i + ' aslinya nya ' + dataWhole[i].date + " dengan v : " + dataWhole[i].availability);
			
			var v = dataWhole[i].availability;
			var n = parseInt(v) + parseInt(stat);
			dataWhole[i].availability = n;
			
			if(dataWhole[i].availability >= 5){
				status = "day-full";
			}else if(dataWhole[i].availability>0){
				status = "day-filled";
			}else {
				status = "day-0";
			}
			
			//console.log('kini jadi ' + dataWhole[i].date + " dengan v : " + dataWhole[i].availability);
			
			break;
			
		}
	
	
	
	}
	
	return status;
}

function extractDataPasienToTable(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n); // Try to parse the response as JSON
	
	var isiNa = data.multi_data;
	
	for(let p = 0; p < isiNa.length; p++){
		//console.log(isiNa[p]);
		/*
		CREATING THIS ONE
		<div class="ui-grid-d" id="pasien-table-head" >
			<div class="ui-block-a"><b>ID</b></div>
			<div class="ui-block-b"><b>FULLNAME</b></div>
			<div class="ui-block-c"><b>CONTACT</b></div>
			<div class="ui-block-d"><b>STATUS</b></div>
			<div class="ui-block-e"><b>GENDER</b></div>
		</div>
		
		*/
		
		var hiddenEmail = "<span hidden class='pasien-email'>" +isiNa[p].email+ "</span>";
		
		var encloser1a = "<div class='ui-grid-d data-table-cell'>";
		var encloser1b = "</div>";
		
		var chk = "<input class='pasien-id' type='checkbox' value='" +isiNa[p].id + "'/>";
		
		var linkFullname = "<a href='#page-user-detail' data-id='"+ isiNa[p].id  +"'>" +isiNa[p].full_name + "</a>";
		
		var id = "<div class='ui-block-a'>" + chk + "</div>";
		var fullname = "<div class='ui-block-b pasien-fullname'>" + linkFullname + "</div>";
		var contact = "<div class='ui-block-c pasien-contact'>" + isiNa[p].contact + "</div>";
		
		var classGender = "pasien-female";
		
		if(isiNa[p].gender == 1){
			classGender = "pasien-male";
		}
		
		
		var classActiveWarning = " pasien-active";
		
		if(isiNa[p].status == "disabled"){
			classActiveWarning = " pasien-nonactive";
		}else if(isiNa[p].status == "active"){
			classActiveWarning = " pasien-active";
		}else if(isiNa[p].email == ""){
			classActiveWarning = " pasien-no-email";
		}
		
		var genderIcon = "<span data-gender='"+ isiNa[p].gender +"' class='pasien-gender "+ classGender+"'></span>";
		
		var stat = "<div class='ui-block-d"+classActiveWarning+"'>" + isiNa[p].status + "</div>";
		
		var gender = "<div class='ui-block-e'>" + genderIcon + "</div>";
		
		var combined = encloser1a + hiddenEmail + id + fullname + contact + stat + gender + encloser1b;
		
		$(combined).insertAfter("#pasien-table-head");
		
	}
	
}

function extractDataToTable(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n); // Try to parse the response as JSON
	
	var isiNa = data.multi_data;
	
	for(let p = 0; p < isiNa.length; p++){
		//console.log(isiNa[p]);
		/*
		CREATING THIS ONE
		<div class="ui-grid-d data-table-cell" >
			<div class="ui-block-a"><b>ID</b></div>
			<div class="ui-block-b"><b>CODE</b></div>
			<div class="ui-block-c"><b>USERNAME</b></div>
			<div class="ui-block-d"><b>SCHEDULE DATE</b></div>
			<div class="ui-block-e"><b>STATUS</b></div>
		</div>
		
		*/
		var classGender = "treatment-female";
		
		if(isiNa[p].gender == 1){
			classGender  = "treatment-male";
		}
		
		var encloser1a = "<div class='ui-grid-d data-table-cell'>";
		var encloser1b = "</div>";
		
		var chk = "<input class='treatment-id' type='checkbox' value='" +isiNa[p].id + "'/>";
		
		var genderHidden = "<span hidden class='treatment-gender'>" + isiNa[p].gender + "</span>";
		
		var linkNa = "<a data-id='"+ isiNa[p].id +"' href='#page-booking-detail' >" + isiNa[p].code + "</a>";
		
		var id = genderHidden + "<div class='ui-block-a'>" + chk + "</div>";
		var code = "<div class='ui-block-b treatment-code'>" + linkNa + "</div>";
		var usname = "<div class='ui-block-c treatment-username "+ classGender +"'>" + isiNa[p].username + "</div>";
		
		var tgl = konversiAsHumanWithHour(isiNa[p].schedule_date);
		var dateNa = isiNa[p].schedule_date.split(" ")[0];
		var hourNa = isiNa[p].schedule_date.split(" ")[1].substring(0,5);

		var sdate = "<div hour='"+hourNa+"' date='"+dateNa+"' class='ui-block-d treatment-schedule-date'>" + tgl + "</div>";
		var stat = "<div class='ui-block-e'>" + isiNa[p].status + "</div>";
		
		
		var combined = encloser1a + id + code + usname + sdate + stat + encloser1b;
		
		$(combined).insertAfter("#data-table-head");
		
	}
	
}

function updateDataActivationServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/activate/now',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						refreshDataPasienTable();
					}else{
					
					// if error
					console.log('error for updating data pasien!\n' + result);	
					
					}
					
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function updateDataDisactivationServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/disactivate/now',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						refreshDataPasienTable();
						
					}else{
					
					// if error
					console.log('error for updating data pasien!\n' + result);	
					
					}
					
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function updateDataResetPassEmailServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/resetpass/via/email',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						refreshDataPasienTable();
						
					}else{
					
					// if error
					console.log('error for updateDataResetPassEmailServer!\n' + result);	
					
					}
					
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function updateDataResetPassChatServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/resetpass/via/chat',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						
						extractDataResetToWhatsapp(result);
						
					}else{
					
					// if error
					console.log('error for updateDataResetPassEmailServer!\n' + result);	
					
					}
					
                },
                error : function(error) {
					console.log(JSON.stringify(error));
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
						$.mobile.changePage("#page-management-booking");
						refreshDataTable();
					}else{
						// if error
					console.log('error for updating booking status!\n' + result);	
					
					}
					
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function deleteDataServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/booking/delete',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						$.mobile.changePage("#page-management-booking");
					}else{
						// if error
						
					console.log('error for deleting booking status!\n' + result);	
					
					}
					
					sembunyi('management-loading');
					
					
                },
                error : function(error) {
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function grabDataAllBookingServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/booking/all',
                dataType: 'json',
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataToTable(result);
						
						
					}
					
					//console.log(result);
					sembunyi('management-loading');
					
                },
                error : function(error) {
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function grabDataAllPasienServer(){
	
	// request data from server
	$.ajax({
                type: 'POST',
                url: '/user/all',
                dataType: 'json',
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						
						extractDataPasienToTable(result);
						
					}
					
					//console.log(result);
					sembunyi('management-loading-pasien');
					
                },
                error : function(error) {
					$.mobile.changePage("#page-error-server");
                }
            });
	
}

function checkValidity(dataCome){
	
	var val = false;
	
	try {
	  var n = JSON.stringify(dataCome);
      const data = JSON.parse(n); // Try to parse the response as JSON
      
	  if(data["status"] == "valid"){
		  val = true;
	  }
	  
    } catch(err) {
      val = false;
	  console.log("error at "+ err);
    }
	
	return val;
	
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
                dataType: "json",
                data: $('#form-login').serialize(),
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						$.mobile.changePage("#page-menu-aksi");
						// request data from Server
						grabDataAllBookingServer();
					}else{
						$.mobile.changePage("#page-login-failed");
					}
					
                    
                },
                error : function(error) {
					console.log(JSON.stringify(error));
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
}

function extractDataResetToWhatsapp(result){
	
	console.log('extracting ' + JSON.stringify(result));
	
	var n = JSON.stringify(result);
	var dataJSON = JSON.parse(n);
	
	var token = dataJSON.multi_data;
	
	var url = "https://rumahterapiherbal.web.id/p/reset-akun.html?token=" + token;
	
	var nLine = "ENTER";
	var pesanAkhir = "Barusan Sistem Reset oleh *admin RTH!*" + nLine +
				"untuk anda telah dilakukan. Silahkan klik link berikut untuk *Reset Password* " + nLine + 
				" Akses Segera di :" + nLine +
				url;
	
	var pesan = encodeURI(pesanAkhir).replaceAll("ENTER", "%0a");
	var nomerAdmin = "6285871341474";
	//https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext
	var url = "https://api.whatsapp.com/send?phone=" + nomerAdmin + "&text=" + pesan;	
	
	url_sembunyi = url;
	setTimeout(visitWhatsappNotif, 3000);
	
	
}

function visitWhatsappNotif(){
	window.parent.location.href = url_sembunyi;
}

function sembunyi(idNa){
	var namina = '#' + idNa;
	$(namina).fadeOut();
}

function tampilin(idNa){
	var namina = '#' + idNa;
	$(namina).fadeIn();
}

function nextPage1(){
	
	$.mobile.changePage("#page1", "flip", true, true);

}

function nextDetailPage(){
	
	$.mobile.changePage("#page-detail", "pop", true);

}