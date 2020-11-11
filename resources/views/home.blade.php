@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    {{-- Message div --}}
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="/questionnaires/create" class="btn btn-dark">Create New Questionnaire</a>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">My Questionnaires</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($questionnaires as $questionnaire)
                            <li class="list-group-item">
                                <a class="font-weight-bold" href="{{ $questionnaire->path() }}">
                                    {{ $questionnaire->title }}
                                </a>
                                @if($questionnaire->questions()->count() > 2)
                                <div class="mt-2">
                                    <small class="font-weight-bold">Survey URL:</small>
                                    <a href="{{ $questionnaire->publicPath() }}">{{ Str::limit($questionnaire->publicPath(), 50, $end='...') }}</a>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
