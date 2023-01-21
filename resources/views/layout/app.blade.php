<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel To-Do List</title>

    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <script src="{{asset('js/app.js')}}" defer></script>
</head>
<body class="antialiased">

    <header>
        <h1>Laravel To-Do List</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Van Ons - {{date('Y')}}
    </footer>
</body>
</html>
