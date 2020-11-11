@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">Create New Questionnaire</div>

                    <div class="card-body">
                        <form action="/questionnaires" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp"
                                       value="{{ old('title') }}" placeholder="Enter title">
                                <small id="titleHelp" class="form-text text-muted">Give your questionnaire a title that
                                    atracts attention.
                                </small>

                                @error('title')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="purpose">Purpose</label>
                                <input type="text" class="form-control" name="purpose" id="purpose" aria-describedby="purposeHelp"
                                       value="{{ old('purpose') }}" placeholder="Enter purpose">
                                <small id="purposeHelp" class="form-text text-muted">Giving a purpose will increase
                                    responses.
                                </small>

                                @error('purpose')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="active_at">Date from</label>
                                <input type="date" class="form-control" name="active_at" id="active_at" aria-describedby="activeAtHelp"
                                       value="{{ old('active_at') }}" placeholder="Enter date" max="inactive_at">
                                <small id="activeAtHelp" class="form-text text-muted">Mention from when the questionnaire will be available.
                                </small>

                                @error('active_at')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inactive_at">Date to</label>
                                <input type="date" class="form-control" name="inactive_at" id="inactive_at" aria-describedby="inactiveAtHelp"
                                       value="{{ old('inactive_at') }}" placeholder="Enter date" min="active_at">
                                <small id="inactiveAtHelp" class="form-text text-muted">Mention when the questionnaire will be inactive.</small>

                                @error('inactive_at')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Questionnaire</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
