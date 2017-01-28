function dbServerCheck(path, method,val, callback){
	$.ajax({
        url:path,
		data: val,
        method: method
     }).done(function(data) {
        console.log("success from server");
		callback(data)
     }).fail(function( reqObj, textStatus ) {  
        console.log("error server call");
     
     });
};

function checkAuthorization(data){
	//console.log("auth console",data);
	//console.log("not data",data);
	var obj = JSON.parse(data);
	console.log(typeof data);
	if(obj.id === undefined) {
		alert('Your email/password worng, try again');
		var par = $('<p>').text('**Your email/password worng, try again');
		$('#form').append(par);
		console.log(par);
	} else {
		//Todo add redirct 
		var url = 'home.php';
		window.location.href = url;
		alert('great');
	}
}


//grabbing fields values
$(':button').on('click',function(){
	var emailVal = $('#inputEmail').val();
	var passVal = $('#inputPassword').val();
	var user = {};
	user['email'] =emailVal;
	user['pass'] =passVal;
	validateFields(emailVal, passVal);
	dbServerCheck('credentialsManager.php','POST',user,checkAuthorization);
});

function validateFields(email, password){
	if(email == "" || password == ""){
		alert('please insert all details')
	}
};