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
	
	$("table").on("drop", drop);
});


function dragStart()
{
	dragEle = $(this);
	
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

})();