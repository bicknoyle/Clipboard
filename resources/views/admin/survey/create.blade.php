@extends('admin.layout')
@section('content')
    <h2>Create Survey</h2>
    {!! Form::open(['route' => 'admin.surveys.store']) !!}
        <div class="form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    {!! Form::close() !!}
@endsection