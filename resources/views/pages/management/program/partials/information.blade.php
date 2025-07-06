<div class="max-w-full">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Provide program Information.") }}
            </p>
        </header>

        <form method="post" action="{{ route(isset($program) ? 'program.update.information': 'manage-programs.store', ['slug' => $program->slug ?? ""]) }}" class="mt-6 space-y-6">
            @csrf
            @method('put')


            <div class="flex gap-4">
                <div class="grow">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $program->title ?? '')" required   autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->first('title')" />
                </div>

                <div class="grow">
                    <x-input-label for="trainer_name" :value="__('Trainer Name')" />
                    <x-text-input id="trainer_name" name="trainer_name" type="text" class="mt-1 block w-full" :value="old('trainer_name', $program->trainer_name ?? '')" required   autocomplete="trainer_name" />
                    <x-input-error class="mt-2" :messages="$errors->first('trainer_name')" />
                </div>
            </div>

            <div class="flex gap-4">
                <div class="grow">
                    <x-input-label for="duration" :value="__('Duration')" />
                    <x-text-input id="duration" name="duration" type="number" class="mt-1 block w-full" :value="old('duration', $program->duration ?? '')" required   autocomplete="duration" />
                    <x-input-error class="mt-2" :messages="$errors->first('duration')" />
                </div>


                <div class="grow">
                    <x-input-label for="cost" :value="__('Cost')" />
                    <x-text-input id="cost" name="cost" type="number" class="mt-1 block w-full" :value="old('cost', $program->cost ?? '')" required   autocomplete="cost" />
                    <x-input-error class="mt-2" :messages="$errors->first('cost')" />
                </div>
            </div>

            <div>
                <x-input-label for="objective" :value="__('Objective')" />
                <textarea id="objective" name="objective" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{old('objective', $program->objective ?? '')}}</textarea>
                <x-input-error class="mt-2" :messages="$errors->first('objective')" />
            </div>

            <div>
                <x-input-label for="eligibility" :value="__('Eligibility')" />
                <textarea id="eligibility" name="eligibility" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{old('eligibility',$program->eligibility ?? '')}}</textarea>

                <x-input-error class="mt-2" :messages="$errors->first('eligibility')" />
            </div>

            <div>
                <x-input-label for="training_resources" :value="__('Resources')" />
                <textarea id="training_resources" name="training_resources" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{old('training_resources', $program->training_resources ?? '')}}</textarea>

                <x-input-error class="mt-2" :messages="$errors->first('training_resources')" />
            </div>

            <div>
                <x-input-label for="job_opportunities" :value="__('Job Opportunities')" />
                <textarea id="job_opportunities" name="job_opportunities" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{old('job_opportunities', $program->job_opportunities ?? '')}}</textarea>

                <x-input-error class="mt-2" :messages="$errors->first('job_opportunities')" />
            </div>


            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'program information updated successfully')
                    <x-auth-session-status :status="session('status')"  x-data="{ show: true }"
                                           x-show="show"
                                           x-transition
                                           x-init="setTimeout(() => show = false, 2000)">

                    </x-auth-session-status>
                @endif
            </div>
        </form>
    </section>
</div>
