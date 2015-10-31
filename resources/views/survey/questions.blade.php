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
                @if('checkbox' == $question->type)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox($question->field) !!}
                            {{ $question->label }}
                        </label>
                    </div>
                @else
                    {!! Form::label($question->field, $question->label, ['class' => 'control-label']) !!}
                    @if('select' == $question->type)
                        {!! Form::select($question->field, $question->options, null, ['class' => 'form-control']) !!}
                    @else
                        {!! Form::text($question->field, null, ['class' => 'form-control']) !!}
                    @endif
                @endif
            </div>
        @endforeach

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    {!! Form::close() !!}
@endsection