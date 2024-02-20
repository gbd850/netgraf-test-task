@extends('layouts.app')
@section('content')
    <div class="container mx-auto flex flex-col items-center">
        <div>
            <h2 class="text-2xl font-bold p-3">Edit Pet</h2>
        </div>

        <div>
            @if (session('status'))
                <div role="alert">
                    {{ session('status') }}
                </div>
            @elseif(session('failed'))
                <div role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form method="POST">
                @csrf
                <input type="hidden" name="pet_id" value="{{ $pet['id'] }}">
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet name</label>
                    <input class="border p-2" type="text" name="pet_name" value="{{ $pet['name'] }}">
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet status</label>
                    <select class="border p-2 w-40" name="pet_status">
                        @foreach (['Available' => 'available', 'Pending' => 'pending', 'Sold' => 'sold'] as $name => $status)
                            @if ($pet['status'] == $status)
                                <option value="{{ $status }}" @selected(true)>{{ $name }}
                                </option>
                            @else
                                <option value="{{ $status }}">{{ $name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="text-center m-2">
                    <button class="bg-blue-500 px-4 py-2 rounded text-white" type="submit">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
