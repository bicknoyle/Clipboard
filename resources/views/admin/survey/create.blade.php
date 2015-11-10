@extends('admin.layout')
@section('content')
    <h2>New Survey</h2>
    {!! Form::open(['route' => 'admin.surveys.store']) !!}
        @include('admin.survey._fields')

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    {!! Form::close() !!}
@endsection