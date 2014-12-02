/*	
	Student Info JS


*/
(function ()
{

$( document ).ready(function() 
{	
	$("#studentView").on('click',function()
	{
		if($("#studentList").val() == null)
			return;
		window.location.href = "Student/Info/" + $("#studentList").val();
	});
	$("#projectView").on('click',function()
	{
		if($("#projectList").val() == null)
			return;
		window.location.href = "Project/" + $("#projectList").val();
	});
	
	$("#studentFile").on("change", uploadStudentFile);
	$("#projectFile").on("change", uploadProjectFile);
	
	$('#genAssign').on('click', genAssign);
	$('#studentList').on('click', 'option', quickViewStudent);
	//$('#studentList').on('mouseleave', 'option', unQuickViewStudent);
});

function unQuickViewStudent(e)
{
	$("#quickView").hide();
}


function quickViewStudent(e)
{
	$("#quickView").show();
	$.ajax({
		type: 'get',
        url: "Admin/QVStudent/" + $(this).val(),
		dataType: "json",
		success: quickViewStudent_success,
		error: ajaxError
		
	});
}

function quickViewStudent_success(resp)
{
	console.log(resp);
	$("#qvName").text(resp.Student.FirstName + " " + resp.Student.LastName);
	$("#qvEMail").text(resp.Student.EMail);
	$("#qvMajor").text(resp.Student.Major);
	$("#qvMinor").text(resp.Student.Minor);
	$("#qvOtherInfo").text(resp.Student.OtherInfo);
	
	for(var v in resp.Projects)
	{
		$("#PreProjList").append(
			"<tr>" +
			"<td>" + resp.Projects[v].pivot.Priority + "</td>" +
			"<td>" + resp.Projects[v].ProjectName + "</td>" +
			"</tr>"
		);
	}
	
}

function uploadStudentFile(e)
{
	var data = new FormData();
	$.each(e.target.files, function(key, value)
	{
		data.append(key, value);
	});
	$.ajax({
		type: 'POST',
        url: "Admin/StudentFile",
		data: data,
		dataType: "json",
		cache: false,
        processData: false,
        contentType: false,
		success: uploadStudentFile_success,
		error: ajaxError
		
	});

}

function uploadStudentFile_success(respData)
{
	console.log(respData);
	$("#studentList").empty();
	for(var s in respData)
	{
		console.log(respData[s]);
		$("#studentList").append("<option value=\"" + respData[s].CWID + "\">" + respData[s].FirstName + " " + respData[s].LastName +" </option>");
	}
}

function uploadProjectFile(e)
{
	var data = new FormData();
	$.each(e.target.files, function(key, value)
	{
		data.append(key, value);
	});
	$.ajax({
		type: 'POST',
        url: "GenAssign",
		data: data,
		dataType: "json",
		cache: false,
        processData: false,
        contentType: false,
		success: uploadProjectFile_success,
		error: ajaxError
		
	});

}

function uploadProjectFile_success(respData)
{
	console.log(respData);
	$("#projectList").empty();
	for(var s in respData)
	{
		console.log(respData[s]);
		$("#projectList").append("<option value=\"" + respData[s].id + "\">" + respData[s].Company + " " + respData[s].ProjectName +" </option>");
	}
}

function genAssign()
{

	$.ajax({
		type: 'GET',
        url: "Admin/GenAssign",
		dataType: "json",
		success: genAssign_success,
		error: ajaxError
		
	});

}

function genAssign_success(respData)
{
	console.log(respData);

}

function ajaxError(qXHR, textStatus, errorThrown)
{
	console.log(errorThrown);
	console.log(qXHR);
	alert("Unable to complete action.  Please refresh and try again.");
}

})();