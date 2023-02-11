<div>
  <form wire:submit.prevent="submit">
    {{ $this->form }}
    <div wire:loading>
      Writing your story....
    </div>
  </form>
</div>
