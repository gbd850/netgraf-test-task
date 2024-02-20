@extends('layouts.app')
@section('content')
    <div>
        <h2>Edit Pet</h2>
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
            <div>
                <label>Pet id</label>
                <input type="number" name="pet_id" min="0">
            </div>
            <div>
                <label>Pet name</label>
                <input type="text" name="pet_name">
            </div>
            <div>
                <label>Pet category</label>
                <input type="text" name="pet_category">
            </div>
            <div>
                <label>Pet photo urls</label>
                <div id="urls_append">
                    <div>
                        <input type="text" name="pet_photo_url[]">
                        <button type="button" name="add" id="add_url">+</button>
                    </div>
                </div>
            </div>
            <div>
                <label>Pet tags</label>
                <div id="tags_append">
                    <div>
                        <input type="text" name="pet_tag[]">
                        <button type="button" name="add" id="add_tag">+</button>
                    </div>
                </div>
            </div>
            <div>
                <label>Pet status</label>
                <select name="pet_status">
                    @foreach (['Available' => 'available', 'Pending' => 'pending', 'Sold' => 'sold'] as $name => $status)
                        @if ($status == 'available')
                            <option value="{{ $status }}" @selected(true)>{{ $name }}</option>
                        @else
                            <option value="{{ $status }}">{{ $name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit">Create</button>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var countUrl = 1;
            var countTag = 1;

            //urls array section
            $('#add_url').click(function() {
                $('#urls_append').append('<div id="row_url' + countUrl +
                    '"><input type="text" name="pet_photo_url[]"><button id="' + countUrl +
                    '" type="button" name="remove" class="btn_url_remove">X</button></div>'
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
                    '"><input type="text" name="pet_tag[]"><button id="' + countTag +
                    '" type="button" name="remove" class="btn_tag_remove">X</button></div>'
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
