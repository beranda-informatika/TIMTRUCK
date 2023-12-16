@if (Auth::user()->hasRole('administrator'))
    @include('dashboard._partials.menuadmin')
@else
    @include('dashboard._partials.menuuser')
@endif