@extends('survey.layout')
@section('title')
    {{ $survey->name }}
@endsection
@section('content')
    <h2>{{ $survey->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <p><strong>Uh-oh!</strong> There was a problem with your submission:</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open() !!}
        @foreach($survey->questions as $question)
            <div class="form-group">
                @if($question->isType('checkbox'))
                    @include('survey._checkbox', $question)
                @elseif($question->isType('radio'))
                    @include('survey._radio', $question)
                @elseif($question->isType('select'))
                    @include('survey._select', $question)
                @else
                    @include('survey._text', $question)
                @endif
            </div>
        @endforeach

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    {!! Form::close() !!}
@endsection