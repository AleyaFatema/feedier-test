<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * @desc List of available surveys
     * @api /surveys
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $questionnaires = Questionnaire::with('questions.responses')->get();
        return view('surveys.index', compact('questionnaires'));
    }

    /**
     * @desc All question answers in paginated JSON response
     * @api /api/surveys
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPaginated()
    {
        $questionnaires = Questionnaire::with('questions.responses')
            ->orderBy('id','DESC')
            ->paginate(5);
        return response()->json($questionnaires);
    }

    /**
     * @param Questionnaire $questionnaire
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Questionnaire $questionnaire, $slug)
    {
        $questionnaire->load('questions.answers');
        return view('surveys.show', compact('questionnaire'));
    }

    /**
     * Save Survey response to database
     * @param Questionnaire $questionnaire
     * @return string
     */

    public function store(Questionnaire $questionnaire)
    {
        /*$request = request()->all();
        foreach($request['question']  as $key => $value) {
            if($value['type']==3 || $value['type']==4) {
                if($value['is_required'] == 0) {
                    $request['responses'][$key]['answer_id'] = null;
                }
            }
            else {
                if($value['is_required'] == 0) {
                    $request['responses'][$key]['responses'] = null;
                }
            }
        }*/

        $data = request()->validate([
            'responses.*.question_id' => 'required|integer',
            'responses.*.answer_id' => 'sometimes|required_without:responses.*.responses|required_if:question.*.type,==,3|required_if:question.*.type,==,4|integer',
            'responses.*.responses' => 'sometimes|required_without:responses.*.answer_id|required_if:question.*.type,==,1|required_if:question.*.type,==,2|string',
            'survey.name' => 'required',
            'survey.email' => 'required|email',
        ], [
            'responses.*.question_id.required' => 'Invalid question',
            'responses.*.question_id.integer' => 'Invalid question',

            'responses.*.answer_id.required_without:responses.*.responses' => 'Please choose your answer.',
            'responses.*.answer_id.required_if:question.*.type,==,3' => 'Please choose your answer.',
            'responses.*.answer_id.required_if:question.*.type,==,4' => 'Please choose your answer.',
            'responses.*.answer_id.integer' => 'Invalid answer options.',

            'responses.*.responses.required_without:responses.*.answer_id' => 'Please give your answer',
            'responses.*.responses.required_if:question.*.type,==,1' => 'Please give your answer',
            'responses.*.responses.required_if:question.*.type,==,2' => 'Please give your answer',
            'responses.*.responses.string' => 'Please give your answer',

            'survey.name.required' => 'Please enter your name',
            'survey.email.required' => 'Please enter you email address',
            'survey.email.email' => 'Please enter valid email address',
        ]);

        $message = '';
        $status = '';
        DB::beginTransaction();
        try {
            $survey = $questionnaire->surveys()->create($data['survey']);
            $survey->responses()->createMany($data['responses']);

            DB::commit();
            $status = 200;
            $message = 'Thank you for your valuable time. Have a good day.';
        } catch (\Exception $exception) {
            DB::rollBack();
            $status = 500;
            $message = 'Could not complete the process. Please try again later.';

        }

        return redirect('/surveys')->with([
            'status' => $status,
            'message' => $message,
        ]);
    }

}
