@section('title', "MTMKay-Subscribers")
<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Subscribers Management')}}
        </h2>
    </x-slot>

    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row gap-3">

            <div class="basis-1/4 flex-auto">
                <x-input-label for="category" :value="__('Filter Status')" />
                <select id="status" name="status" onchange="filterByStatus()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a status</option>
                    <option value="ACTIVE">Active</option>
                    <option value="IN_ACTIVE">In Active</option>
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
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div>
                    <table class=" bg-white border-collapse w-full">
                        <thead>
                        <tr>
                            <th class="bg-blue-800 text-white border text-center px-3 py-2">S/N</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Email</th>
                            <th class="bg-blue-800 text-white border text-center px-4 py-2">Status</th>
                            <th class="bg-blue-800 text-white border text-center px-2 py-2">Subscription Date</th>
                         </tr>
                        </thead>
                        <tbody>
                        @foreach($subscribers as $key => $value)
                            <tr class="hover:bg-gray-100 focus:bg-gray-300 active:bg-gray-400"  tabindex="0">
                                <td class="border px-3 py-4 text-center">{{$key+1}}</td>
                                <td class="border px-4 py-4 text-center">{{$value->email}}</td>
                                <td class="{{$value->is_active ? 'border px-4 py-4 text-center text-green-700':'border px-4 py-4 text-center text-red-600'}}">{{$value->is_active ? 'Active':'In Active'}}</td>
                                <td class="border px-4 py-4 text-center">{{$value->created_at->format('D, d M Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(count($subscribers) == 0)
                        <h3 class="text-lg font-medium text-gray-900 p-5 text-center my-5">
                            Oops! No Subscriptions found
                        </h3>
                    @endif
                </div>

                
                <div class="max-w-7xl mx-auto  py-3 flex justify-end">
        @if(($subscribers->count() > 0))
            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                  {{$subscribers->links()}}
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


        $('#sort').on('change', function (e){
            let url = new URL(location.href);
            let searchParams = new URLSearchParams(url.search);


            searchParams.set('sort', e.target.value)

            url.search = searchParams.toString();

            location.href = url

        })



    })
</script>







