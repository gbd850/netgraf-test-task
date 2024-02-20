@extends('layouts.app')

<script>
    var msg = '{{ Session::get('alert') }}';
    var exist = '{{ Session::has('alert') }}';
    if (exist) {
        alert(msg);
    }
</script>

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center p-3">
            <a class="bg-blue-500 text-white py-3 px-5 rounded uppercase font-bold" href="{{ route('showCreate') }}">Create new pet</a>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="text-lg text-gray-700 uppercase bg-gray-200 text-center">
                <tr>
                    <th class="px-10 py-7">Name</th>
                    <th class="px-10 py-7">Status</th>
                    <th class="px-10 py-7"></th>
                    <th class="px-10 py-7"></th>
                </tr>
            </thead>
            @foreach ($pets as $pet)
                <tr class="text-md bg-white border-b text-center [&>*]:p-5">
                    <td>{{ $pet['name'] ?? '' }}</td>
                    <td>{{ $pet['status'] }}</td>
                    <td><a class="bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('showEdit', $pet['id']) }}">Edit</a>
                    </td>
                    <td><a class="bg-red-500 text-white px-4 py-2 rounded" href="{{ route('delete', $pet['id']) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
