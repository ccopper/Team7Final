@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
@stop
@section('header')
	<h2>
		Team View
	</h2>
@stop
@section('content')
	<div class="row col-md-4 col-md-offset-2">
		@foreach($projects as $project)
			@if($project->AssignedStudents->count() > 0)
			<table class="table table-condensed">
				<caption>{{{ $project->Company }}} {{{ $project->ProjectName }}}</caption>
				<tbody>
					@foreach($project->AssignedStudents as $pp)
						<tr id="A{{{ $pp->CWID }}}">
							<td>{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
						<tr>
					@endforeach
				</tbody>
			</table>	
			@endif
		@endforeach
	</div>	
@stop