{!! Form::label($question->field, $question->label, ['class' => 'control-label']) !!}
@if($question->isRequired())
    @include('survey._required_asterisk')
@endif
{!! Form::text($question->field, null, ['class' => 'form-control']) !!}
