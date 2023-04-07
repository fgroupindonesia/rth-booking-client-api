var kiriman = {};
var dataWhole = [];

$(document).ready(function(){
	
	setTimeout(nextPage1, 3000);
	
	formLoginValidation();
	
	registerEventClick();
	
});

function showErrorCalendar(psan){
	tampilin('calendar-error');
	$('#calendar-error').text(psan);
}

function hideErrorCalendar(){
	sembunyi('calendar-error');
}

function grabDataScheduleServer(){
	
	var genderna = $('#flip-gender').val();
	
	// this is MMMMYYYY
	var formatNa = "MMMMYYYY";
	var bulanTahunNempel = $('.month-container').text();
	
	kiriman = {};
	kiriman.month_year = moment(bulanTahunNempel, formatNa).format('MMMM YYYY').toLowerCase();
	kiriman.gender_therapist = genderna;
	
	console.log('kirimin ' + JSON.stringify(kiriman));
	
	$.ajax({
                type: 'POST',
                url: '/schedule/all',
                dataType: 'json',
				data : kiriman,
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						console.log('untuk schedule' + JSON.stringify(result));
						extractDataToCalendar(result);
						hideErrorCalendar();
					}else{
						// if error
						console.log('error for updating calendar !\n' + result);
						showErrorCalendar("data not found!");
						// remove all marks on calendar if any
						clearCalendar();
						
					}
					
                },
                error : function(error) {
					showErrorCalendar("error!");
                }
    });
	
}

function registerEventClick(){
	
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
	
});

$("#link-calendar").bind("click", function() {
	
	$.mobile.changePage("#page-kalendar");
	
	$('.calendar-container').calendar({
		date:new Date(),
		onClickDate: function (date) {
			console.log(JSON.stringify(date));
			nextDetailPage();
		}
	});
	
	grabDataScheduleServer();	
	
});	

$(document).on( "click",  ".prev-button" ,function() {
        
	grabDataScheduleServer();	
	
});

$(document).on( "click",  ".next-button" ,function() {
        
	grabDataScheduleServer();	
	
});
	
	
$("#refresh-all").bind("click", function() {
	
	refreshDataTable();
	
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

function refreshDataTable(){
	
	// clear the div
	$('#data-table-head').nextAll('div').remove();
	
	// show the loading
	tampilin('management-loading');
	
	// grab after 3 seconds
	setTimeout(	grabDataServer, 3000);

	
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
			console.log('added into ' + dateChosen);
		}else{
			statNa = updateWholeData(dateChosen, currStatus);
			console.log('updated from ' + dateChosen);
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
	
	n.availability += eval(dataStat);
	
	
	dataWhole.push(n);
	
	console.log('add new ' + JSON.stringify(n));
	
	// default
	return "day-filled";
	
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
		
	}
	
}

function fillCalendar(dateGiven, stat){
	
	var param = '[data-date='+ dateGiven +']';
	$('.week').find(param).find('span').addClass(stat);
	
}

function updateWholeData(dateGiven, stat){
	
	var status = "";
	var i = 0;
	
	for(i=0; i<dataWhole.length; i++){
	
		if(dataWhole[i].date == dateGiven){
			var v = dataWhole[i].availability;
			
			dataWhole[i].availability = eval(v) + eval(stat);
			
			if(dataWhole[i].availability >= 5){
				status = "day-full";
			}else if(dataWhole[i].availability>0){
				status = "day-filled";
			}
			
			console.log('ada nya ' + dataWhole[i].date + " dengan v : " + dataWhole[i].availability);
			
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


function grabDataServer(){
	
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
						grabDataServer();
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