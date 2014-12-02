@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
	{{ HTML::script('TeamView.js') }}
@stop
@section('header')

		Team View

@stop
@section('content')
	<div class="col-md-4 col-md-offset-1" style="height: 600px; overflow-y: scroll;">
		@foreach($projects as $project)
			
			<table class="table table-condensed" pid="{{{$project->id}}}">
				<caption>{{{ $project->Company }}} {{{ $project->ProjectName }}} <b>MAX:{{{ $project->MaxStudents}}}</b></caption>
				<tbody>
					@foreach($project->AssignedStudents as $pp)
						<tr id="{{{ $pp->CWID }}}" draggable="true">
							<td>{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
						<tr>
					@endforeach
				</tbody>
			</table>	
			
		@endforeach
	</div>
	<div class="col-md-4 col-md-offset-1">
		<table class="table table-condensed" id="unassignTable">
			<caption>Unassigned Students</caption>
			<tbody>
				@foreach(Student::whereNull("ProjectID")->get() as $pp)
					<tr id="{{{ $pp->CWID }}}" draggable="true">
						<td>{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
					<tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-3 col-md-offset-1">
		<div id="quickView" class='quickView row'>
			<b><span id="qvName"></span></b><br>
			<span id="qvEMail"></span><br>
			Assigned To: <span id="qvAssigned"> </span><br>
			Major:<span id="qvMajor"></span><br>
			Minor:<span id="qvMinor"></span><br>
			OtherInfo: <span id="qvOtherInfo"></span><br>
				
			<table class="table table-condensed">
				<caption>Preferred Projects</caption>
				<tbody id="PreProjList"></tbody>
			</table>
			<table class="table table-condensed">
				<caption>Preferred Partners</caption>
				<tbody id="PrePartList"></tbody>
			</table>
			<table class="table table-condensed">
				<caption>Avoid Partners</caption>
				<tbody id="AvoidPartList"></tbody>
			</table>
		</div>
	</div>
@stop