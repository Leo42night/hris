<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome to Laravel')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('easyui/easyui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('easyui/icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('easyui/color.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('easyui/demo.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script type="text/javascript" src="{{ asset('easyui/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('easyui/jquery.easyui.min.js') }}"></script>

    <!-- Styles / Scriptss-->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50 w-full h-screen flex flex-col">

    <header>
        @yield('header')
    </header>

    {{-- sidebar  --}}
    <div class="easyui-panel" style="padding:5px;">
        <div class="grid grid-cols-3 border-b-2 border-gray-200 pb-2 mb-2 border-dashed">
            <a href="{{ route('users') }}" class="easyui-linkbutton"
                data-options="plain:true{{ 1 == 2 ? ',selected:true' : '' }}">
                <img src="{{ asset('easyui/icons/large_clipart.png') }}" alt="" class="mx-auto">
                <p>User</p>
            </a>
            <a href="{{ route('empty') }}" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_shapes.png') }}" alt="" class="mx-auto">
                <p>Empty</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
        </div>
        <div class="grid grid-cols-3">
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
            <a href="#" class="easyui-linkbutton" data-options="plain:true">
                <img src="{{ asset('easyui/icons/large_smartart.png') }}" alt="" class="mx-auto">
                <p>Dummy</p>
            </a>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    @yield('scripts')
</body>

</html>
