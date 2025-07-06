@section('title', "MTMKay-Enrollment Management")
<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Enrollment Management')}}
        </h2>
    </x-slot>

    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row gap-3">
            <div class="basis-1/4 flex-auto">
                <x-input-label for="category" :value="__('Filter by Program')" />
                <select id="program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a program</option>

                    @foreach($programs as $program)
                        <option value="{{$program->slug}}">{{$program->title}}</option>
                    @endforeach
                    <option value="ALL">All</option>
                </select>
            </div>

            <div class="basis-1/4 flex-auto">
                <x-input-label for="category" :value="__('Filter Status')" />
                <select id="status" name="status" onchange="filterByStatus()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a status</option>
                     <option value="COMPLETED">Completed Payment</option>
                    <option value="IN_COMPLETE">In Completed Payment</option>
                    <option value="ALL">ALL</option>
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
    <div class="flex justify-center mt-5">
        <x-auth-session-status :status="session('status')" x-data="{ show: true }"
                               x-show="show"
                               x-init="setTimeout(() => show = false, 3000)" class="pt-1 pl-5">
        </x-auth-session-status>
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
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Email</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Program</th>
                            <th class="bg-blue-800 text-white border text-center px-2 py-2">Enrollment Date</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Fee Status</th>
                            <th class="bg-blue-800 text-white border text-center  py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trainees as $key => $value)
                            <tr class="hover:bg-gray-100 focus:bg-gray-300 active:bg-gray-400"  tabindex="0">
                                <td class="border text-center py-4">{{$key+1}}</td>
                                <td class="border px-4 py-4">{{$value->user->name ?? ''}}</td>
                                <td class="border px-4 py-4">{{$value->user->email ?? ''}}</td>
                                <td class="border px-4 py-4  ">{{$value->trainingSlot->program->title ?? ''}}</td>
                                <td class="border px-4 py-4 ">{{$value->enrollment_date ?? $value->user->enrollment_date->format('D, d M Y') }}</td>
                                @if($value->has_completed_payment)
                                    <td class="border px-4 py-4 text-green-700 text-center w-20">Complete</td>
                                @else
                                    <td class="border px-4 py-4 text-yellow-600 text-center w-20">Incomplete</td>
                                @endif
                                <td class="border  py-4 text-center cursor-pointer">
                                    <x-dropdown align="right" width="48" style="z-index: 5">
                                        <x-slot name="trigger">
                                            <span><i class="fa fa-bars"></i></span>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link href="{{route('manage-students.view.info', ['slug' => $value->slug])}}">
                                                <span><i class="fa fa-user   cursor-pointer mr-5 "></i>{{ __('Profile') }}</span>
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{route('manage-students.view.payments', ['slug' => $value->slug])}}">
                                                <span><i class="fa fa-money   cursor-pointer mr-5 "></i>{{ __('View Payments') }}</span>
                                            </x-dropdown-link>
                                             
                                            <x-dropdown-link   class="text-red-600" x-on:click.prevent="$dispatch('open-modal', 'confirm-trainee-deletion{{$value->id}}')">
                                                <span><i class="fa fa-trash text-red-600 cursor-pointer mr-6 "></i>{{ __('Remove') }}</span>
                                            </x-dropdown-link>
                                        </x-slot>
                                    </x-dropdown>
                                </td>
                            </tr>
                            @include('pages.management.trainee.delete-trainee')
                            @include('pages.management.trainee.payment')

                        @endforeach
                        </tbody>
                    </table>
                    @if(count($trainees) == 0)
                        <h3 class="text-lg font-medium text-gray-900 p-5 text-center my-5">
                            Oops! No enrollments found
                        </h3>
                    @endif
                </div>

                 
                <div class="max-w-7xl mx-auto  pb-3 flex justify-start">
        @if(($trainees->count() > 0))
        <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="m-5 p-5 flex justify-end">
                 {{$trainees->links()}}
            </div>
        </div>
        @endif
    </div>
            </div>
        </div>
    </div>



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

        $('#program_id').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);


            searchParams.set('program_slug', e.target.value)

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







