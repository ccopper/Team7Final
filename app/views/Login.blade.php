@extends('master')
@section('header')
	<h2>
		Login
	</h2>
@stop
@section('content')
	<form class=".form-horizontal" action="{{URL::to('/Login')}}" method="post">

	<div class="form-group">
		<label class="col-sm-2 control-label">UserName</label>
		<div class="col-sm-10">
			<input type="text" name="UserName" class="form-control"></input>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Password</label>
		<div class="col-sm-10">
			<input type="text" name="PassWord" class="form-control"></input>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Login</button>
		</div>
	</div>
	</form>

     

    </div>
@stop