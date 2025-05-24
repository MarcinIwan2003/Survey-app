<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $surveys = Survey::all();
        return view('results.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        $survey->load('questions.options');

        $questionStats = $survey->questions->map(function ($question) {
            $totalAnswers = QuizAnswer::where('question_id', $question->id)->count();
            $correctAnswers = QuizAnswer::where('question_id', $question->id)
                ->whereHas('option', fn($q) => $q->where('is_correct', true))
                ->count();

            $percent = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 2) : 0;

            return [
                'text' => $question->text,
                'total' => $totalAnswers,
                'correct' => $correctAnswers,
                'percent' => $percent,
                'options' => $question->options->map(fn($o) => [
                    'text' => $o->text,
                    'is_correct' => $o->is_correct,
                    'count' => QuizAnswer::where('question_id', $question->id)
                        ->where('option_id', $o->id)->count(),
                ])
            ];
        });

        $overallTotal = $questionStats->sum('total');
        $overallCorrect = $questionStats->sum('correct');
        $averagePercent = $questionStats->count() > 0
            ? round($questionStats->avg('percent'), 2)
            : 0;

        $mostKnown = $questionStats->sortByDesc('percent')->first();
        $leastKnown = $questionStats->sortBy('percent')->first();

        return view('results.show', compact(
            'survey',
            'questionStats',
            'overallTotal',
            'overallCorrect',
            'averagePercent',
            'mostKnown',
            'leastKnown'
        ));
    }
}
