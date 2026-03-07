<div class="relative w-full overflow-auto">
    <table class="w-full caption-bottom text-sm">
        <thead class="[&_tr]:border-b">
            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                {{ $header }}
            </tr>
        </thead>
        <tbody class="[&_tr:last-child]:border-0">
            {{ $slot }}
        </tbody>
    </table>
</div>