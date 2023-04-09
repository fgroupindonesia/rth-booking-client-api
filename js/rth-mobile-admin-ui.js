var kiriman = {};
var dataWhole = [];

var data5Jam = ["08:00", "10:00", "13:00", "16:00", "20:00"];
var batasJam = data5Jam.length;

$(document).ready(function(){
	
	setTimeout(nextPage1, 3000);
	
	formLoginValidation();
	
	registerEventClick();
	
});

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
		myReject("done");
	  }
	});

	myPromise.then(
	  function(value) { updateDummyDataScheduleServer(tglComputer, value);},
	  function(error) { sembunyi('calendar-loading'); sembunyi('calendar-error'); }
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
	var tgl = $('#detail-tanggal-computer').val();
	
	kiriman = {};
	kiriman.date_chosen = tgl;
	kiriman.gender_therapist = genderna;
	
	//console.log('kirimin ' + JSON.stringify(kiriman));
	
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
						tampilin('detail-loading');
					}else{
						
						tampilin('detail-error');
						sembunyi('detail-loading');
						
						console.log(JSON.stringify(result));
						
					}
					
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

function registerEventClick(){
	
$("#link-kembali-kalendar").bind("click", function() {
	
	$.mobile.changePage("#page-kalendar");
	
	grabDataScheduleServer();
	
	
	
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
	
	if(v == 'on'){
		$(this).parent().parent().addClass('ui-grid-b');
		$(this).parent().parent().removeClass('ui-grid-a');
		$(this).parent().parent().find('textarea').show();
	}else if(v == 'off'){
		$(this).parent().parent().addClass('ui-grid-a');
		$(this).parent().parent().removeClass('ui-grid-b');
		$(this).parent().parent().find('textarea').hide();
		
	}
	
	// read data from server untuk this data
	grabDataScheduleSpecificServer();
	
});

$("#link-calendar").bind("click", function() {
	
	$.mobile.changePage("#page-kalendar");
	
	$('.calendar-container').calendar({
		date:new Date(),
		onClickDate: function (date) {
			console.log(JSON.stringify(date));
			
			var tglManusiawi = konversiAsHuman(date);
			
			$('#detail-tanggal-computer').text(date);
			$('#detail-tanggal').text(tglManusiawi);
			
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
	  
	  if(code !== undefined){
	  
		$('#upstat-code-treatment').text(code);
		$('#upstat-username-treatment').text(usname);	
		$('#upstat-schedule-treatment').text(sched);			
		//alert('piilhan ' + $(this).val());
		
		$.mobile.changePage("#page-update-stat");
		
	  }
	  
  });
  
  
	
});


$("#confirm-data-terpilih").bind("click", function() {

	var statPilihan = $('#status-treatment').val();
	var codePilihan = $('#upstat-code-treatment').text();
	
	// given the data 
	kiriman = {
		status : statPilihan,
		code : codePilihan
	};
	
	// call server for updating 
	updateDataServer();
	
	refreshDataTable();
	
	
});

	
	
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

function refreshDataTable(){
	
	// clear the div
	$('#data-table-head').nextAll('div').remove();
	
	// show the loading
	tampilin('management-loading');
	
	// grab after 3 seconds
	setTimeout(	grabDataAllBookingServer, 3000);

	
}

function extractDataToDetail(dataCome){
	
	var n = JSON.stringify(dataCome);
    var data = JSON.parse(n);
	
	
	var isiNa = data.multi_data;
	// we got 5 hours data
	for(let p = 0; p < isiNa.length; p++){
		
		var statNa = "";
		var dateChosen = isiNa[p].date_chosen;
		var currStatus = isiNa[p].status;
		var desc = isiNa[p].description;
		var id = isiNa[p].id;
		var jam = isiNa[p].specific_hour;
		
		if(jam == '08:00'){
			
		}
		
		
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
		var encloser1a = "<div class='ui-grid-d data-table-cell'>";
		var encloser1b = "</div>";
		
		var chk = "<input class='treatment-id' type='checkbox' value='" +isiNa[p].id + "'/>";
		
		var id = "<div class='ui-block-a'>" + chk + "</div>";
		var code = "<div class='ui-block-b treatment-code'>" + isiNa[p].code + "</div>";
		var usname = "<div class='ui-block-c treatment-username'>" + isiNa[p].username + "</div>";
		var sdate = "<div class='ui-block-d treatment-schedule-date'>" + isiNa[p].schedule_date + "</div>";
		var stat = "<div class='ui-block-e'>" + isiNa[p].status + "</div>";
		
		
		var combined = encloser1a + id + code + usname + sdate + stat + encloser1b;
		
		$(combined).insertAfter("#data-table-head");
		
	}
	
}

var kiriman = "";

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
					}else{
						// if error
					console.log('error for updating booking status!\n' + result);	
					
					}
					
					
					
                },
                error : function(error) {
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
						sembunyi('management-loading');
						
					}
					
					//console.log(result);
					
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
						$.mobile.changePage("#page-management-booking");
						// request data from Server
						grabDataAllBookingServer();
					}else{
						$.mobile.changePage("#page-login-failed");
					}
					
                    
                },
                error : function(error) {
					$.mobile.changePage("#page-error-server");
                }
            });
			
		}
    });
	
	
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