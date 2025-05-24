<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        // Pobierz ankiety przypisane do zalogowanego użytkownika
        $surveys = Auth::user()->surveys()->latest()->get();

        // Przekaż dane do widoku
        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        

        // Załaduj pytania i opcje
        $survey->load('questions.options');

        // Przekaż dane do widoku
        return view('surveys.show', compact('survey'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
        ]);

        // Generuj unikalny 6-cyfrowy kod
        do {
            $code = random_int(100000, 999999);
        } while (Survey::where('code', $code)->exists());

        // Tworzenie ankiety
        $survey = Survey::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'code' => $code,
        ]);

        // Tworzenie pytań i opcji
        foreach ($request->input('questions') as $q) {
            $question = $survey->questions()->create([
                'text' => $q['text'],
                'type' => $q['type'],
                'read_time' => $q['read_time'],
                'answer_time' => $q['answer_time'],
                'explanation' => $q['explanation'] ?? null,
            ]);

            foreach ($q['options'] as $index => $opt) {
                $question->options()->create([
                    'text' => $opt['text'],
                    'is_correct' => (int) $q['correct'] === $index,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('status', 'Ankieta została zapisana.');
    }
}