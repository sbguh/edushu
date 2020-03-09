<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '中小学生免费借书平台') - 共享书房</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

@section('jssdk')

@show

</head>
<body>

        @include('layouts._header')
        <div class="container wechat_content">
            @yield('content')
        </div>
        @include('layouts.wechat_footer')

    <!-- JS 脚本 -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scriptsAfterJs')
</body>
</html>
