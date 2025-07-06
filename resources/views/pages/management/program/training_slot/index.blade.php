@section('title', "MTMKay-Training Slot")
<x-app-layout >
    <x-slot name="header">
       <div class="flex justify-between">
           <header class="flex flex-row ">
               <a href="{{route('show.program', ['slug' => $program->slug])}}" >
                   <button id="goBack" class="text-blue-800 text-xl">
                       <span><i class="fa fa-arrow-left px-5"></i></span>
                   </button>
               </a>
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   {{__('Training Slot Management')}}
               </h2>
               <x-auth-session-status :status="session('status')"
                                      x-data="{ show: true }"
                                      x-show="show"
                                      x-init="setTimeout(() => show = false, 2000)" class="ml-4 pt-2">
               </x-auth-session-status>
           </header>

           <x-primary-button x-data="add-training-slot-modal" x-on:click.prevent="$dispatch('open-modal', 'add-training-slot-modal')">{{ __('Add Training Session') }}</x-primary-button>
       </div>
    </x-slot>

    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row gap-3">
            <div class="basis-1/4 flex-auto">
                <x-input-label for="category" :value="__('Filter Status')" />
                <select id="status" name="status" onchange="filterByStatus()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a status</option>
                    <option value="AVAILABLE">Available</option>
                    <option value="ALMOST_FULL">Almost full</option>
                    <option value="FULL">Full</option>
                    <option value="ALL">All</option>
                </select>
            </div>
            <div class="basis-1/4 flex-auto">
                <x-input-label for="sort" :value="__('Sort')" />
                <select id="sort" name="sort" onchange="sortBlogBy()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose sort</option>
                    <option value="DATE_DESC">Newest First</option>
                    <option value="DATE_ASC">Oldest First</option>
                    <option value="NAME">Name</option>
                </select>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-visible sm:rounded-lg">
                <div>
                    <table class=" bg-white border-collapse w-full">
                        <thead>
                        <tr>
                            <th class="bg-blue-800 text-white border text-center px-1 py-2">S/N</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Name</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Start Time</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">End Time</th>
                            <th class="bg-blue-800 text-white border text-center px-2 py-2">Available Seats</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Status</th>
                            <th class="bg-blue-800 text-white border text-center  py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($training_slots as $key => $value)
                            <tr class="hover:bg-gray-100 focus:bg-gray-300 active:bg-gray-400"  tabindex="0">
                                <td class="border text-center py-4">{{$key+1}}</td>
                                <td class="border px-4 py-4 text-center">{{$value->name ?? ''}}</td>
                                <td class="border px-4 py-4 text-center">{{$value->start_time ?? ''}}</td>
                                <td class="border px-4 py-4 text-center ">{{$value->end_time ?? ''}}</td>
                                <td class="border px-4 py-4 text-center ">{{$value->available_seats ?? ''}}</td>
                                @if($value->status == \App\Constant\ProgramEnrollmentStatus::AVAILABLE)
                                    <td class="border px-4 py-4 text-center text-green-700">{{$value->status }}</td>
                                @elseif($value->status == \App\Constant\ProgramEnrollmentStatus::ALMOST_FULL)
                                    <td class="border px-4 py-4 text-center text-yellow-500">{{str_replace('_', ' ', $value->status)}}</td>
                                @else
                                    <td class="border px-4 py-4 text-center text-red-600">{{$value->status }}</td>
                                @endif

                                <td class="border  py-4 text-center cursor-pointer">
                                    
                                    <div>
                    <x-secondary-button x-data="update-training-slot-modal"
                        x-on:click.prevent="$dispatch('open-modal', 'update-training-slot-modal{{$value->id}}')">
                        <i class="fa fa-pencil text-blue-800 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                    <x-secondary-button x-data="confirm-deletion" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion{{$value->id}}')" class="ml-3">
                        <i class="fa fa-trash text-red-700 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                </div>
                                </td>
                            </tr>
                            @include('pages.management.program.partials.edit-training-slot-modal')
                            @include('pages.management.program.partials.delete-training-slot-modal')

                        @endforeach
                        </tbody>
                    </table>
                    @if(count($training_slots) == 0)
                        <h3 class="text-lg font-medium text-gray-900 p-5 text-center my-5">
                            Oops! No training session found
                        </h3>
                    @endif
                </div>

                @if(($training_slots->count() > 0))
                    <div class="m-5 p-5 flex justify-end">
                        <nav aria-label="Page navigation example py-5">
                             
                        </nav>
                    </div>
                @endif

              <div class="max-w-7xl mx-auto  py-3 flex justify-end">
        @if(($training_slots->count() > 0))
            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                  {{$training_slots->links()}}
            </div>
        @endif
    </div>

                
            </div>
        </div>
    </div>

    @include('pages.management.program.partials.add-training-slot-modal')
</x-app-layout>

<script>
    $(document).ready(function() {

        $('#status').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);


            searchParams.set('filter', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })



        $('#sort').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);


            searchParams.set('sort', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })

        $('#goBack').on('click', function (e){
            history.back();
        })


    })
</script>







