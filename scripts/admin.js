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

function deleteAdmin(url){
		$.ajax({
          url:url,
          method: 'DELETE'
        }).done(function(data) {
           console.log("1 success from server");
       }).fail(function( reqObj, textStatus ) {  
           console.log("error server call");
     
        });
}

function updateAdmin(val, path) {
	$.ajax({
          url:path,
	      data: val,
          method: 'PUT'
        }).done(function(data) {
           console.log("2 success from server");
		   console.log(data);
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
        var isEdieMode = $('#save-admin').attr('on-edit-mode');
        if(isEdieMode){
            alert('edit mode');
            adminDetails['id'] = $('#save-admin').attr('adminId');
            updateAdmin(adminDetails, 'administratorsManager.php/'+adminDetails['id']);
        }else
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

//displaying admin-profile when clicked
$(document).on('click','.admin-profile', function(){
	var admintId = $(this).attr('data-admin-id');
	getAllAdmins(showAdminDetails,'administratorsManager.php',admintId);
});

function showAdminDetails(adminDetails){
	console.log('im in callback function', adminDetails);
	$('#main-container').empty();
	//$('#main-container').css('display','normal')
	$("#main-container").append("<div id='main-inner-ctr'><div admin-id='"+adminDetails.id+"' id='ctr-header'><h3>Admin Details</h3><button class='delAdmin btn btn-danger'>Delete</button><button class='editAdmin btn btn-primary'>Edit</button></div><div id='ctr-img' style='background-image: url("+adminDetails.image+");'></div><div id='students-details'><h2>"+adminDetails.name+"<span></span></h2><p>Phone: "+adminDetails.phone+"<span></span></p><p>Email: "+adminDetails.email+"<span></span></p></div><div id='student-courses-list'><ol></ol></div></div>");
	$("#main-container").slideDown(1000);
}

$(document).on('click','.delAdmin', function(){
	var adminId = $(this).parent().attr('admin-id');
	deleteAdmin('administratorsManager.php/'+adminId);
	$('[data-admin-id="' + adminId + '"]').remove();
	$('[admin-id="' + adminId + '"]').parent().remove();
	$('#main-container').css('display', 'none');
	
});

$(document).on('click','.editAdmin', function(){
	var adminId = $(this).parent().attr('admin-id');
	$('#save-admin').attr('on-edit-mode','yes').attr('adminId',adminId);
	console.log(adminId);
	getAllAdmins (prepareEdit, 'administratorsManager.php',adminId);
});

function prepareEdit(data){
	$('#modal').modal('toggle');
	var adminName = data.name;
	var adminPhone = data.phone;
	var adminEmail = data.email;
	var adminPass = data.pass;
	var adminRole = data.role;
	var adminImg = data.image;
	var adminNameInp = $('#name');
	var adminPhoneInp = $('#phone');
	var adminEmailInp = $('#email');
	var adminPassInp = $('#password');
	//var adminRoleInp = $('#password');
	adminNameInp.val(adminName);
	adminPhoneInp.val(adminPhone);
	adminEmailInp.val(adminEmail);
	adminPassInp.val(adminPass);
	var inputSeries = $("input[type='radio']");
    var textSpan = $('#roleSec span');
    /*console.log(inputSeries);
    console.log(textSpan.text());*/
    inputSeries.each(function(){
        console.log(adminRole);
        console.log($(this).next().text());
        if(adminRole == $(this).next().text()){
            $(this).prop( "checked", true);
            return;
        }
    })
    
    
	$('#admin-image-ctr').append('<div id="adminImagepreview" style= "background-image:url('+adminImg+')"></div>');
}


