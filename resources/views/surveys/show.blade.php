@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1>{{ $questionnaire->title }}</h1>
                <form action="/surveys/{{$questionnaire->id}}-{{ Str::slug($questionnaire->title) }}" method="post">
                    @csrf
                    @if($questionnaire->questions->count() > 0)

                        @foreach($questionnaire->questions as $key => $question)

                            <div class="card mt-4">
                                <div class="card-header">
                                    <span class="font-weight-bold">{{$key + 1}}.</span> {{ $question->question }}
                                    @if($question->is_required)
                                    <span class="text-danger font-weight-bold">*</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @error('responses.' . $key . '.answer_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    <input type="hidden" name="responses[{{ $key }}][question_id]"
                                           value="{{$question->id}}">
                                    <input type="hidden" name="question[{{ $key }}][type]"
                                           value="{{$question->type}}">
                                    <input type="hidden" name="question[{{ $key }}][is_required]"
                                           value="{{$question->is_required}}">

                                    {{-- Answers --}}
                                    @if($question->type == 3 || $question->type == 4)
                                        {{-- block for radiobutton or checkbox type answers --}}

                                        <ul class="list-group">
                                            @foreach($question->answers as $answer)
                                                {{--{{dump(old('responses.'. $key . '.answer_id'))}}--}}
                                                <label for="answer{{ $answer->id }}">
                                                    <li class="list-group-item">
                                                        <input
                                                            @if($question->type == 3) type="radio"
                                                            @else type="checkbox" @endif
                                                            @if($question->is_required) required @endif
                                                            name="responses[{{ $key }}][answer_id]" id="answer{{ $answer->id }}"
                                                               {{ (old('responses.' . $key . '.answer_id') == $answer->id) ? 'checked' : ''}}
                                                               class="mr-2" value="{{ $answer->id }}">
                                                        {{$answer->answer}}
                                                    </li>
                                                </label>
                                            @endforeach
                                        </ul>

                                    @elseif($question->type == 2)
                                        {{-- block for textarea type answers --}}
                                        <div class="form-group">
                                            <label for="responses[{{ $key }}][responses]">Please give your answer</label>
                                            <textarea class="form-control" rows="3" @if($question->is_required) required @endif
                                                      id="responses[{{ $key }}][responses]" name="responses[{{ $key }}][responses]"
                                                      placeholder="Enter your answer here...">{{ old('responses.' . $key . '.responses') }}</textarea>
                                            @error('responses['.$key.'][responses]')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    @elseif($question->type == 1)
                                        {{-- block for inputbox type answers --}}
                                        <div class="form-group">
                                            <label for="responses[{{ $key }}][responses]">Please give your answer</label>
                                            <input type="text" class="form-control" name="responses[{{ $key }}][responses]" id="responses[{{ $key }}][responses]"
                                                   value="{{ old('responses.' . $key . '.responses') }}" @if($question->is_required) required @endif
                                                   placeholder="Enter your answer here...">

                                            @error('responses['.$key.'][responses]')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                        {{-- Personal Information --}}
                        <div class="card mt-4">
                            <div class="card-header font-weight-bold">Your Information</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">
                                        Your Name <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="survey[name]" id="name"
                                           aria-describedby="nameHelp" required
                                           value="{{ old('survey.name') }}"
                                           placeholder="Enter your name">
                                    <small id="nameHelp" class="form-text text-muted">Hello! what's your name?</small>
                                    @error('survey.name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        Your Email <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="survey[email]" id="email"
                                           aria-describedby="emailHelp" required
                                           value="{{ old('survey.email') }}" placeholder="Enter your email">
                                    <small id="emailHelp" class="form-text text-muted">Your email please</small>
                                    @error('survey.email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="submit" class="btn btn-dark" value="Complete Survey">
                            </div>
                        </div>
                    @else
                        @auth
                            <div class="alert alert-info mt-4" role="alert">
                                <h4 class="alert-heading">Please add question</h4>
                                <hr>
                                <p>For survey you need to add questions to your questionnaire.</p>
                                <p class="mb-0">Please add related and simple words.</p>
                            </div>
                        @endauth
                    @endif
                </form>

            </div>
        </div>
    </div>
@endsection
