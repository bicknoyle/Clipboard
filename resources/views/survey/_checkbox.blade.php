<div class="checkbox">
    <label>
        {!! Form::checkbox($question->field) !!}
        {{ $question->label }}
        @if($question->isRequired())
            @include('survey._required_asterisk')
        @endif
    </label>
</div>