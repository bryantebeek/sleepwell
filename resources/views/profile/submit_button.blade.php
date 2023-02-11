<button type="submit"
        class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700"
        wire:loading.attr="disabled"
>
    <span wire:loading.remove>Tell me a personal story</span>
    <span wire:loading>@include('partials.loader')</span>
</button>
