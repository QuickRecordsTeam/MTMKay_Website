@if(request()->routeIs('show.program'))
    @foreach($firstThreeOutlines as $outline)
        <div class="my-5 border-2 p-3 rounded-md">
            <div class="flex justify-between">
                <x-input-label for="period" value="{{$outline->period}}" />

                <div>
                    <x-secondary-button x-data="edit_outline{{$outline->id ?? ''}}"
                                         x-on:click.prevent="$dispatch('open-modal', 'edit_outline{{$outline->id ?? ''}}')">
                        <i class="fa fa-pencil text-blue-800 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                    <x-secondary-button x-data="delete_outline{{$outline->id ?? ''}}"
                                         x-on:click.prevent="$dispatch('open-modal', 'delete_outline{{$outline->id ?? ''}}')" class="ml-3">
                        <i class="fa fa-trash text-red-700 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                </div>
            </div>
            <div>{!! $outline->topic !!}</div>
        </div>
        @include('pages.management.program.partials.delete-outline')
        @include('pages.management.program.partials.edit-outline')
    @endforeach
@else
    @foreach($programOutlines as $outline)
        <div class="my-5 border-2 p-3 rounded-md">
            <div class="flex justify-between">
                <x-input-label for="period" value="{{$outline->period}}" />
                 
                <div>
                    <x-secondary-button x-data="edit_outline{{$outline->id ?? ''}}"
                                         x-on:click.prevent="$dispatch('open-modal', 'edit_outline{{$outline->id ?? ''}}')">
                        <i class="fa fa-pencil text-blue-800 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                    <x-secondary-button x-data="delete_outline{{$outline->id ?? ''}}"
                                         x-on:click.prevent="$dispatch('open-modal', 'delete_outline{{$outline->id ?? ''}}')" class="ml-3">
                        <i class="fa fa-trash text-red-700 cursor-pointer" style="font-size: medium"></i>
                    </x-secondary-button>
                </div>
            </div>
            <div>{!! $outline->topic !!}</div>
        </div>
        @include('pages.management.program.partials.delete-outline')
        @include('pages.management.program.partials.edit-outline')
    @endforeach
@endif
