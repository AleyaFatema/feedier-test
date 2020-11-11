@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Questionnaire: </strong>{{ $questionnaire->title }}
                    </div>

                    <div class="card-body">
                        <a class="btn btn-dark" href="/questionnaires/{{ $questionnaire->id }}/questions/create">
                            Add New Question
                        </a>
                        @if($questionnaire->questions->count() > 2)
                            <a class="btn btn-dark"
                               href="/surveys/{{ $questionnaire->id }}-{{ Str::slug($questionnaire->title) }}">
                                Take Survey
                            </a>
                        @endif
                    </div>
                </div>

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <strong>{{ Session::get('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                @endif

                {{-- Show the questionnaire, questions and answers here--}}
                @forelse($questionnaire->questions as $question)
                    <div class="card mt-4">
                        <div class="card-header"><span class="font-weight-bold">Question: </span>{{ $question->question }}</div>
                        <div class="card-body">
                            @if($question->type == 3 || $question->type == 4)
                            <ul class="list-group">
                                @forelse($question->answers as $answer)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div>{{$answer->answer}}</div>
                                        @if($question->responses->count())
                                        <div>{{ intval(($answer->responses->count() * 100)/$question->responses->count()) }}%</div>
                                        @endif
                                    </li>
                                @empty
                                    <p>Please add answers</p>
                                @endforelse
                            </ul>
                            @else
                                <p>Answer will be submitted through survey.</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            {{--<a href="/questionnaires/{{ $questionnaire->id }}/questions/{{ $question->id }}/edit" class="btn btn-sm btn-outline-danger">Update Question</a>--}}
                            <form action="/questionnaires/{{ $questionnaire->id }}/questions/{{ $question->id }}" method="post">
                                @method('DELETE')
                                @csrf
                                <input type="submit" class="btn btn-sm btn-outline-danger" value="Delete Question">
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info mt-4" role="alert">
                        <h4 class="alert-heading">Please add question</h4>
                        <hr>
                        <p>For survey you need to add questions to your questionnaire.</p>
                        <p class="mb-0">Please add related and simple words.</p>
                    </div>

                @endforelse
            </div>
        </div>
    </div>
@endsection
