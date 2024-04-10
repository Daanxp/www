@extends('base')

@section('content')
    <h1>Dashboard</h1>
    <h3>Meldingen management</h3>
    <table class="table">
        <tr>
            <th>Naam</th>
            <th>Mentor</th>
            <th>Datum</th>
            <th>Reden</th>
            <th>img</th>
            <th>&nbsp;<th>
        </tr>
        @foreach($notices as $notice)
            @if(is_null($notice->reason_id))
                <tr class="table-danger">
            @elseif($notice->is_approved == false)
                <tr class="table-warning">
            @else <tr>
            @endif
                <th>{{ $notice->users->name }}</a></th>
                <th>{{ $notice->mentors->name }}</th>
                <th>{{ $notice->created_at }}</th>
                <th>{{ $notice->reasons->title ?? '' }}</th>
                <th><img src="{{asset('storage/'. $notice->img)}}"></th>
                <th><a href="{{ route('notices.edit', $notice->id) }}">Aanpassen</th>
            </tr>
        @endforeach
    </table>
    <a class="btn btn-primary" href="{{ route('notices.create') }}" role="button">Maak nieuwe melding</a>
@endsection