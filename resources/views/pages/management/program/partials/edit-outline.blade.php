<x-modal name="edit_outline{{$outline->id}}" :show="$errors->isNotEmpty()" focusable x-data="edit-outline">
    <form method="post" action="{{ route('program.update.outline', ['slug' => $program->slug, 'outlineSlug' => $outline->slug]) }}" class="p-6" >
        @csrf
        @method('put')
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Program Outline') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Provide Information below to update program outline.") }}
        </p>


        <div class="grow my-4">
            <x-input-label for="period" :value="__('Period')" />
            <select id="period" name="period"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choose period</option>
                @foreach($allQuarters as $key => $quarter)
                    <option value="{{$quarter}}" {{$outline->period === $quarter ? 'selected': ''}}>{{$quarter}}</option>
                @endforeach
            </select>
        </div>


        <div class="grow my-4">
            <x-input-label for="topic" :value="__('Topic')"/>
            <textarea id="topic" name="topic" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>{{old('topic',$outline->topic ?? '')}}</textarea>
            <x-input-error class="mt-2" :messages="$errors->first('topic')"/>
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
