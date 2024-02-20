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
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet id</label>
                    <input class="border p-2" type="number" name="pet_id" min="0">
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet name</label>
                    <input class="border p-2" type="text" name="pet_name">
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet category</label>
                    <input class="border p-2" type="text" name="pet_category">
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet photo urls</label>
                    <div id="urls_append">
                        <div>
                            <input class="border p-2" type="text" name="pet_photo_url[]">
                            <button class="p-2 bg-gray-200 rounded" type="button" name="add" id="add_url">+</button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet tags</label>
                    <div id="tags_append">
                        <div>
                            <input class="border p-2" type="text" name="pet_tag[]">
                            <button class="p-2 bg-gray-200 rounded" type="button" name="add" id="add_tag">+</button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between [&>*]:m-2">
                    <label>Pet status</label>
                    <select class="border p-2 w-40" name="pet_status">
                        @foreach (['Available' => 'available', 'Pending' => 'pending', 'Sold' => 'sold'] as $name => $status)
                            @if ($status == 'available')
                                <option value="{{ $status }}" @selected(true)>{{ $name }}
                                </option>
                            @else
                                <option value="{{ $status }}">{{ $name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="text-center m-2">
                <button class="bg-green-500 px-4 py-2 rounded text-white" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var countUrl = 1;
            var countTag = 1;

            //urls array section
            $('#add_url').click(function() {
                $('#urls_append').append('<div id="row_url' + countUrl +
                    '"><input class="border p-2" type="text" name="pet_photo_url[]"><button class="p-2 bg-red-200 rounded btn_url_remove" id="' + countUrl +
                    '" type="button" name="remove">X</button></div>'
                );
                countUrl++;
            });


            $(document).on('click', '.btn_url_remove', function() {
                var button_id = $(this).attr("id");
                $('#row_url' + button_id + '').remove();
            });

            //tags array section
            $('#add_tag').click(function() {
                $('#tags_append').append('<div id="row_tag' + countTag +
                    '"><input class="border p-2" type="text" name="pet_tag[]"><button id="' + countTag +
                    '" type="button" name="remove" class="p-2 bg-red-200 rounded btn_tag_remove">X</button></div>'
                );
                countTag++;
            });


            $(document).on('click', '.btn_tag_remove', function() {
                var button_id = $(this).attr("id");
                $('#row_tag' + button_id + '').remove();
            });
        });
    </script>
@endsection
