<div class="story">
    <div class="story-inner-wrapper">
        <div class="story-loader text-purple-700" wire:loading>
            @include('partials.loader')
            <span>Generating your personalized story</span>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Livewire.emit('startGenerate');
            });
        </script>
        @if (!$generate)
            <div class="sidebar text-purple-900">
                <div class="content">
                    @foreach (\Illuminate\Support\Str::of($currentBeat['paragraph'])->explode('.')->map(fn($sentence) => trim($sentence))->filter() as $sentence)
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
                            {{ $step + 1 }} of {{ count($story->beats) }}
                        </div>

                        <div class="text-end">
                            @if ($step < count($story->beats) - 1)
                                <button
                                    class="inline-block px-6 py-2.5 bg-purple-200 text-purple-900 font-medium text-xs leading-tight rounded hover:bg-purple-300 active:bg-purple-300 focus:bg-purple-300 focus:outline-none transition duration-150 ease-in-out"
                                    wire:click="next"
                                    x-click="document.getElementById('story-image').classList.add('loading')">
                                    Next
                                </button>
                            @endif

                            @if ($step === count($story->beats) - 1)
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
                    @include('partials.loader')
                </div>

                <img class="overlay" src="/images/overlay.png"/>

                <img src="{{ $currentBeat['image'] }}"
                     class="transition duration-150 ease-in-out"
                     onload="document.getElementById('story-image').classList.remove('loading')"
                />
            </div>

        @endif
    </div>
</div>
