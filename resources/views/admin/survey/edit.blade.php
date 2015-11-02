@extends('admin.layout')
@section('content')
	<h2>Edit Survey</h2>

	{!! Form::model($survey, ['route' => ['admin.surveys.update', $survey->id], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    {!! Form::close() !!}

    <hr>

    <h2>Questions</h2>

    @foreach($survey->questions as $question)
        <p>{{ $question->label }}</p>
    @endforeach

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Add Question</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['admin.surveys.questions.store', $survey->id]]) !!}
                <div class="form-group">
                    {!! Form::label('label') !!}
                    {!! Form::text('label', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::label('field') !!}
                            {!! Form::text('field', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('type') !!}
                            {!! Form::select('type', ['text' => 'text', 'checkbox' => 'checkbox', 'radio' => 'radio', 'select' => 'select'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::label('rules') !!}
                            {!! Form::text('rules', null, ['class' => 'form-control']) !!}
                            <div class="help-block">
                                HINT: Separate multiple <a href="http://laravel.com/docs/5.1/validation" target="_blank">validation rules</a> using the | character (e.g. <code>required|min:3</code>)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection