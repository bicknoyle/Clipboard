{!! Form::label($question->field, $question->label, ['class' => 'control-label']) !!}
{!! Form::select($question->field, $question->options, null, ['class' => 'form-control']) !!}