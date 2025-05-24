<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\QuizSession;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;

class QuizSessionController extends Controller
{
    public function start(Request $request)
{
    $request->validate([
        'nickname' => 'required|string|max:50',
        'code' => 'required|string',
    ]);

    $survey = Survey::where('code', $request->code)->firstOrFail();

    $exists = QuizSession::where('survey_id', $survey->id)
        ->where('nickname', $request->nickname)
        ->exists();

    if ($exists) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nick już zajęty dla tej ankiety.');
    }

    $session = QuizSession::create([
        'survey_id' => $survey->id,
        'nickname' => $request->nickname,
        'current_question_index' => 0,
    ]);

    return redirect()->route('quiz.play', $session); // ⬅️ ważne!
}

    public function play(QuizSession $session)
    {
        $questions = $session->survey->questions()->with('options')->get();

        if ($session->current_question_index >= $questions->count()) {
            return redirect()->route('quiz.summary', $session);
        }
        

        $question = $questions[$session->current_question_index];

        return view('quiz.play', compact('session', 'question'));
    }

    public function answer(Request $request, QuizSession $session)
{
    $questions = $session->survey->questions()->get();
    $question = $questions[$session->current_question_index];

    // Jeśli użytkownik odpowiedział, zapisujemy odpowiedź
    if ($request->filled('option_id')) {
        $request->validate([
            'option_id' => 'exists:question_options,id',
        ]);

        QuizAnswer::create([
            'quiz_session_id' => $session->id,
            'question_id' => $question->id,
            'option_id' => $request->option_id,
            'answered_at' => now(),
        ]);
    }

    // Przejście do następnego pytania niezależnie od odpowiedzi
    $session->increment('current_question_index');

    return redirect()->route('quiz.play', $session);
}


    public function summary(QuizSession $session)
{
    $survey = $session->survey;

    // Pobierz wszystkie pytania z opcjami
    $questions = $survey->questions()->with('options')->get();

    // Pobierz odpowiedzi użytkownika
    $answers = $session->answers()->get()->keyBy('question_id');

    return view('quiz.summary', compact('session', 'questions', 'answers'));
}

}
