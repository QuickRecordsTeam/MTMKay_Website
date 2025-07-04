@section('title', "MTMKay-Blogs Management")
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog Management') }}
            </h2>

            <a href="{{route('manage-blogs.create')}}">
                <x-primary-button
                >{{ __('Create Blog') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row gap-3">
            <div class="basis-1/4 flex-auto">
                <x-input-label for="category" :value="__('Filter by Category')" />
                <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->slug}}">{{$category->name}}</option>
                    @endforeach
                    <option value="ALL">ALL</option>
                </select>
            </div>
            <div class="basis-1/4 flex-auto">
                <x-input-label for="tag" :value="__('Filter by Tags')" />
                <select id="tag" name="tag"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a tag</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag}}">{{$tag->name}}</option>
                    @endforeach
                    <option value="ALL">ALL</option>
                </select>
            </div>
            <div class="basis-1/4 flex-auto">
                <x-input-label for="status" :value="__('Filter Status')" />
                <select id="status" name="status"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a status</option>
                    <option value="PENDING">PENDING</option>
                    <option value="APPROVED">APPROVED</option>
                    <option value="REJECTED">REJECTED</option>
                    <option value="ALL">ALL</option>
                </select>
            </div>
            <div class="basis-1/4 flex-auto">
                <x-input-label for="sort" :value="__('Sort')" />
                <select id="sort" name="sort"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose sort</option>
                    <option value="DATE_DESC">Newest First</option>
                    <option value="DATE_ASC">Oldest First</option>
                    <option value="NAME">Name</option>
                </select>
            </div>
        </div>
    </div>
    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-wrap w-full">
           <form method="get" action="{{ route('manage-blogs') }}" class="w-full">
               <div class="md:flex md:items-center">
                   <x-text-input id="search_title" name="search_title" type="text" class="mt-1 mr-2 block w-full" placeholder="Search blog by name..." required autocomplete="search"/>
                   <x-primary-button
                   >{{ __('Search') }}</x-primary-button>
               </div>
           </form>
        </div>
    </div>

    <div class="py-12">
        <h6 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-4">
            {{ __('Showing') }} {{count($blogs->items())}} / {{ $blogs->total() }} {{__('Blog Posts')}}
        </h6>
    </div>

    <div class="max-w-7xl mx-auto bg-white shadow-sm sm:rounded-lg py-5 px-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

            @foreach($blogs as $key => $blog)
            <div class="rounded overflow-hidden shadow-lg flex flex-col">
                <a href="{{route('show.blog', ['slug'=> $blog->slug])}}"></a>
                <div class="relative"><a href="{{route('show.blog', ['slug'=> $blog->slug])}}">
                        <img class="w-full"
                             src="{{asset($blog->getSingleBlogImage($blog->id))}}"
                             alt="Blog Image" height="50px">
                        <div
                            class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25">
                        </div>
                    </a>
                    <a href="{{route('show.blog', ['slug'=> $blog->slug])}}">
                        @if($blog->blog_state == \App\Constant\BlogState::PENDING)
                            <div
                                class="text-xs absolute top-0 right-0 bg-indigo-600 px-4 py-2 text-white mt-3 mr-3 hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                                {{$blog->blog_state}}
                            </div>
                        @elseif($blog->blog_state == \App\Constant\BlogState::APPROVED)
                            <div
                                class="text-xs absolute top-0 right-0 bg-indigo-600 px-4 py-2 text-white mt-3 mr-3 hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                                {{$blog->blog_state}}
                            </div>
                        @elseif($blog->blog_state == \App\Constant\BlogState::REJECTED)
                            <div
                                class="text-xs absolute top-0 right-0 bg-indigo-600 px-4 py-2 text-white mt-3 mr-3 hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                                {{$blog->blog_state}}
                            </div>
                        @endif

                    </a>
                </div>
                <div class="px-6 py-4 mb-auto">
                    <a href="{{route('show.blog', ['slug'=> $blog->slug])}}"
                       class="font-medium text-lg inline-block hover:text-indigo-600 transition duration-500 ease-in-out mb-2">{{$blog->title}}</a>
                    <p class="text-gray-500 text-sm">
                        {{substr($blog->stripDescriptionTags($blog->description), 0, 200)}}...
                    </p>
                </div>
                <div class="px-6 py-3 flex flex-row items-center justify-between bg-gray-100">
                <span href="#" class="py-1 text-xs font-regular text-gray-900 mr-1 flex flex-row items-center">
                    <svg height="13px" width="13px" version="1.1" id="Layer_1"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                         y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                         xml:space="preserve">
                        <g>
                            <g>
                                <path
                                    d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256 c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128 c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <span class="ml-1">{{$blog->created_at->format('D, d M Y')}}</span>
                </span>

                    <span href="#" class="py-1 text-xs font-regular text-gray-900 mr-1 flex flex-row items-center">
                    <svg class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                        </path>
                    </svg>
                    <span class="ml-1">{{count($blog->blogComments)}} Comments</span>
                </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="max-w-7xl mx-auto  py-3 flex justify-end">
        @if(($blogs->count() > 0))
            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                  {{$blogs->links()}}
            </div>
        @endif
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {

        // return urlObj.toString();

        $('#status').on('change', function (e){
            let url = new URL(location.href);

            let searchParams = new URLSearchParams(url.search);

            searchParams.delete('search_title');

            searchParams.set('filter', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })

        $('#tag').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);
            let parsedTag = JSON.parse(e.target.value);

            searchParams.set('tag', parsedTag.name)
            searchParams.set('tag_id', parsedTag.id)
            searchParams.delete('search_title');

            url.search = searchParams.toString();

            location.href = url

        })

        $('#category').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);
            searchParams.delete('search_title');

            searchParams.set('category_slug', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })

        $('#sort').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);
            searchParams.delete('search_title');

            searchParams.set('sort', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })

    })
</script>
