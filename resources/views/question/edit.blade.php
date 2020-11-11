@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <strong>Questionnaire:</strong> {{$questionnaire->title}}
                    </div>
                    <div class="card-body">
                        {{ $questionnaire->purpose }}
                        {{--{{ dump($question->answers) }}--}}
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header font-weight-bold">Update Question</div>
                    <div class="card-body">
                        <form action="/questionnaires/{{ $questionnaire->id }}/questions/{{ $question->id }}" method="post">
                            @method('PATCH')
                            @csrf

                            <div class="form-group">
                                <label for="question"><strong>Question</strong></label>
                                <input type="text" class="form-control" name="question[question]" id="question"
                                       value="{{ old('question.question') ?? $question->question }}"
                                       aria-describedby="questionHelp" autocomplete="off"
                                       placeholder="Enter Question">
                                <small id="questionHelp" class="form-text text-muted">Ask simple and to-the-point
                                    question for help
                                </small>

                                @error('question.question')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <fieldset>
                                    <legend>Choices</legend>
                                    <small id="choicesHelp" class="form-text text-muted">Give choices that give you the
                                        most insight into your question
                                    </small>
                                    <div>
                                        <div class="form-group">
                                            <label for="answer1">Choice 1</label>
                                            <input type="text" class="form-control" name="answers[][answer][{{$question->answers[0]['id']}}]}}]"
                                                   value="{{ old('answers.0.answer') ?? $question->answers[0]['answer']}}" autocomplete="off"
                                                   id="answer1" aria-describedby="choicesHelp"
                                                   placeholder="Enter Choice 1">

                                            @error('answers.0.answer')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="answer2">Choice 2</label>
                                            <input type="text" class="form-control" name="answers[][answer][{{$question->answers[1]['id']}}"
                                                   value="{{ old('answers.1.answer') ?? $question->answers[1]['answer']}}" autocomplete="off"
                                                   id="answer2" aria-describedby="choicesHelp"
                                                   placeholder="Enter Choice 2">


                                            @error('answers.1.answer')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="answer3">Choice 3</label>
                                            <input type="text" class="form-control" name="answers[][answer][{{$question->answers[2]['id']}}"
                                                   value="{{ old('answers.2.answer') ?? $question->answers[2]['answer'] }}" autocomplete="off"
                                                   id="answer3" aria-describedby="choicesHelp"
                                                   placeholder="Enter Choice 3">


                                            @error('answers.2.answer')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="answer4">Choice 4</label>
                                            <input type="text" class="form-control" name="answers[][answer][{{$question->answers[3]['id']}}"
                                                   value="{{ old('answers.3.answer') ?? $question->answers[3]['answer'] }}" autocomplete="off"
                                                   id="answer4" aria-describedby="choicesHelp"
                                                   placeholder="Enter Choice 4">


                                            @error('answers.3.answer')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                </fieldset>

                            </div>

                            <button type="submit" class="btn btn-primary">Update Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
