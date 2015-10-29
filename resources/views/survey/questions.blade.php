@extends('survey.layout')
@section('title')
    {{ $survey->name }}
@endsection
@section('content')
    <h2>{{ $survey->name }}</h2>

    {!! Form::open() !!}
        @foreach($survey->questions as $question)
            <div class="form-group">
                {!! Form::label($question->field, $question->label, ['class' => 'control-label']) !!}
                {!! Form::text($question->field, null, ['class' => 'form-control']) !!}
            </div>
        @endforeach

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    {!! Form::close() !!}
@endsection