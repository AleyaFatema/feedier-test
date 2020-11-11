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
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header font-weight-bold">Create New Question</div>
                    <div class="card-body">
                        <form action="/questionnaires/{{ $questionnaire->id }}/questions" method="post">
                        @csrf
                        <!-- Question -->
                            <div class="form-group">
                                <label for="question"><strong>Question</strong></label>
                                <input type="text" class="form-control" name="question[question]" id="question"
                                       value="{{ old('question.question') }}"
                                       aria-describedby="questionHelp" autocomplete="off"
                                       placeholder="Enter Question">
                                <small id="questionHelp" class="form-text text-muted">Ask simple and to-the-point
                                    question for help
                                </small>

                                @error('question.question')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{--  type of answer. will it be input, textarea, radio button or checkbox? --}}

                            <div class="form-group">
                                <label for="type"><strong>Answer Type</strong></label>
                                <select class="form-control" id="type" name="question[type]">
                                    <option value="0" @if(old('question.type') == '0') selected="selected" @endif>Select
                                        type
                                    </option>
                                    <option value="1" @if(old('question.type') == '1') selected="selected" @endif>Input
                                        box
                                    </option>
                                    <option value="2" @if(old('question.type') == '2') selected="selected" @endif>
                                        Textarea
                                    </option>
                                    <option value="3" @if(old('question.type') == '3') selected="selected" @endif>Radio
                                        button
                                    </option>
                                    <option value="4" @if(old('question.type') == '4') selected="selected" @endif>
                                        Checkbox
                                    </option>
                                </select>
                                <small id="typeHelp" class="form-text text-muted">Choose answer type</small>

                                @error('question.type')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group d-none" id="typeCountDiv">
                                <label for="type_count"><strong>How namy choices?</strong></label>
                                <input type="number" class="form-control" name="question[type_count]" id="type_count"
                                       value="{{ old('question.type_count') ?? 2}}" max="3" min="2"
                                       placeholder="Enter value">

                                @error('question.type_count')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-check mt-2 mb-4">
                                <input class="form-check-input" type="checkbox"
                                       value="{{ old('question.is_required') ?? 1 }}" id="is_required"
                                       name="question[is_required]">
                                <label class="form-check-label font-weight-bold" for="is_required">
                                    Required Question
                                </label>
                                @error('question.is_required')
                                <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group d-none" id="choiceDiv">
                                <fieldset>
                                    <legend>Choices</legend>
                                    <small id="choicesHelp" class="form-text text-muted">Give choices that give you the
                                        most insight into your question
                                    </small>
                                    {{--<div>--}}
                                    <div class="form-group d-none" id="answer1Div">
                                        <label for="answer1" class="font-weight-bold">Choice 1</label>
                                        <input type="text" class="form-control" name="answers[][answer]"
                                               value="{{ old('answers.0.answer') }}" autocomplete="off"
                                               id="answer1"
                                               placeholder="Enter Choice 1">

                                        @error('answers.0.answer')
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{--</div>
                                    <div>--}}
                                    <div class="form-group d-none" id="answer2Div">
                                        <label for="answer2" class="font-weight-bold">Choice 2</label>
                                        <input type="text" class="form-control" name="answers[][answer]"
                                               value="{{ old('answers.1.answer') }}" autocomplete="off"
                                               id="answer2"
                                               placeholder="Enter Choice 2">


                                        @error('answers.1.answer')
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{--</div>
                                    <div>--}}
                                    <div class="form-group d-none" id="answer3Div">
                                        <label for="answer3" class="font-weight-bold">Choice 3</label>
                                        <input type="text" class="form-control" name="answers[][answer]"
                                               value="{{ old('answers.2.answer') }}" autocomplete="off"
                                               id="answer3"
                                               placeholder="Enter Choice 3">


                                        @error('answers.2.answer')
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{--</div>--}}

                                </fieldset>

                            </div>

                            <button type="submit" class="btn btn-primary">Add Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        /* choice option change*/
        document.querySelector('#type').addEventListener('change', function () {
            const val = this.value;

            if (val == 3 || val == 4) {

                //document.querySelector('#inputTypeDiv').classList.add('d-none');
                document.querySelector('#typeCountDiv').classList.remove('d-none');
                const typeCount = document.querySelector('#type_count');
                typeCount.classList.remove('d-none');
                typeCount.removeAttribute('disabled');
                const choiceCount = typeCount.value;
                console.log('choiceCount', choiceCount);


                if (choiceCount == 3) {
                    document.querySelector('#answer1Div').classList.remove('d-none');
                    document.querySelector('#answer2Div').classList.remove('d-none');
                    //document.querySelector('#answer3Div').classList.remove('d-none');
                    const el3Div = document.querySelector('#answer3Div');
                    //console.log('contains',el3Div.classList.contains('d-none'));
                    if (el3Div.classList.contains('d-none')) {
                        el3Div.classList.remove('d-none');
                        var el3 = document.querySelector('#answer3'); //console.log(el3.value);
                        el3.classList.remove('d-none');
                        el3.removeAttribute('readonly');
                        el3.removeAttribute('disabled');
                        //el3.value = '';
                    }

                } else if (choiceCount == 2) {
                    document.querySelector('#answer1Div').classList.remove('d-none');
                    document.querySelector('#answer2Div').classList.remove('d-none');
                    const el3Div = document.querySelector('#answer3Div');
                    const el3 = document.querySelector('#answer3');
                    /*if (!el3.classList.contains('d-none')) {
                    }*/
                    el3Div.classList.add('d-none');

                    el3.classList.add('d-none');
                    el3.setAttribute('readonly', 'readonly');
                    el3.setAttribute('disabled', 'disabled');
                }

                document.querySelector('#choiceDiv').classList.remove('d-none');

            } else {
                const typeCount = document.querySelector('#type_count');
                typeCount.parentNode.classList.add('d-none');
                typeCount.classList.add('d-none');
                typeCount.setAttribute('disabled', 'disabled');

                const choiceDiv = document.querySelector('#choiceDiv');
                choiceDiv.classList.add('d-none');
            }

        });

        document.querySelector('#type_count').addEventListener('change', function () {
            const val = this.value;
            console.log('typeCount changed', val);
            const el3Div = document.querySelector('#answer3Div');
            const el3 = document.querySelector('#answer3');
            if (val == 3) {
                if (el3Div.classList.contains('d-none')) {
                    el3Div.classList.remove('d-none');
                    el3.classList.remove('d-none');
                    el3.removeAttribute('readonly');
                    el3.removeAttribute('disabled');
                    //el3.value = '';
                }

            } else {
                if (!el3Div.classList.contains('d-none')) {
                    el3Div.classList.add('d-none');
                }
                el3.classList.add('d-none');
                el3.setAttribute('readonly', 'readonly');
                el3.setAttribute('disabled', 'disabled');
                //el3.value = '';
            }
        });

    </script>
@endsection
