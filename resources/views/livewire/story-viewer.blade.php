<div class="story">
    <div class="sidebar text-purple-900">
        <div class="content">
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
                    Page {{ $step + 1 }} of {{ count($story->beats) }}
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

        <img class="overlay" src="https://uc01fedb6bc2936a1cddc8977b17.previews.dropboxusercontent.com/p/thumb/ABymM1xsxO9wVS2jejMaIoLmiQ3wUdnsVjYVveURchfAWHgTQ3fFJWuXFa60Xa1akYv6xs0kZpYUJkj-GFsrNgzDpsooVSsifke1p3ZiuUpgUJdOflX7f2uBTsO-vMBn4LyUsSwsu8BO9pWMqhrC-AC8VaISbwC482EYiROdD_myy4hYEZv0wVh_ujbX-MMLbW0DmhlPH43DlYKVxpvegTv0ymZdxuAftTT9W2jjSffx6NVTG0LkmCNanDEiy6SrxLwm-BL8wZuih8LWm5AficA-M3Ik9PjdWldRNoc8EA6rbfbVBXAWreyzBoo8rIeWAcEDfU4EGgIS623Qz-37kYBeiP_GiNHR--R1Um2RRB311heJ1MxrXK0RlbmUwjE9D24/p.png" />

        <img src="{{ $currentBeat['image'] }}"
             class="transition duration-150 ease-in-out"
             onload="document.getElementById('story-image').classList.remove('loading')"
        />
    </div>
</div>
