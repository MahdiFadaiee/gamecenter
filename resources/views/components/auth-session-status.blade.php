@props(['status'])

@if ($status)
    <div role="status" {{ $attributes->merge(['class' => 'alert alert-success py-2 px-3 mb-3']) }}>
        {{ $status }}
    </div>
@endif
