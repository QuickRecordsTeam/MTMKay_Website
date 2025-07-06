@section('title', "MTMKay-Blog Comments")
<x-app-layout>

    <x-slot name="header" >
        <div class="flex flex-row justify-between">
            <div class="flex flex-row">
                <a href="{{route('show.blog', ['slug' => $blog->slug])}}" >
                    <button id="goBack" class="text-blue-800 text-xl">
                        <span><i class="fa fa-arrow-left px-5"></i></span>
                    </button>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Comments on the Blog Post: {{ $blog->title }}
                </h2>
            </div>
            <x-primary-button
                x-data="add-comment-modal"
                x-on:click.prevent="$dispatch('open-modal', 'add-comment-modal')"
            >{{ __('Add Comment') }}</x-primary-button>
            @include('pages.management.blog.partials.create-comment-form')
        </div>
    </x-slot>

    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row gap-3">
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
                    <option value="ALL">ALL</option>
                </select>
            </div>
        </div>
        <div class="flex flex-row justify-center pt-3">
            @if(session('status'))
                <x-auth-session-status :status="session('status')" x-data="{ show: true }"
                                       x-show="show"
                                       x-init="setTimeout(() => show = false, 2000)" class="pt-1 pl-5">
                </x-auth-session-status>
            @endif
        </div>
    </div>
    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-wrap w-full">
            <form method="get" action="{{ route('show.blog.comments', ['slug'  => $blog->slug]) }}" class="w-full">
                <div class="md:flex md:items-center">
                    <x-text-input id="search" name="search" type="text" class="mt-1 mr-2 block w-full" placeholder="Search blog by name, subject, email..." required autocomplete="search"/>
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 mr-2 block w-full d-none"  :value="$blog->slug" style="display: none" />
                    <x-primary-button
                    >{{ __('Search') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($comments as $comment)
                <div class="mb-lg-5 mt-4 border rounded-md p-5  flex-auto">
                    <div class="flex justify-between">
                        <x-input-label for="name" :value="__('Comment detail')" />
                        <div class="flex gap-4">
                            @if($comment->status == \App\Constant\BlogState::APPROVED)
                                <div class="mb-4 rounded-full bg-green-700 py-0.5 px-2.5 border border-transparent text-xs text-white transition-all shadow-sm  text-center cursor-pointer">
                                    {{$comment->status}}
                                </div>
                            @elseif($comment->status == \App\Constant\BlogState::REJECTED)
                                <div class="mb-4 rounded-full bg-red-700 py-0.5 px-2.5 border border-transparent text-xs text-white transition-all shadow-sm text-center cursor-pointer">
                                    {{$comment->status}}
                                </div>
                            @endif

                            <div>
                                @if($comment->status == \App\Constant\BlogState::PENDING)
                    <x-secondary-button  x-data="edit_comment{{$comment->id ?? ''}}"
                                                         x-on:click.prevent="$dispatch('open-modal', 'add-update-comment-modal{{$comment->id}}')">
                        <i class="fa fa-pencil text-blue-800 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                     
                    <x-secondary-button x-data="approve-blog-state{{$comment->id}}"
                                                     x-on:click.prevent="$dispatch('open-modal', 'approve-blog-state{{$comment->id}}', {name:'APPROVE'})" class="ml-3">
                        <i class="fa fa-check text-green-700 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                     
                    <x-secondary-button x-data="reject-blog-state-change{{$comment->id}}"
                                                     x-on:click.prevent="$dispatch('open-modal', 'reject-blog-state-change{{$comment->id}}', {name:'REJECT'})" class="ml-3">
                        <i class="fa fa-close text-yellow-500 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                    @endif
                    <x-secondary-button x-data="delete-blog-comment{{$comment->id}}"
                                                     x-on:click.prevent="$dispatch('open-modal', 'delete-blog-comment{{$comment->id}}', {name:'DELETE'})" class="ml-3">
                      <i class="fa fa-trash text-red-600 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>

                </div>
                            @include('pages.management.blog.blog-status-confirmation-modal')
                        </div>
                    </div>
                    <div class="grow my-4">
                        <x-input-label for="name" :value="__('Name')" /> <span><label class="font-medium">{{$comment->name}}</label></span>
                    </div>
                    <div class="grow my-4">
                        <x-input-label for="email" :value="__('Email')" /> <span><label class="font-medium">{{$comment->email}}</label></span>
                    </div>
                    @if($comment->status == \App\Constant\BlogState::PENDING)
                        <div class="grow my-4">
                            <x-input-label for="email" :value="__('Status')" /> <span><label class="font-medium text-lowercase text-sky-400">{{$comment->status}}</label></span>
                        </div>
                    @endif
                    <div class="grow my-4">
                        <x-input-label for="subject" :value="__('Subject')" /> <span><label class="font-medium">{{$comment->subject}}</label></span>
                    </div>
                    <div>
                        <x-input-label for="message" :value="__('Message')" /><span><p class="font-medium">{!! $comment->message !!}</p></span>
                     </div>
                </div>
            @endforeach
            @if(count($comments) == 0)
                <h3 class="text-lg font-medium text-gray-900 p-5 text-center my-5">
                    Oops! No Comments found for this blog post
                </h3>
            @endif
        </div>
    </div>

    @if(($comments->count() > 0))
        <div class="flex justify-center mb-4 pb-4">
            <nav aria-label="Page navigation example">
                <ul class="flex items-center -space-x-px h-10 text-base">
                    <li  class="{{$comments->currentPage() == 1 ? 'page-item disabled':'page-item'}}">
                        <a href="{{route('show.blog.comments', ['page' =>$comments->currentPage() - 1, 'slug'  => $blog->slug])}}" class="{{$comments->currentPage() == 1? 'cursor-not-allowed flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white':'flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'}}">
                            <span class="sr-only">Previous</span>
                            <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </a>
                    </li>
                    @for($i = 1; $i <= $comments->lastPage(); $i++)
                        <li>
                            <a href="{{route('show.blog.comments', ['page' => $i, 'slug'  => $blog->slug])}}" class="{{$comments->currentPage() == $i ?'flex items-center justify-center px-4 h-10 leading-tight text-white bg-blue-800 border border-blue-800 hover:bg-blue-800 hover:text-white dark:bg-blue-800 dark:border-blue-800 dark:text-white dark:hover:bg-blue-800 dark:hover:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'}}">
                                {{$i}}
                            </a>
                        </li>
                    @endfor

                    <li class="{{$comments->currentPage() == $comments->lastPage() ? 'page-item disabled': 'page-item'}}">
                        <a href="{{route('show.blog.comments', ['page' =>$comments->currentPage() + 1, 'slug'  => $blog->slug])}}" class="{{$comments->currentPage() == $comments->lastPage() ? 'cursor-not-allowed flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
:'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'}}">
                            <span class="sr-only">Next</span>
                            <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    @endif



</x-app-layout>


<script>

    let applyParams = function(sort, filtr, layt) {
        let url = new URL(location.href);
        let searchParams = new URLSearchParams(url.search);
        searchParams.set('filter', filtr);
        searchParams.set('sort', sort);
        searchParams.set('layout', layt);
        url.search = searchParams.toString();

        location.href = url
    }


    $(document).ready(function() {

        $('#status').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);

            searchParams.delete('search');
            searchParams.set('filter', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })

        $('#sort').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);

            searchParams.delete('search');
            searchParams.set('sort', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })



        $('#goBack').on('click', function (e){
            history.back();
        })
    })
</script>
