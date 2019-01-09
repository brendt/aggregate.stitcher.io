@if(! isset($nowrap))
    <div class="mt-6">
@endisset

<h1 class="text-xl {{ $class ?? '' }}">
    {{ $slot ?? '' }}
</h1>

@if(! isset($nowrap))
    </div>
@endisset
