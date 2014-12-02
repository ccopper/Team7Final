@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
	{{ HTML::script('TeamView.js') }}
@stop
@section('header')

		Team View

@stop
@section('content')
	<div class="row col-md-4 col-md-offset-1" style="height: 600px; overflow-y: scroll;">
		@foreach($projects as $project)
			
			<table class="table table-condensed" pid="{{{$project->id}}}">
				<caption>{{{ $project->Company }}} {{{ $project->ProjectName }}}</caption>
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
	<div class="row col-md-4 col-md-offset-1">
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
@stop