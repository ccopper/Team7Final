@extends('master')
@section('include')
	<link rel="stylesheet" href="StudentInfo.css">
	<script src="StudentInfo.js"></script>
@stop
@section('header')
	<h2>
		Student Infomation
	</h2>
@stop
@section('content')
	<span id="CWID" style="display: none">{{{ $student->CWID }}}</span>
	
	<div class="row">
		<div class="col-md-3">
			<div class="alert alert-danger" role="alert" style="display:none" id="UnsavedAlert">
				<span id="unsavedAlert" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only"></span>
				Unsaved Changes
			</div>
			<form class=".form-horizontal" action="{{URL::to('/Login')}}" method="post">
			<h3>{{{ $student->FirstName }}} {{{ $student->LastName }}}</h3>
			<br>
			{{{ $student->EMail }}}
			<br><br>
			Major: <input id="majInp" type="text" name="Major" class="form-control" value="{{{ $student->Major }}}"></input>
			<br>
			Minor: <input id="minInp" type="text" name="Minor" class="form-control" value="{{{ $student->Minor }}}"></input>
			<br>
			Additional Information:
			<br>
			<textarea id="oiInp" name="OtherInfo" class="form-control">
			{{{ $student->OtherInfo }}}
			</textarea>
			</form>
		</div>
		<div class="col-md-4">
			<table class="table table-condensed">
			
				<caption>Preferred Partners</caption>
				<tbody id="PrePartList">
					@foreach($student->PrePartners as $pp)
						<tr id="P{{{ $pp->CWID }}}">
							<td class="col-md-10">{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
							<td class="col-md-2">
								<button type="button" class="btn btn-primary" value="{{{ $pp->CWID }}}">-</button>
							</td>
						<tr>
					@endforeach
				</tbody>
				
			</table>
			<div class="row">

				<input id="newPre" type="text" name="NewPre" class="form-control"></input>
				<div id="PreferSuggest" class="SuggestList">
					<ul id="PreferSuggestUL" class="list-unstyled" style="margin: 10px"></ul>
				</div>
			</div>
			<br>
			<table class="table table-condensed">
				<caption>Avoid Partners</caption>
				<tbody id="AvoidPartList">
					@foreach($student->AvoidPartners as $pp)
						<tr id="A{{{ $pp->CWID }}}">
							<td class="col-md-10">{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
							<td class="col-md-2">
								<button type="button" class="btn btn-primary" value="{{{ $pp->CWID }}}">-</button>
							</td>
						<tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">

				<input id="newAvoid" type="text" name="newAvoid" class="form-control"></input>
				<div id="AvoidSuggest" class="SuggestList" >
					<ul class="list-unstyled" style="margin: 10px"></ul>
				</div>
			</div>
			
		</div>
		<div class="col-md-5">
			<table class="table">
				<caption>Preferred Projects</caption>
				<tbody id="PreProjList">
					@foreach($student->Projects as $pp)
						<tr><td>{{{ $pp->Company }}} {{{ $pp->ProjectName }}}</td><tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-10">
					<input type="text" name="NewAvoid" class="form-control"></input>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-primary" id="addAvoid">Add</button>
				</div>
			</div>
			<div class="radio">
				<label>
					<input id="ppInp1" type="radio" name="PreferProjects" value="0" {{{ (($student->PreferProjects == 0)? "checked": "") }}}>
					Prefer to work with listed partners
				</label>
			</div>
			<div class="radio">
				<label>
					<input id="ppInp2" type="radio" name="PreferProjects" value="1" {{{ (($student->PreferProjects == 1)? "checked": "") }}}>
					Prefer to work on listed projects
				</label>
			</div>
			
			
		</div>
	</div>
@stop