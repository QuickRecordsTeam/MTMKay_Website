<x-modal name="delete_outline{{$outline->id}}" :show="$errors->isNotEmpty()" focusable x-data="delete-outline">
    <form method="post" action="{{ route('program.delete.outline', ['slug' => $program->slug, 'outlineSlug' => $outline->slug]) }}" class="p-6" >
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to Delete this Program Outline?') }}
        </h2>


        <p class="mt-1 text-md font-medium text-gray-600">
            Period: {{ $outline->period }}
        </p>
        <p class="mt-1 text-md font-medium text-gray-600">
            Topic: {!! $outline->topic !!}
        </p>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
