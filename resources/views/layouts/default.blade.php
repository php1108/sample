<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','Sample')-Laravel入门教程</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
</head>
<body>
@include('layouts._header')
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            @include('shared.messages')
            @yield('content')
        </div>
    </div>

@include('layouts._footer')
<script src="/js/app.js"></script>
</body>
</html>