@extends('admin.layout')
@section('content')
	<h2>Admin</h2>

	<a class="btn btn-success" href="{{ action('Admin\SurveyController@create') }}">Create Survey</a>
@endsection