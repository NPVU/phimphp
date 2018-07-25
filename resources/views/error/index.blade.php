<html lang="{{ app()->getLocale() }}">
    @include('admin.template.head')
    <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
        @include($page)                    
    </body>
</html>