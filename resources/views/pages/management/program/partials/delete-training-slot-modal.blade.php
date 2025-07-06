<x-modal name="confirm-deletion{{$value->id}}" :show="$errors->isNotEmpty()" focusable x-data="confirm-deletion">
    <div class="p-6">
        <form method="post" action="{{ route('manage.training.slot.destroy', ['slug' => $value->slug]) }}"  >
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to Delete this Training Slot?') }}
            </h2>


            <p class="mt-1 text-md font-medium text-gray-600">
                Name: {{ $value->name }}
            </p>
            <p class="mt-1 text-md font-medium text-gray-600">
                Start Time: {{$value->start_time}}
            </p>
            <p class="mt-1 text-md font-medium text-gray-600">
                End Time: {{$value->end_time}}
            </p>
            <p class="mt-1 text-md font-medium text-gray-600">
                Available Seats: {{$value->available_seats}}
            </p>
            <p class="mt-1 text-md font-medium text-gray-600">
                Status: {{$value->status}}
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
    </div>
</x-modal>
