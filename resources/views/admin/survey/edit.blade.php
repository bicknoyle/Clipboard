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
@endsection