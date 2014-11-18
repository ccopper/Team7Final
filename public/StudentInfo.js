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
	$("#ppInp3").change(updateSI);
	
	$("#majInp").on('input', showUnsaved);
	$("#minInp").on('input', showUnsaved);
	$("#oiInp").on('input', showUnsaved);
	$("#ppInp1").on('input', showUnsaved);
	$("#ppInp2").on('input', showUnsaved);
	
	
	$("#newPre").data("list", $("#PreferSuggest"));
	$("#PreferSuggest").on('click', 'li', preferStudent);
	
	$("#newAvoid").data("list", $("#AvoidSuggest"));
	$("#AvoidSuggest").on('click', 'li', avoidStudent);
	
	$("#newPre").on('input',findStudents);
	$("#newAvoid").on('input', findStudents);
	
	$("#PrePartList").on("click", "button" , unPreferStudent);
	$("#AvoidPartList").on("click", "button" , unAvoidStudent);
	
	$("#addProject").on("click", addProject);
});

function showUnsaved()
{
	$("#UnsavedAlert").show();
}

function updateSI()
{
	$.ajax({
		type: 'POST',
        url: "Update/" + $("#CWID").text(),
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
	$("#UnsavedAlert").hide();
}

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
        url: "Find",
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

function preferStudent()
{
	console.log("Here");
	$.ajax({
		type: 'GET',
        url: "Prefer/" + $("#CWID").text() + "/" + $(this).data("CWID"),
        dataType: "json", 
		success: preferStudent_success,
		error: ajaxError
		
	});
}
function preferStudent_success(respData)
{
	console.log(respData);
	$("#newPre").val("");
	$("#PreferSuggest").hide();
	
	$("#PrePartList").append(
		"<tr id=\"P" + respData.CWID + "\">" +
		"<td class=\"col-md-10\">" + respData.FirstName + " " + respData.LastName + "</td>" +
		"<td class=\"col-md-2\"><button type=\"button\" value=\""+ respData.CWID +"\">-</button></td></tr>"
	);
}

function avoidStudent()
{
	$.ajax({
		type: 'GET',
        url: "Avoid/" + $("#CWID").text() + "/" + $(this).data("CWID"),
        dataType: "json", 
		success: avoidStudent_success,
		error: ajaxError
		
	});
}
function avoidStudent_success(respData)
{
	console.log(respData);
	$("#newAvoid").val("");
	$("#AvoidSuggest").hide();
	
	$("#AvoidPartList").append(
		"<tr id=\"P" + respData.CWID + "\">" +
		"<td class=\"col-md-10\">" + respData.FirstName + " " + respData.LastName + "</td>" +
		"<td class=\"col-md-2\"><button type=\"button\" value=\""+ respData.CWID +"\">-</button></td></tr>"
	);
}

function unPreferStudent()
{
	$.ajax({
		type: 'GET',
        url: "UnPrefer/" + $("#CWID").text() + "/" + $(this).val(),
        dataType: "json", 
		success: unPreferStudent_success,
		error: ajaxError
		
	});
}
function unPreferStudent_success(respData)
{
	console.log(respData);
	$("#P" + respData.CWID).remove();
}

function unAvoidStudent()
{
	$.ajax({
		type: 'GET',
        url: "UnAvoid/" + $("#CWID").text() + "/" + $(this).val(),
        dataType: "json", 
		success: unAvoidStudent_success,
		error: ajaxError
		
	});
}
function unAvoidStudent_success(respData)
{
	console.log(respData);
	$("#A" + respData.CWID).remove();
}

function addProject()
{
	$.ajax({
		type: 'GET',
        url: "ProjectSelect/" + $("#CWID").text() + "/" + $("#newProjID").val() + "/" + $("#newProjPri").val(),
        dataType: "json", 
		success: addProject_success,
		error: ajaxError
		
	});

}

function addProject_success(respData)
{
	console.log(respData);
	$("#PreProjList").empty();
	for(var v in respData)
	{
		console.log(respData[v]);
		$("#PreProjList").append(
			"<tr>" +
			"<td class=\"col-md-2\">" + respData[v].pivot.Priority + "</td>" +
			"<td class=\"col-md-10\">" + respData[v].Company + " " + respData[v].ProjectName + "</td>" +
			//"<td class=\"col-md-2\"><button type=\"button\" value=\""+ respData[v].ProjectID +"\">-</button></td>"+
			"</tr>"
		);
	}
}

function ajaxError(qXHR, textStatus, errorThrown)
{
	console.log(errorThrown);
	alert("Unable to complete action.  Please refresh and try again.");
}

})();