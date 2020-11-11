<?php

namespace App\Http\Controllers;

use App\Question;
use App\Questionnaire;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * @desc Shows the question entry form
     * @param Questionnaire $questionnaire
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Questionnaire $questionnaire)
    {
        return view('question.create', compact('questionnaire'));
    }

    /**
     * @desc Stores the question and related answers to DB
     * @param Questionnaire $questionnaire
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Questionnaire $questionnaire)
    {
        // validate inputs
        $validator = Validator::make(request()->input(), [
            'question.question' => 'required|max:200',
            'question.type' => 'required|integer|between:1,4',
            'question.type_count' => 'required_if:question.type,3|required_if:question.type,4|integer|between:2,3',
            'answers.*.answer' => 'required_if:question.type,3|required_if:question.type,4|max:255',

        ], [
            'answers.*.answer.required' => 'The answer field is required.',
            'answers.*.answer.max' => 'Please limit your answer to 255 characters.',
            'question.type'=>'Answer type must be from the list.',
            'question.type_count'=>'Answer type must be from the list.',
        ]);

        // if validation fails redirect with custom error messages
        if ($validator->fails()) {
            return redirect('/questionnaires/' . $questionnaire->id . '/questions/create')
                ->withErrors($validator)
                ->withInput();
        }

        // first create question
        $question = $questionnaire->questions()->create(request()->input()['question']);
        // check if it is checkbox or radio button type question
        $type = request('question.type');
        if($type == 3 || $type == 4) {
            // save answers through relationship
            $question->answers()->createMany(request()->input()['answers']);
        }

        return redirect('/questionnaires/' . $questionnaire->id);
    }

    /**
     * @desc This function is not implemented
     * @param Questionnaire $questionnaire
     * @param Question $question
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Questionnaire $questionnaire, Question $question) {
        $question->load('answers');
        return view('question.edit', compact('questionnaire','question'));
    }

    /**
     * @desc This function is not implemented
     * @param Questionnaire $questionnaire
     * @param Question $question
     */
    public function update(Questionnaire $questionnaire, Question $question) {
        $question_id = $question->id;
        $questionnaire_id = $questionnaire->id;
        dump(request()->input());
        // validate inputs
        $validator = Validator::make(request()->input(), [
            'question.question' => 'required',
            'answers.*.answer.*' => 'required|max:25',
        ], [
            'answers.*.answer.*.required' => 'The answer field is required.',
            'answers.*.answer.*.max' => 'Please limit your answer to 255 characters.'
        ]);
        dump($validator->errors());
    }

    /**
     * @desc Deletes a question
     * @param Questionnaire $questionnaire
     * @param Question $question
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Questionnaire $questionnaire, Question $question)
    {
        if($question->type == 3 || $question->type == 4) {
            $question->answers()->delete();
        }
        $question->delete();
        return redirect($questionnaire->path())
            ->with('success', 'Question is deleted successfully!');
    }
}
