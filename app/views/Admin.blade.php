@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
	{{ HTML::script('Admin.js') }}
@stop
@section('header')

	Administration

@stop
@section('content')

	
	<div class="row">
		<div class="col-md-4">
		<form class=".form-horizontal" action="{{URL::to('/Admin/StudentFile')}}" method="post" enctype="multipart/form-data"> 
			<div class="row">
				Student CSV Upload:
				<input id="studentFile" type="file" name="studentFile" class="form-control">
			</div>
			<br><br>
			<div class="row">
				Project CSV Upload:
				<input id="projectFile" type="file" name="projectFile" class="form-control">
			</div>

			<br><br>
			<div class="row">
				Group Assignments:<br>
				<div class="col-md-6 col-md-offset-3">
					<a href="{{URL::to('/Project/TeamView')}}">View Current Teams</a>
				</div>
				<br>
				<div class="col-md-8 col-md-offset-2">
					<button type="button" class="btn btn-primary" id="genAssign">Generate Assignments</button>
				</div>
			</div>
		</form>
		</div>
		<div class="col-md-3">
			Student List:
			<select class="form-control" id="studentList" size="11">
				@foreach($students as $s)
				<option class="{{{ (isset($s->ProjectID))? '': 'unassigned' }}}" value="{{{ $s->CWID }}}">{{{ $s->FirstName }}} {{{ $s->LastName }}}</option>
				@endforeach
			</select>
			<br>
			<div class="row col-md-4 col-md-offset-4">
					<button type="button" class="btn btn-primary" id="studentView">View Student</button>
			</div>
			<br><br>
			<div id="quickView" class='quickView row'>
				<b><span id="qvName"></span></b><br>
				<span id="qvEMail"></span><br>
				Assigned To: <span id="qvAssigned"> </span><br>
				Major:<span id="qvMajor"></span><br>
				Minor:<span id="qvMinor"></span><br>
				OtherInfo: <span id="qvOtherInfo"></span><br>
				
				<table class="table table-condensed">
					<caption>Preferred Projects</caption>
					<tbody id="PreProjList">
	
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-5">
			Project List:
			<select class="form-control" id="projectList" size="11">
				@foreach($projects as $pp)
				<option value="{{{ $pp->id }}}">{{{ $pp->Company }}} {{{ $pp->ProjectName }}}</option>
				@endforeach
			</select>
			<br>
			<div class="row col-md-4 col-md-offset-4">
					<button type="button" class="btn btn-primary" id="projectView">View Project</button>
			</div>
		</div>
	</div>

@stop