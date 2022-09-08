<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ATEC - GE</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('./img/logo.png') }}">

    <style>
      html, body {
          width: 100%;
          height: 100%;
          margin: 0;
          padding: 0;
          display:table;
      }

      body {
          display: table-cell;
          vertical-align: middle;
          background-color: rgba(12,48,72,1);
          background:  linear-gradient(180deg, rgba(43,121,180,1) 0%, rgba(32,95,142,1) 30%, rgba(12,48,72,1) 60%, rgba(9,41,61,1) 100%);
      }

      .atec-ge-login{
          width: 65%;
          margin: 4%;
      }

      .atec-ge-register{
          width: 65%;
          margin: 2%;
      }

      @media only screen and (max-width: 400px) {
          .atec-ge-login{
              width: 85%;
          }

          .atec-ge-register{
              width: 85%;
              margin:10% 10% 0% 10%;

          }
      }

    </style>
</head>
<body>
<div id="app">
    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
