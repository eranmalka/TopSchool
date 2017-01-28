function saveAdminInServer(url, val, callback){
		$.ajax({
          url:url,
		  data: val,
          method: 'POST'
        }).done(function(data) {
           console.log("1 success from server");
			callback(data)
       }).fail(function( reqObj, textStatus ) {  
           console.log("error server call");
     
        });
}

function getAllAdmins(callback,path, id) {
	var url = path;
	if(id) {
		url += '/'+id;
	}
	$.ajax({
          url:url,
          method: 'GET'
        }).done(function(data) {
           console.log("admins call success from server");
			data = JSON.parse(data);
			callback(data)
       }).fail(function( reqObj, textStatus ) {  
           console.log("error server call");
     
        });
}

function buildAdmin(data){
	console.log(data);
	for(var i = 0; i < data.length; i++){
	$('#adminlist').append("<div class='admin-profile' data-admin-id="+data[i].id+"><div class='admin-image'  style='background-image: url("+data[i].image+")'></div><div class='admin-details'><p>"+data[i].name+"</p><p>"+data[i].email+"</p><p>Role: "+data[i].role+"</p></div></div>");
	}
}


$('#save-admin').on('click', function(){
	var validateForm = validateFields();
	if(validateForm){
		var adminDetails = {};
		adminDetails['name'] = $('#name').val();
		adminDetails['phone'] = $('#phone').val();
		adminDetails['email'] = $('#email').val();
		adminDetails['pass'] = $('#password').val();
		//setting role type
		var selected = $("input[type='radio'][name='role']:checked").next().text();
		adminDetails['role'] = selected;
		//grabbing image val
		var imageVal = $('#adminImagepreview').css('background-image');
		adminDetails['image'] =imageVal.substring(5, imageVal.length - 2);
		console.log(adminDetails);
		saveAdminInServer('administratorsManager.php',adminDetails, console.log);
		cleanForm();
	}else {
		var errPlace = $('modal-footer');
		var par = $('<p>').text('**please fill in deatlis in all fields');
		$('.modal-footer').append(par);
	}
	});

function cleanForm(){
	$('#name').val('');
	    $('#phone').val('');
	    $('#email').val('');
        $('#password').val('');
        $('#adminImage').val('');
		$("input[type='radio']").attr("checked","").attr("checked", false);
		$('#adminImagepreview').css('background-image', '');
		$('#adminImagepreview').remove();
		$('#modal').modal('toggle');
};


function validateFields(){
	console.log("image = ", $('#adminImage').val());
	if(!($('#name').val() && $('#phone').val() && $('#email').val() && $("input[type='radio'][name='role']:checked").next().text() && $('#adminImage').val())){
		return false;
	}else{
		 return true;
	}
}


$("#adminImage").change(function(){
	var thisImage = this;
	$('#admin-image-ctr').append('<div id="adminImagepreview"></div>');
	 if (thisImage.files && thisImage.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#adminImagepreview').css('background-image', 'url(' + e.target.result +')');
            }
            reader.readAsDataURL(thisImage.files[0]);
      }
});