<x-modal name="add-program-outline-modal" :show="$errors->isNotEmpty()" focusable x-data="add-program-outline-modal">
    <div class="p-6">
        <form method="post" action="{{ route('program.create.outline', ['slug' => $program->slug ?? '']) }}" class="mt-6 space-y-6 ">
            @csrf
            <div id="add-outline-form" style="display: none" >
                <div class="basis-1/4 flex-auto">
                    <x-input-label for="period" :value="__('Period')" />
                    <select id="period" name="period"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose period</option>
                        @foreach($quarters ?? [] as $key => $quarter)
                            <option value="{{$quarter}}">{{$quarter}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <x-input-label for="topic" value="Topic" />
                    <textarea id="topic" name="topic" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{old('topic',$program->topic ?? '')}}</textarea>

                    <x-input-error class="mt-2" :messages="$errors->first('topic')" />
                </div>

                <div class="flex justify-end gap-4 mb-3 mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-modal>
