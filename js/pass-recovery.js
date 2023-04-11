
var url_login = "https://rumahterapiherbal.web.id/p/booking.html"

$(document).ready(function(){
	
	// hide the token at the moment
	$('#token').hide();
	
	recoveryFormValidation();
	registerTypingEvent();
	registerClickEvent();
	
	//alert('a');
	
});

function registerTypingEvent(){
	
	$('.inputan').on('input',function(e){
   
		var pass1 = $('#pass').val();
		var pass2 = $('#pass2').val();
		
		if(pass1 == pass2){
			$('#error_message').hide();
			$('#tombol-submit').show();
		}else{
			$('#error_message').show();
			$('#tombol-submit').hide();
		}
   
	});
	
}

function registerClickEvent(){
	
	$("#link-relogin").bind("click", function() {
	
		window.parent.location.href = url_login;
	
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

function recoveryFormValidation(){
	
	// this is for form-recovery
	 $("#form-recovery").validate({
        rules: {
            pass: "required",
			pass2: "required"
        },
        messages: {
            pass: "Isilah pake kombinasi huruf besar kecil, dan beberapa angka!",
			pass2: "Password harus sama persis seperti diatas."
        },
		submitHandler: function(form) {
			
			$.ajax({
                type: 'POST',
                url: '/user/resetpass/update',
                dataType: 'json',
                data: $('#form-recovery').serialize(),
                success: function(result) {
					
					// check validity
					if(checkValidity(result)){
						$.mobile.changePage("#page-password-success");
					}else{
						console.log(JSON.stringify(result));
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