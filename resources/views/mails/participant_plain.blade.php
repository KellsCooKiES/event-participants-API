Hello {{ $participant->receiver }},
New participant registered:

Name:{{ $participant->name }}
Surname: {{ $participant->surname }}
email:{{ $participant->email}}
@if ($participant->events)
    events: @foreach($participant->events as $event)
                {{$event->name}}

            @endforeach
@endif


Thank You,  {{ $participant->sender }}
