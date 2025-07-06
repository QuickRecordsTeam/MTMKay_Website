<x-modal name="add-training-slot-modal" :show="$errors->isNotEmpty()" focusable x-data="add-training-slot-modal">
    <form method="post" action="{{ route('manage.training.slot.store', ['programSlug' => $program->slug]) }}" class="p-6" >
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Training Slot') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Provide Information below to add a training slot.") }}
        </p>


        <div class="grow my-4">
            <x-input-label for="title" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name')" required autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->first('name')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="start_time" :value="__('Start Time')"/>
            <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full"
                          :value="old('start_time')" required autocomplete="start_time"/>
            <x-input-error class="mt-2" :messages="$errors->first('start_time')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="end_time" :value="__('End Time')"/>
            <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full"
                          :value="old('end_time')" required autocomplete="end_time"/>
            <x-input-error class="mt-2" :messages="$errors->first('end_time')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="available_seats" :value="__('Available Seats')"/>
            <x-text-input id="available_seats" name="available_seats" type="number" class="mt-1 block w-full"
                          :value="old('available_seats') ?? 15" required autocomplete="available_seats"/>
            <x-input-error class="mt-2" :messages="$errors->first('available_seats')"/>
        </div>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
