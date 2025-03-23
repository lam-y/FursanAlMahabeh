<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use App\Models\Evaluation;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function getQuestions($form_id, $member_id)
    {
        $evaluation = Evaluation::where('form_id', $form_id)
                            ->where('member_id', $member_id)
                            ->first();

        $questions = Question::where('form_id', $form_id)->get();

        $answers = $evaluation ? $evaluation->answers->keyBy('question_id') : collect([]);

        $questionsWithAnswers = $questions->map(function ($question) use ($evaluation) {
            $answer = $evaluation ? $evaluation->answers()->where('question_id', $question->id)->first() : null;
            return [
                'id' => $question->id,
                'text' => $question->text,
                'answer' => $answer ? $answer->text : ''
            ];
        });

        return response()->json(['questions' => $questionsWithAnswers]);


    }
}
