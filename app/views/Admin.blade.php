@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
	{{ HTML::script('Admin.js') }}
@stop
@section('header')
	<h2>
		Administration
	</h2>
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
					<a href="{{URL::to('/TeamView')}}">View Current Teams</a>
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