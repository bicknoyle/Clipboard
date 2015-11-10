@extends('survey.layout')
@section('title')
	Available Surveys | Clipboard
@endsection
@section('content')
	<h2>Available Surveys</h2>

	<hr>

	<ul class="list-unstyled survey-list">
		@foreach($surveys as $survey)
			<li>
				<a href="{{ action('SurveyController@getSurvey', ['id' => $survey->id]) }}"><strong>{{ $survey->name }}</strong></a><br>
				{{ $survey->description }}
			</li>
		@endforeach
	</ul>

	<hr>

	<p class="text-right">
		@include('survey._poweredBy')
    </p>
@endsection