@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
	{{ HTML::script('Project.js') }}
@stop
@section('header')
	
	Project Info
	
@stop
@section('content')
	<span id="ProjectID" style="display: none">{{{ $project->id }}}</span>
	<div class="row">
		<div class="col-md-4">
			<b>{{{ $project->ProjectName }}}</b>
			<br><br>
			{{{ $project->Company }}}
			<br><br>
			Project Capacity:
			<br>
			<h3>
			<span id="pCount">{{{ $project->AssignedStudents->count() }}}</span> / {{{ $project->MaxStudents }}} (Min {{{ $project->MinStudents }}} )</h3>
		</div>
		<div class="col-md-4">
			<table class="table table-condensed">
				<caption>Assigned Students</caption>
				<tbody id="AssignStudentList">
					@foreach($project->AssignedStudents as $pp)
						<tr id="A{{{ $pp->CWID }}}">
							<td class="col-md-10">{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
							<td class="col-md-2" style="{{{ (Auth::user()->PermissionLevel < 2)? 'visibility:hidden': '' }}}">
								<button type="button" value="{{{ $pp->CWID }}}">-</button>
							</td>
						<tr>
					@endforeach
				</tbody>
			</table>
			<div class="row" style="{{{ (Auth::user()->PermissionLevel < 2)? 'display:none': '' }}}">
				<input id="newPMember" type="text" name="NewPre" class="form-control"></input>
				<div id="memberSuggest" class="suggestList">
					<ul id="memberSuggest" class="list-unstyled" style="margin: 10px"></ul>
				</div>
			</div>
		</div>
	</div>
@stop
