{!! Form::label($question->field, $question->label, ['class' => 'control-label']) !!}
@if($question->isRequired())
    @include('survey._required_asterisk')
@endif
{!! Form::select($question->field, array_combine($question->options, $question->options), null, ['class' => 'form-control']) !!}