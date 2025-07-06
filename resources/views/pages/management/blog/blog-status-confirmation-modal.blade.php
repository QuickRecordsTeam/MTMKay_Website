<x-modal name="approve-blog-state{{$comment->id}}" :show="$errors->isNotEmpty()" focusable x-data="name">
    <form method="post" action="{{ route('show.blog.comments.update.status', ['slug' => $comment->slug, 'status' => \App\Constant\BlogState::APPROVED]) }}" class="p-6" >
        @csrf
        @method('put')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to approve this comment?') }}
        </h2>


        <p class="mt-1 text-md text-gray-600">
            Name: {{ $comment->name }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Email: {{ $comment->email }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Subject: {{ $comment->subject }}
        </p>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3 inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-blue-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ">
                {{ __('Approve') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

<x-modal name="reject-blog-state-change{{$comment->id}}" :show="$errors->isNotEmpty()" focusable x-data="name">
    <form method="post" action="{{ route('show.blog.comments.update.status', ['slug' => $comment->slug, 'status' => \App\Constant\BlogState::REJECTED]) }}" class="p-6" >
        @csrf
        @method('put')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to Reject this Comment?') }}
        </h2>

        <p class="mt-1 text-md text-gray-600">
            Name:  {{ $comment->name }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Email: {{ $comment->email }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Subject:  {{ $comment->subject }}
        </p>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-warning-button class="ms-3 rounded-full bg-red-500 py-0.5 px-2.5 border border-transparent text-xs text-white transition-all shadow-sm  text-center cursor-pointer">
                {{ __('Reject') }}
            </x-warning-button>
        </div>
    </form>
</x-modal>


<x-modal name="delete-blog-comment{{$comment->id}}" :show="$errors->isNotEmpty()" focusable x-data="name">
    <form method="post" action="{{ route('show.blog.comments.delete', ['slug' => $comment->slug]) }}" class="p-6" >
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to Delete this Comment?') }}
        </h2>


        <p class="mt-1 text-md text-gray-600">
            Name: {{ $comment->name }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Email: {{ $comment->email }}
        </p>
        <p class="mt-1 text-md text-gray-600">
            Subject: {{ $comment->subject }}
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

<x-modal name="add-update-comment-modal{{$comment->id}}" :show="$errors->isNotEmpty()" focusable x-data="name">
    <form method="post" action="{{ route('show.blog.comments.add', ['slug' => $blog->slug]) }}" class="p-6" >
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Blog Comment') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Provide Information below to add a comment.") }}
        </p>


        <div class="grow my-4">
            <x-input-label for="title" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $comment->name ?? '')" required autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->first('name')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $comment->email ?? '')" required autocomplete="email"/>
            <x-input-error class="mt-2" :messages="$errors->first('email')"/>
        </div>

        <div class="grow my-4">
            <x-input-label for="subject" :value="__('Subject')"/>
            <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full"
                          :value="old('subject', $comment->email ?? '')" required autocomplete="subject"/>
            <x-input-error class="mt-2" :messages="$errors->first('subject')"/>
        </div>

        <div class="my-4">
            <x-input-label for="message" :value="__('Message')"/>
            <textarea id="message" name="message" rows="4"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{old('message', $comment->message ?? '')}}  </textarea>
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






