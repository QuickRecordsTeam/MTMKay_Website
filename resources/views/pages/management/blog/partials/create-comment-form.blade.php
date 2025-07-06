

<x-modal name="add-comment-modal" :show="$errors->isNotEmpty()" focusable x-data="add-comment-modal">
    <form method="post" action="{{ route('show.blog.comments.add', ['slug' => $blog->slug]) }}" class="p-6" >
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Blog Comment') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Provide Information below to add a comment.") }}
        </p>


        <div class="grow my-4">
            <x-input-label for="title" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name')" required autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->first('name')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email')" required autocomplete="email"/>
            <x-input-error class="mt-2" :messages="$errors->first('email')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="subject" :value="__('Subject')"/>
            <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full"
                          :value="old('subject')" required autocomplete="subject"/>
            <x-input-error class="mt-2" :messages="$errors->first('subject')"/>
        </div>

        <div class="my-4">
            <x-input-label for="message" :value="__('Message')"/>
            <textarea id="description" name="message" rows="4"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{old('message')}}  </textarea>
            <x-input-error class="mt-2" :messages="$errors->first('message')"/>
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
