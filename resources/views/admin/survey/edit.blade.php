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

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Label</th>
                <th>Field</th>
                <th>Type</th>
                <th>Options</th>
                <th>Required</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach($survey->questions as $question)
            <tr>
                <td>{{ $question->label }}</td>
                <td>{{ $question->field }}</td>
                <td>{{ $question->type }}</td>
                <td>
                    {{ $question->optionsToString() }}
                </td>
                <td>
                    @if($question->isRequired())
                        <i class="fa fa-check"></i>
                    @endif
                </td>
                <td>
                    <a class="btn btn-danger btn-sm"><i class="fa fa-trash"></i><span class="sr-only">Delete Question</span></a>
                </td>
            </tr>
        @endforeach
    </table>

    <h3>Add Question</h3>
    <div class="panel panel-default">
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
                            {!! Form::label('options') !!}
                            {!! Form::text('options', null, ['class' => 'form-control']) !!}
                            <div class="help-block">
                                Comma separated
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('rules[required]') !!}
                            Require this field
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection