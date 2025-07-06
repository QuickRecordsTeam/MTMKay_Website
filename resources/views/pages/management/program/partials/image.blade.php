<div class="max-w-7xl">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Program Image') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Provide the program image.") }}
            </p>
        </header>
        @if(isset($program) && ! $is_first_time)
            <div class="grow w-3/4">
                <img src="{{ asset($program->getImagePath($program, $program->image_path)) }}" width="250px" height="250px" >
            </div>
        @endif
        <div class="w-full">
            <form method="post" action="{{ route($is_first_time ?'program.store.image': 'program.update.image', ['slug' => $program->slug ?? ""]) }}" class="mt-6 space-y-6 w-full"  enctype="multipart/form-data">
                @csrf

                <div class="w-full">
                    <x-input-label for="image_path" :value="__('Program Image')" />
                    <x-text-input id="image_path" name="image_path" type="file" class="mt-1 block w-full" :value="old('image_path', $program->image_path ?? '')" required    />
                    <x-input-error class="mt-2" :messages="$errors->first('image_path')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'program image updated successfully')
                         <x-auth-session-status :status="session('status')"  x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 3000)">

                         </x-auth-session-status>
                    @endif
                </div>
            </form>
        </div>
    </section>
</div>
