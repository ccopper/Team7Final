@extends('master')
@section('include')
	{{ HTML::style('Style.css') }}
    {{ HTML::script('StudentInfo.js') }}
	@if(Auth::user()->PermissionLevel >= 2)
	<script>
		$("form").ready(function()
		{
			$('input').prop("disabled", true);
			$('textarea').prop("disabled", true);
			$('select').prop("disabled", true);
		});
	</script>
	@endif
@stop
@section('header')
	Student Infomation
@stop
@section('content')
	<span id="CWID" style="display: none">{{{ $student->CWID }}}</span>

	<div class="row">
		<div class="col-md-3">
			<form class=".form-horizontal" action="{{URL::to('/Login')}}" method="post">
			<h3>{{{ $student->FirstName }}} {{{ $student->LastName }}}</h3>
			<br>
			{{{ $student->EMail }}}
			<br><br>
			Assigned Project:
			<br>			
			@if(isset($student->Assignment->id))
				<a href="{{URL::to('/Project/' . $student->Assignment->id) }} "> {{{ $student->Assignment->ProjectName }}}</a>
			@else
				None
			@endif
			<br>
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
			<div class="alert alert-danger" role="alert" style="display:none" id="UnsavedAlert">
				<span id="unsavedAlert" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only"></span>
				Unsaved Changes
			</div>
		</div>
		<div class="col-md-4">
			<table class="table table-condensed">
			
				<caption>Preferred Partners</caption>
				<tbody id="PrePartList">
					@foreach($student->PrePartners as $pp)
						<tr id="P{{{ $pp->CWID }}}">
							<td class="col-md-10">{{{ $pp->FirstName }}} {{{ $pp->LastName }}}</td>
							<td class="col-md-2">
								<button type="button" value="{{{ $pp->CWID }}}">-</button>
							</td>
						<tr>
					@endforeach
				</tbody>
				
			</table>
			<div class="row">

				<input id="newPre" type="text" name="NewPre" class="form-control"></input>
				<div id="PreferSuggest" class="suggestList">
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
								<button type="button" value="{{{ $pp->CWID }}}">-</button>
							</td>
						<tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">

				<input id="newAvoid" type="text" name="newAvoid" class="form-control"></input>
				<div id="AvoidSuggest" class="suggestList" >
					<ul class="list-unstyled" style="margin: 10px"></ul>
				</div>
			</div>
			
		</div>
		<div class="col-md-5">
			
			<table class="table table-condensed">
				<caption>Preferred Projects</caption>
				<tbody id="PreProjList">
					@foreach($student->ProjectSelections as $pp)
						<tr>
							<td class="col-md-2">{{{ $pp->pivot->Priority }}}</td>
							<td class="col-md-10">{{{ $pp->Company }}} {{{ $pp->ProjectName }}}</td>
							<!--<td class="col-md-2"><button type="button" value="{{{ $pp->ProjectID}}}">-</button></td>-->
							<tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-10">
					<select id="newProjID" name="newProj" class="form-control">
					@foreach($projects as $pp)
						<option value="{{{ $pp->id }}}">{{{ $pp->Company }}} {{{ $pp->ProjectName }}}</option>
					@endforeach
					</select>
				</div>
				<div class="col-md-2">
					<input type="number" id="newProjPri" name="Priority" class="form-control" min="1" max="4" value="1"></input>
				</div>

			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-5">
					<button type="button" class="btn btn-primary" id="addProject">Add</button>
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
			<div class="radio">
				<label>
					<input id="ppInp3" type="radio" name="PreferProjects" value="2" {{{ (($student->PreferProjects == 2)? "checked": "") }}}>
					No Preference
				</label>
			</div>
			
			
		</div>
	</div>
@stop