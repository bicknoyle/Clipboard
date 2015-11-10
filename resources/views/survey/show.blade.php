@extends('survey.layout')
@section('title')
    {{ $survey->name }}
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="page-header">
                <h2>{{ $survey->name }}</h2>
                <p class="lead text-muted">{{ $survey->description }}</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <h4><i class="fa fa-exclamation-triangle"></i> Uh-oh!</h4>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="text-muted">* Required</p>
            <br>

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

                <hr>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="panel-footer text-right">
            @include('survey._poweredBy')
        </div>
    </div>
@endsection