@section('title', "MTMKay-Trainee Profile")
<x-app-layout >
    <x-slot name="header">
        <div class="flex justify-between">
            <header class="flex flex-row ">
                <a href="{{route('manage-students')}}" >
                    <button id="goBack" class="text-blue-800 text-xl">
                        <span><i class="fa fa-arrow-left px-5"></i></span>
                    </button>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{__('Trainee Profile')}}
                </h2>
            </header>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('pages.management.trainee.partials.information')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('pages.management.trainee.partials.program-info')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('pages.management.trainee.partials.payment-info')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('pages.management.trainee.partials.delete-trainee')
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







