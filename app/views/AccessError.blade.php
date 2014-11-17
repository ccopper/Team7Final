@extends('master')
@section('header')
	<h2>
		Permission Denied
	</h2>
@stop
@section('content')
	<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		The credentials provided were invalid or you do not have permission to access this page.
	</div>
	<a style="cursor:pointer" onclick="history.go(-1)">Go Back</a>
@stop