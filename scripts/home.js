function ajaxCall(callback,path, id) {
	var url = path;
	if(id) {
		url += '/'+id;
	}
	$.ajax({
          url:url,
          method: 'GET'
        }).done(function(data) {
           console.log("1 success from server");
			data = JSON.parse(data);
			callback(data)
       }).fail(function( reqObj, textStatus ) {  
           console.log("error server call");
     
        });
}

function uploadData(val, path, method) {
	$.ajax({
          url:path,
	      data: val,
          method: method
        }).done(function(data) {
           console.log("2 success from server");
		   console.log(data);
       }).fail(function( reqObj, textStatus ) {  
           console.log("error server call");
        });
}


function buildStudentsCol(students){
	for(var i=0; i<students.length; i++){
	$('#studentsList').append("<div  class='student-profile' data-student-id="+students[i].id+"><div class='user-image'  style='background-image: url("+students[i].image +")'></div><div class='user-details'><p>"+students[i].name+"</p><p>"+students[i].phone+"</p></div></div>");
};	
};

//--populate course deatils
function buildCoursesCol(courses){
	//console.log(courses);
	for(var i=0; i<courses.length; i++){
		$('#coursesList').append("<div class='course-profile' data-course-id="+courses[i].id+"><div class='course-image'  style='background-image: url("+courses[i].image+")'></div><div class='course-details'><p>"+courses[i].name+"</p></div></div>");
 };
for(var i=0; i<courses.length; i++){
	$('#courses-check-list > ul').append('<li course-id='+courses[i].id+'><input id="checkCourse" value="'+courses[i].name+'" type="checkbox">'+courses[i].name +'</li>')
	
};	
};

//--add student by clicking save in modal --
$('#save-student').on('click', function(){
	var studentDetails = {};
	studentDetails['name'] = $('#name').val();
	studentDetails['phone'] = $('#phone').val();
	studentDetails['email'] = $('#email').val();	
	studentDetails['image']= $('#studentImage').css('background-image');
	studentDetails['courses'] = [];
	$('#checkCourse:checked').each(function(){
		var thisId = $(this).parent().attr('course-id');
	studentDetails['courses'].push(thisId);
		console.log("course ID",thisId);
});
	
	var rt = validateStudentFields(studentDetails);
	if(rt){
		studentDetails['image'] = studentDetails['image'].substring(5, studentDetails['image'].length - 2);
		uploadData(studentDetails, "studentsManager.php", 'POST');
		clearStudentFields();
		$('#modal1').modal('toggle');
	}else{
		alert("please insert details");
	}
});

//---validate student inputs
function validateStudentFields(studentDetails){	
	if(!(studentDetails.name && studentDetails.phone && studentDetails.email && studentDetails.courses && studentDetails.image)){
		return false;
	}else{
		return true;
	}
}
//---clear student fields
function clearStudentFields() {
	$('#name').val('');
	$('#phone').val('');
	$('#email').val('');
}

//---clear student fields
function clearCourseFields() {
	$('#CourseName').val('');
	$('#courseDescription').val('');
	$('#CourseImage').val('');
}

//-- 
$("#image").change(function(){
	var thisImage = this;
	$('#image-ctr').append('<div id="studentImage"></div>');
	 if (thisImage.files && thisImage.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#studentImage').css('background-image', 'url(' + e.target.result +')');
            }
            reader.readAsDataURL(thisImage.files[0]);
      }
});


//--add course by clicking save in courses modal --
$("#save-course").on("click", function(){
	var file = document.getElementById('CourseImage').files[0];
	var courseDetails = {};
	courseDetails["name"] = $("#CourseName").val();
	courseDetails["type"] = "uploadCourse";
	courseDetails["description"] = $("#courseDescription").val();
	courseDetails["image"] =  $('#courseImageDisplay').css('background-image');
	var courseVal = validateCourseFields(courseDetails);
	if(courseVal){
		courseDetails['image'] = courseDetails['image'].substring(5, courseDetails['image'].length - 2);
		uploadData(courseDetails, "coursesManager.php", 'POST');
		clearCourseFields();
		$('#modal2').modal('toggle');
	}else{
		alert("please insert details");
	}
});


$("#CourseImage").change(function(){
	var thisCourseImage = this;
	$('#image-course-ctr').append('<div id="courseImageDisplay"></div>');
	 if (thisCourseImage.files && thisCourseImage.files[0]) {
            var readerCourses = new FileReader();
            readerCourses.onload = function (e) {
                $('#courseImageDisplay').css('background-image', 'url(' + e.target.result +')');
            }
            readerCourses.readAsDataURL(thisCourseImage.files[0]);
      }
});

//validate course fields
function validateCourseFields(courseDetails){	
	if(!(courseDetails.name && courseDetails.description && courseDetails.image)){
		return false;
	}else{
		return true;
	}
}
//--click on student div and get student details
$(document).on('click','.student-profile', function(){
	var studentId = $(this).attr('data-student-id');
	ajaxCall(showStudentsDetails,'studentsManager.php', studentId);
});

function showStudentsDetails(studentdetails){
	console.log(studentdetails.courses);
	$('#main-container').empty();
	//$('#main-container').css('display','normal')
	$("#main-container").append("<div id='main-inner-ctr'><div id='ctr-header'><h3>Student Name:</h3></div><div id='ctr-img' style='background-image: url("+studentdetails.image+");'></div><div id='students-details'><p>"+studentdetails.name+"<span></span></p><p>"+studentdetails.phone+"<span></span></p><p>"+studentdetails.email+"<span></span></p></div><div id='student-courses-list'><ol></ol></div></div>");
	$("#main-container").slideDown(1000);
	for(var i=0; i<studentdetails.courses.length; i++){
		$('#student-courses-list > ol').append('<li>'+studentdetails.courses[i].name+'</li>')
	}
}

//--click on course div and get course details
$(document).on('click','.course-profile', function(){
	var courseId = $(this).attr('data-course-id');
	ajaxCall(showCourseDetails,'coursesManager.php', courseId);
});
//build course div
function showCourseDetails(coursedetails){
	console.log(coursedetails);
	$('#main-container').empty();
	$("#main-container").append("<div id='main-inner-ctr'><div id='ctr-header'><h3>Course "+coursedetails.name+"</h3></div><div id='ctr-img' style='background-image: url("+coursedetails.image+");'></div><div id='ctr-desc'><div><h1>"+coursedetails.name+"</h1><p>"+coursedetails.description+"</p></div></div><div id='ctr-student-list'><h4>students</h4><ol id='studentsInCourse'></ol></div></div>");
	$("#main-container").slideDown(1000);
	
	for(var i=0; i<coursedetails.students.length; i++){
	$('#studentsInCourse').append('<li>'+coursedetails.students[i].name+'</li>')
	
	}
	
}



