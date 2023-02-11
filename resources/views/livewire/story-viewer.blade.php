<div class="story">
    <div class="sidebar text-purple-900">
        <div class="content pt-12">
            @foreach (explode('.', $currentBeat['paragraph']) as $sentence)
                <div class="pb-4">
                    {{ $sentence }}.
                </div>
            @endforeach
        </div>

        <div class="footer">
            <div class="buttons">
                <div>
                    @if ($step > 0)
                        <button
                            class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                            wire:click="previous">
                            Previous
                        </button>
                    @endif
                </div>

                <div>
                    @if ($step < count($beats) - 1)
                        <button
                            class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                            wire:click="next">
                            Next
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="image rounded-2xl">
        <img src="{{ $currentBeat['image'] }}" class="transition duration-150 ease-in-out"/>
    </div>
</div>
