<div class="stories">
    @foreach (\Illuminate\Support\Facades\Auth::user()->stories as $story)
        <a href="{{ route('stories.view', $story) }}" class="stories-card">
            <img src="{{ $story->thumbnail }}" width="128" height="128"/>
            <h1 class="text-purple-900">{{ $story->prompt }}</h1>
        </a>
    @endforeach

    <button class="stories-card stories-card-add" wire:click="new">
        +
    </button>
</div>
