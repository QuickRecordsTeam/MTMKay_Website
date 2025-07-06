<x-modal name="confirm-blog-image-deletion{{$image->id}}" :show="$errors->isNotEmpty()" focusable x-data="confirm-blog-image-deletion">
    <form method="post" action="{{ route('confirm-blog-image-deletion', ['slug' => $blog->slug ?? '', 'imageSlug' => $image->slug]) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 text-left">
            {{ __('Are you sure you want to delete this blog image?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            <img src="{{ asset($blog->getImagePath($blog, $image->file_path)) }}"  >
        </p>



        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Image') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
