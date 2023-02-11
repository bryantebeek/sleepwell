<div class="story">
    <div class="sidebar text-purple-900">
        <div class="content pt-12">
            @foreach (\Illuminate\Support\Str::of($currentBeat['paragraph'])->explode('.')->filter() as $sentence)
                <div class="pb-4">
                    {{ $sentence }}.
                </div>
            @endforeach
        </div>

        <div class="footer">
            <div class="buttons">
                <div class="text-start">
                    @if ($step > 0)
                        <button
                            class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                            wire:click="previous"
                            x-click="document.getElementById('story-image').classList.add('loading')">
                            Previous
                        </button>
                    @endif
                </div>

                <div class="pagination text-center">
                    Page {{ $step + 1 }} of {{ count($beats) }}
                </div>

                <div class="text-end">
                    @if ($step < count($beats) - 1)
                        <button
                            class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                            wire:click="next"
                            x-click="document.getElementById('story-image').classList.add('loading')">
                            Next
                        </button>
                    @endif

                    @if ($step === count($beats) - 1)
                        <button
                            class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                            wire:click="finish">
                            Finish
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="image rounded-2xl loading" id="story-image">
        <div class="loader" id="loader">
            {{-- https://github.com/n3r4zzurr0/svg-spinners/tree/main/preview --}}
            <svg width="36" height="36" fill="#fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_Wezc{transform-origin:center;animation:spinner_Oiah .75s step-end infinite}@keyframes spinner_Oiah{8.3%{transform:rotate(30deg)}16.6%{transform:rotate(60deg)}25%{transform:rotate(90deg)}33.3%{transform:rotate(120deg)}41.6%{transform:rotate(150deg)}50%{transform:rotate(180deg)}58.3%{transform:rotate(210deg)}66.6%{transform:rotate(240deg)}75%{transform:rotate(270deg)}83.3%{transform:rotate(300deg)}91.6%{transform:rotate(330deg)}100%{transform:rotate(360deg)}}</style><g class="spinner_Wezc"><circle cx="12" cy="2.5" r="1.5" opacity=".14"/><circle cx="16.75" cy="3.77" r="1.5" opacity=".29"/><circle cx="20.23" cy="7.25" r="1.5" opacity=".43"/><circle cx="21.50" cy="12.00" r="1.5" opacity=".57"/><circle cx="20.23" cy="16.75" r="1.5" opacity=".71"/><circle cx="16.75" cy="20.23" r="1.5" opacity=".86"/><circle cx="12" cy="21.5" r="1.5"/></g></svg>
        </div>

        <img src="{{ $currentBeat['image'] }}"
             class="transition duration-150 ease-in-out"
             onload="document.getElementById('story-image').classList.remove('loading')"
        />
    </div>
</div>
