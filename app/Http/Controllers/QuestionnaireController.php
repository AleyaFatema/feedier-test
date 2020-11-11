<?php

namespace App\Http\Controllers;

use App\Question;
use App\Questionnaire;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class QuestionnaireController extends Controller
{
    /**
     * QuestionnaireController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('questionnaire.create');
    }

    /**
     * Creates Questionnaire in DB
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        // Validates the form data
        $data = request()->validate([
            'title' => 'required',
            'purpose' => 'required',
            'active_at' => 'required|date|after:yesterday|before_or_equal:inactive_at',
            'inactive_at' => 'required|date||after_or_equal:active_at',
        ],[
            'active_at.required' => 'Date from field is required',
            'active_at.date' => 'Date from field must be a date',
            'active_at.after' => 'Date from field must be today\'s date or future date',
            'active_at.before_or_equal' => 'Date from field must be equal or previous date than Date to',

            'inactive_at.required' => 'Date to field is required',
            'inactive_at.date' => 'Date to field must be a date',
            'inactive_at.after_or_equal' => 'Date to field must be equal or future date than Date from',
        ]);

        $questionnaire = auth()->user()->questionnaires()->create($data);
        return redirect('/questionnaires/' . $questionnaire->id);
    }

    /**
     * Show Questionnaire
     * @param Questionnaire $questionnaire
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Questionnaire $questionnaire)
    {
        $questionnaire->load('questions.answers.responses');

        return view('questionnaire.show', compact('questionnaire'));
    }


    /**
     * Returns paginated list of questionnaire, question and answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $questionnaire = Questionnaire::with('questions.answers')
            ->orderBy('id','DESC')
            ->paginate(5);

        return response()->json($questionnaire, 200);
    }

}
