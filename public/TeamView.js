/*	
	TeamView JS


*/
(function ()
{

var dragEle = null;

$( document ).ready(function() 
{	
	$("table").on("dragover", dragOver);
	$("table").on("dragleave", dragLeave);
	$("table tr").on("dragstart", dragStart);
	
	$("table tr").on("mousedown", function()
	{
		$("table tr").removeClass("vDragSelection");
		quickViewStudent($(this).attr("id"));
		$(this).addClass("vDragSelection");
	});
	
	$("table").on("drop", drop);
});


function dragStart()
{
	dragEle = $(this);
	$(this).addClass("vDragSelection");	
}

function drop(event)
{
	event.preventDefault();  
    event.stopPropagation();
	
	$(this).append(dragEle);
	$(this).removeClass("vDropTarget");
	
	if($(this).attr("pid") != null)
	{
		assignStudent($(this).attr("pid"), dragEle.attr("id"));
	} else
	{
		unAssignStudent(dragEle.attr("id"));
	}	
	dragEle.removeClass("vDragSelection");
	unQuickViewStudent();
}

function assignStudent(pid,cwid)
{
	$.ajax({
		type: 'GET',
        url: "Assign/" + pid + "/" + cwid,
        dataType: "json", 
		success: assignStudent_success,
		error: ajaxError
		
	});
}
function assignStudent_success(respData)
{
	console.log(respData);
	//$("#newPMember").val("");
	//$("#memberSuggest").hide();
	
//	$("#AssignStudentList").append(
//		"<tr id=\"S" + respData.CWID + "\">" +
	//	"<td class=\"col-md-10\">" + respData.FirstName + " " + respData.LastName + "</td>" +
//		"<td class=\"col-md-2\"><button type=\"button\" value=\""+ respData.CWID +"\">-</button></td></tr>"
	//);
	//$("#pCount").text(1 + parseInt($("#pCount").text()));
}

function unAssignStudent(cwid)
{
	$.ajax({
		type: 'GET',
        url: "UnAssign/" + cwid,
        dataType: "json", 
		success: unAssignStudent_success,
		error: ajaxError
		
	});
}
function unAssignStudent_success(respData)
{
	console.log(respData);
	
	//$("#A" + respData.CWID).remove();
	//$("#pCount").text(parseInt($("#pCount").text()) - 1);
}

function dragLeave(event)
{
	event.preventDefault();  
    event.stopPropagation();
	$(this).removeClass("vDropTarget");
}

function dragOver(event)
{
	event.preventDefault();  
    event.stopPropagation();
	$(this).addClass("vDropTarget");
}

function ajaxError(qXHR, textStatus, errorThrown)
{
	console.log(errorThrown);
	console.log(qXHR);
	alert("Unable to complete action.  Please refresh and try again.");
}

function unQuickViewStudent(e)
{
	$("#quickView").hide();
}


function quickViewStudent(cwid)
{
	//$("#quickView").show();
	$.ajax({
		type: 'get',
        url: "QVStudent/" + cwid,
		dataType: "json",
		success: quickViewStudent_success,
		error: ajaxError
		
	});
}

function quickViewStudent_success(resp)
{
	$("#quickView").show();
	console.log(resp);
	$("#qvName").text(resp.Student.FirstName + " " + resp.Student.LastName);
	$("#qvEMail").text(resp.Student.EMail);
	$("#qvAssigned").text((resp.Assignment)?resp.Assignment.ProjectName: "None");
	$("#qvMajor").text(resp.Student.Major);
	$("#qvMinor").text(resp.Student.Minor);
	$("#qvOtherInfo").text(resp.Student.OtherInfo);
	
	$("#PreProjList").empty();
	for(var v in resp.Projects)
	{
		$("#PreProjList").append(
			"<tr>" +
			"<td>" + resp.Projects[v].pivot.Priority + "</td>" +
			"<td>" + resp.Projects[v].ProjectName + "</td>" +
			"</tr>"
		);
	}
	$("#PrePartList").empty();
	for(var v in resp.Preferred)
	{
		$("#PrePartList").append(
			"<tr>" +
			"<td>" + resp.Preferred[v].FirstName + " " + resp.Preferred[v].LastName + "</td>" +
			"</tr>"
		);
	}
	$("#AvoidPartList").empty();
	for(var v in resp.Avoid)
	{
		$("#AvoidPartList").append(
			"<tr>" +
			"<td>" + resp.Avoid[v].FirstName + " " + resp.Avoid[v].LastName + "</td>" +
			"</tr>"
		);
	}
}





})();