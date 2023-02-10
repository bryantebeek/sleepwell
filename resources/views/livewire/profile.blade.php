<div>
  <form wire:submit.prevent="submit">

    {{ $this->form }}

    <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      Submit
    </button>
  </form>
</div>
