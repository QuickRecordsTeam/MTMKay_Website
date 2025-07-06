<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Enrollment') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Are you sure you want to delete this Enrollment?') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-enrollment-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-enrollment-deletion" :show="$errors->isNotEmpty()" focusable :data="$enrollment">
        <form method="post" action="{{ route('trainee.destroy', ['slug'=> $enrollment->slug]) }} " class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to this enrollment?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                 {{ __('Once deleted, all data will be lost?') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
