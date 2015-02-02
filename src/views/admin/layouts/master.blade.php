<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ (isset($title)) ? $title : 'Administration' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="{{ URL::asset('/packages/devisephp/cms/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/packages/devisephp/cms/css/dvs-admin.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('/packages/devisephp/cms/css/main.css') }}" type="text/css" rel="stylesheet">

    @yield('css')

    <script src="{{ URL::asset('/packages/devisephp/cms/js/devise.min.js') }}"></script>
    <script>devise.require(['app/admin/main'])</script>
</head>

<body id="dvs-admin" class="dvs-default">
    <div id="dvs-admin-sidenav">
        <img src="{{ URL::asset('/packages/devisephp/cms/img/admin-logo.png') }}" width="195" height="71" >

        <hr class="dvs-thick">

        @foreach ($dvsAdminMenu as $menuGroup)
            <h5>{{ $menuGroup->name }}</h5>
            <ul class="dvs-admin-links">
                @foreach ($menuGroup->children as $link)
                    <li><a class="{{ isActiveLink($link->url) }}" href="{{ $link->url }}">{{ $link->name }}</a></li>
                @endforeach
            </ul>
        @endforeach

        <div class="dvs-hide-mobile" id="dvs-devise-logo-sm">
            <img src="{{ URL::asset('/packages/devisephp/cms/img/admin-devise-powered-logo.png') }}" width="100%">
        </div>
    </div>

    <div id="dvs-admin-body">
        <div id="dvs-admin-subnavigation">
            @yield('subnavigation')
        </div>

        <div class="dvs-admin-container">
            @yield('title')
        </div>

        @if(Session::has('message'))
            <div class="dvs-messages">
                <h2>{{ Session::get('message') }}</h2>
                @if($errors->any())
                    <ul class="list">{{ implode('', $errors->all('<li class="error">:message')) }}</ul>
                @endif
                @if(isset($warnings) && count($warnings))
                    <ul class="list"><li>{{ implode('</li><li>', $warnings) }}</li></ul>
                @endif
            </div>
        @endif

        @yield('main')
    </div>
</body>
</html>