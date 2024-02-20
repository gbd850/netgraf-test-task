@extends('layouts.app')
@section('content')
    <div class="h-full bg-gray-700 text-gray-100 flex items-center">
        <div class="container mx-auto flex flex-col items-center space-y-5 p-5">
            <h1 class="text-4xl">{{ $error->getCode() }}</h1>
            <p class="text-md">Oops! Something went wrong!</p>
            <p class="text-lg">{{ $error->getMessage() }}</p>
        </div>
    </div>
