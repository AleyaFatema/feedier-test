@component('mail::message')
# Dear Admin

@if($responses->count() > 0)
For the past 48 hours you have received {{ $responses->count() }} answers for  your textarea type questions.
Please check the latest {{ $responses->count() }} answers below.
@component('mail::panel')
@foreach($responses as $response)
- <strong>Question:</strong><br>{{ $response->question}}<br>
<strong>Answer:</strong><br> {{ \Illuminate\Support\Str::limit($response->responses()->first()->responses, 20, $end='...')}}
@endforeach
@endcomponent
@else
There is no answer for the last 48 hours of your textarea question.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
