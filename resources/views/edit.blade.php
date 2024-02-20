@extends('layouts.app')
@section('content')
    <div>
        <h2>Edit Pet</h2>
    </div>

    <div>
        @if (session('status'))
            <div role="alert">
                <button type="button" data-dismiss="alert">×</button>
                {{ session('status') }}
            </div>
        @elseif(session('failed'))
            <div role="alert">
                <button type="button" data-dismiss="alert">×</button>
                {{ session('failed') }}
            </div>
        @endif
        <form method="POST">
            @csrf
            <input type="hidden" name="pet_id" value="{{ $pet['id'] }}">
            <div>
                <label>Pet name</label>
                <input type="text" name="pet_name" value="{{ $pet['name'] }}">
            </div>
            <div>
                <label>Pet status</label>
                <select name="pet_status">
                    @foreach (['Available' => 'available', 'Pending' => 'pending', 'Sold' => 'sold'] as $name => $status)
                        @if ($pet['status'] == $status)
                            <option value="{{ $status }}" @selected(true)>{{ $name }}</option>
                        @else
                            <option value="{{ $status }}">{{ $name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit">Edit</button>
        </form>
    </div>
@endsection
