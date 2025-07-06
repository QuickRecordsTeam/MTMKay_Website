
<x-modal name="confirm-trainee-deletion{{$value->id}}" :show="$errors->isNotEmpty()" focusable :data="$value">
    <form method="post" action="{{ route('trainee.destroy', ['slug'=> $value->slug]) }} " class="p-5">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 p-2">
            {{ __('Are you sure you want to delete this Enrollment?') }}
        </h2>

        <h2 class="text-lg font-medium text-gray-900 p-2">
            Name: {{ $value->user->name ?? '' }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 p-2">
            {{ __("This will delete all information relating to this enrollment") }}
        </p>



        <div class="mt-6 flex justify-end p-2 mb-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Trainee') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
