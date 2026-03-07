<div {{ $attributes->merge(['class' => 'rounded-lg border bg-card text-card-foregound shadown-sm']) }}>
    <div class="p-6 pt-0 mt-6">
        {{ $slot }}
    </div>
</div>