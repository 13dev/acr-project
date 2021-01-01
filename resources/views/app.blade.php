<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="Music stream platform.">
    <meta name="keywords" content="music, laravel, tailwind">
    <meta name="author" content="Leo Oliveira">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.8.2/css/all.css"/>
    @if (Auth::check())
        <meta name="artist" content='{!! Auth::user()->toJson() !!}' />
    @endif

</head>

<body class="bg-gray-900 h-full font-sans text-gray-200 leading-loose">

<div id="app" class="h-full">
    <app></app>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
