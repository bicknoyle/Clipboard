@extends('admin.layout')
@section('content')
    <div id="add-question" tabindex="-1" role="dialog" class="modal fade">
        {!! Form::open(['route' => ['admin.surveys.questions.store', $survey->id], 'class' => 'modal-dialog']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Question</h4>
                </div>
                <div class="modal-body">
                    @if($errors->hasBag('question'))
                        <div class="alert alert-danger">
                            <p><strong>Uh-oh!</strong> There was a problem with your submission:</p>
                            <ul>
                                @foreach($errors->question->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div><!-- /.modal-content -->
        {!! Form::close() !!}<!-- /.modal-dialog -->
    </div><!-- /.modal -->

	<h2>Edit Survey</h2>

	{!! Form::model($survey, ['route' => ['admin.surveys.update', $survey->id], 'method' => 'put']) !!}
        @include('admin.survey._fields')

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>

            <a class="btn btn-default" href="{{ route('admin.surveys.edit', ['id' => $survey->id]) }}">Reset</a>
        </div>
    {!! Form::close() !!}

    <hr>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Questions</h3>
        </div>
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
                        {!! Form::open(['route' => ['admin.surveys.questions.destroy', $survey->id, $question->id], 'method' => 'delete']) !!}
                            <button class="confirm-delete btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i><span class="sr-only">Delete Question Id:{{ $question->id }}</span></button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add-question">
        <i class="fa fa-plus"></i> Add Question
    </button>

    <hr>

    {!! Form::open(['route' => ['admin.surveys.destroy', $survey->id], 'method' => 'delete']) !!}
        <div class="form-group">
            <button class="confirm-delete btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete Survey</button>
        </div>
    {!! Form::close() !!}
@endsection
@section('js')
    @parent
    @if($errors->hasBag('question'))
        <script>
            $('#add-question').modal('show');
        </script>
    @endif
    <script>
        $('.confirm-delete').on('click', function (e) {
            var confirmed = confirm("Are you sure you want to delete this?");
            if (!confirmed) {
                e.preventDefault();
            }
        });
    </script>
    <script>
        function setOptionsProp () {
            var type = $('#type').val()
              , disabled = false
            ;

            if ('text' == type || 'checkbox' == type) {
                disabled = true;
            }
            $('#options').prop('disabled', disabled)
        }

        $(document).ready(function () { setOptionsProp() });
        $('#type').on('change', setOptionsProp);
    </script>
@endsection