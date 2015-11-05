<label>{{ $question->label }}</label>
@if($question->isRequired())
    @include('survey._required_asterisk')
@endif
@foreach($question->options as $option)
    <div class="radio">
        <label>
            {!! Form::radio($question->field, $option) !!}
            {{ $option }}
        </label>
    </div>
@endforeach