/*	
	Student Info JS


*/
(function ()
{

$( document ).ready(function() 
{	
	
	$("#newPMember").data("list", $("#memberSuggest"));
	$("#memberSuggest").on('click', 'li', assignStudent);
	
	$("#newPMember").on('input',findStudents);
	
	$("#AssignStudentList").on("click", "button" , unAssignStudent);
});

function findStudents()
{
	if($(this).val().trim() == "")
	{
		$(this).data("list").hide();
		return;
	}
	var input = $(this);
	$.ajax({
		type: 'POST',
        url: "../Student/Find",
		data:
		{
			"Name": $(this).val().trim()
		},
        dataType: "json", 
		success: function(respData)
		{
			findStudents_success(input ,respData);
		},
		error: ajaxError
		
	});
}

function findStudents_success(input, respData)
{
	console.log(respData);
	input.data("list").children("ul").empty();
	input.data("list").show();

	for(var v in respData)
	{
		input.data("list").children("ul").append($("<li>", 
		{
			text: respData[v].FirstName + " " + respData[v].LastName,
			data: { CWID: respData[v].CWID},	
		}));
		
	}
}

function assignStudent()
{
	$.ajax({
		type: 'GET',
        url: "Assign/" + $("#ProjectID").text() + "/" + $(this).data("CWID"),
        dataType: "json", 
		success: assignStudent_success,
		error: ajaxError
		
	});
}
function assignStudent_success(respData)
{
	console.log(respData);
	$("#newPMember").val("");
	$("#memberSuggest").hide();
	
	$("#AssignStudentList").append(
		"<tr id=\"S" + respData.CWID + "\">" +
		"<td class=\"col-md-10\">" + respData.FirstName + " " + respData.LastName + "</td>" +
		"<td class=\"col-md-2\"><button type=\"button\" value=\""+ respData.CWID +"\">-</button></td></tr>"
	);
	$("#pCount").text(1 + parseInt($("#pCount").text()));
}

function unAssignStudent()
{
	$.ajax({
		type: 'GET',
        url: "UnAssign/" + $(this).val(),
        dataType: "json", 
		success: unAssignStudent_success,
		error: ajaxError
		
	});
}
function unAssignStudent_success(respData)
{
	console.log(respData);
	
	$("#A" + respData.CWID).remove();
	$("#pCount").text(parseInt($("#pCount").text()) - 1);
}


function ajaxError(qXHR, textStatus, errorThrown)
{
	console.log(errorThrown);
	console.log(qXHR);
	alert("Unable to complete action.  Please refresh and try again.");
}

})();