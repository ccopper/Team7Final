@extends('master')
@section('header')
	<h2>
		Student Infomation
	</h2>
@stop
@section('content')
<form class=".form-horizontal" action="{{URL::to('/Login')}}" method="post">
	<div class="row">
		<div class="col-md-3">
			<h3>{{{ $student->FirstName }}} {{{ $student->LastName }}}</h3>
			<br>
			{{{ $student->EMail }}}
			<br><br>
			Major: <input type="text" name="Major" class="form-control">{{{ $student->Major }}}</input>
			<br>
			Minor: <input type="text" name="Major" class="form-control">{{{ $student->Minor }}}</input>
			<br>
			Additional Information:
			<br>
			<textarea name="Quote" class="form-control">
			{{{ $student->OtherInfo }}}
			</textarea>
			
		</div>
		<div class="col-md-4" style="border:1px solid black">
			<table class="table">
				<caption>Preferred Partners</caption>
				<tbody id="PrePartList">
					@foreach($genres as $genre)
						<option value="{{{$genre->id}}}">{{{$genre->Name}}}</option>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-5" style="border:1px solid black">
			Preferred Projects:
		</div>
	</div>

</form>	
	
	

@stop