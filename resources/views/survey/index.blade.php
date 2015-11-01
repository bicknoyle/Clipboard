@extends('survey.layout')
@section('content')
	<h2>Available Surveys</h2>
	<ul class="list-unstyled">
		@foreach($surveys as $survey)
			<li>
				<a href="{{ action('SurveyController@getSurvey', ['id' => $survey->id]) }}">{{ $survey->name }}</a>
			</li>
		@endforeach
	</ul>
@endsection