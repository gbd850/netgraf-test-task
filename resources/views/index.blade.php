@extends('layouts.app')

<script>
    var msg = '{{ Session::get('alert') }}';
    var exist = '{{ Session::has('alert') }}';
    if (exist) {
        alert(msg);
    }
</script>

@section('content')
    <div>
        <a href="{{ route('showCreate') }}">Create new pet</a>
        @foreach ($pets as $pet)
            <div>
                <p>{{ $pet['name'] ?? '' }} {{ $pet['status'] }} <a href="{{ route('showEdit', $pet['id']) }}">Edit</a> <a
                        href="{{ route('delete', $pet['id']) }}">Delete</a></p>
            </div>
        @endforeach
    </div>
@endsection
