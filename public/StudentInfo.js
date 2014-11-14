/*	
	Student Info JS


*/
(function ()
{

$( document ).ready(function() 
{	
	$("#oiInp").val($("#oiInp").val().trim());

	$("#majInp").change(updateSI);
	$("#minInp").change(updateSI);
	$("#oiInp").change(updateSI);
	$("#ppInp1").change(updateSI);
	$("#ppInp2").change(updateSI);
	
	$("#newPre").on('input', findStudents);
});


function updateSI()
{
	$.ajax({
		type: 'POST',
        url: "Student/Update/" + $("#CWID").text(),
		data: 
		{ 
			"fieldName": $(this).attr("name"),
			"fieldValue":  $(this).val()
		},
        dataType: "json", 
		success: updateSI_success,
		error: ajaxError
		
	});	
}

function updateSI_success(respData)
{
	console.log(respData);
}

function findStudents()
{
	if($("#newPre").val().trim() == "")
	{
		$("#studentList").hide();
		return;
	}

	$.ajax({
		type: 'POST',
        url: "Student/Find",
		data:
		{
			"Name": $("#newPre").val().trim()
		},
        dataType: "json", 
		success: findStudents_success,
		error: ajaxError
		
	});
}

function findStudents_success(respData)
{
	$("#studentList ul").empty();
	$("#studentList").show();

	for(var v in respData)
	{
		$("#studentList ul").append($("<li>", 
		{
			text: respData[v].FirstName + " " + respData[v].LastName,
			data: { CWID: respData[v].CWID},
			click: function()
			{
				
			}
		}));
	}
}

function preferStudent()
{
	$.ajax({
		type: 'POST',
        url: "Student/Find",
		data:
		{
			"Name": $("#newPre").val().trim()
		},
        dataType: "json", 
		success: findStudents_success,
		error: ajaxError
		
	});
}



function ajaxError(qXHR, textStatus, errorThrown)
{
	console.log(errorThrown);
	alert("Unable to complete action.  Please refresh and try again.");
}

})();