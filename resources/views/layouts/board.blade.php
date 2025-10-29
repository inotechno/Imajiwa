<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body data-sidebar="{{ session('theme', 'dark') }}" data-layout-mode="{{ session('theme', 'dark') }}">

    {{$slot}}
    
    <!-- JAVASCRIPT -->
    @include('layouts.partials.plugin')
    
    
</body>

</html>
