@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Show message block --}}
                @if(Session::has('message'))

                    <div
                        class="alert @if(Session::get('status')==200) alert-success @else alert-danger @endif alert-dismissible fade show mt-4"
                        role="alert">
                        <strong>{{ Session::get('message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
                {{-- Survey list --}}
                <div class="card @if( Session::get('message')) mt-4 @endif">
                    <div class="card-header font-weight-bold">Available Surveys</div>
                    <div class="card-body">
                        <p>Please give us your valuable inputs. Thank you.</p>
                        <ul class="list-group">
                        @foreach($questionnaires as $key1 => $questionnaire)
                            @if($questionnaire->questions()->count())
                            <li class="list-group-item">
                                <a class="font-weight-bold" href="{{ $questionnaire->publicPath() }}">
                                    {{ $questionnaire->title }}
                                </a>
                                <br>
                                <small class="font-weight-bold">{{ $questionnaire->purpose }}</small>
                            </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
