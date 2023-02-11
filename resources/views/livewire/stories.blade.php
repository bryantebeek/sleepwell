<div class="stories">
    <button class="stories-card stories-card-add" wire:click="new">
        +
    </button>

    @foreach ($stories as $story)
        <a href="{{ route('stories.view', $story) }}" class="stories-card">
            <img src="{{ $story->thumbnail }}" width="128" height="128"/>
            <h1 class="text-purple-900">{{ $story->summary }}</h1>
        </a>
    @endforeach
</div>
