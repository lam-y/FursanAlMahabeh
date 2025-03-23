@php
    $answers = $entry->answers;
@endphp

@if ($answers->count() > 0)
    <div class="answers-container">
        @foreach($answers as $answer)
            <div class="question-answer">
                <strong>السؤال:</strong> {{ $answer->question->text }} <br>
                <strong>الإجابة:</strong> {{ $answer->text }} <br><br>
            </div>
        @endforeach
    </div>
@else
    <p>لا توجد إجابات لعرضها.</p>
@endif
