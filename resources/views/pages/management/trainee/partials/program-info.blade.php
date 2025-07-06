<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Program Information') }}
        </h2>
    </header>

    <div class="my-4">
        <x-input-label for="name" :value="__('Title')" />
        <p class="my-2 text-gray-900" >
            {{$enrollment->trainingSlot->program->title}}
        </p>
        <x-input-error class="mt-2" :messages="$errors->first('name')" />
    </div>

    <div class="my-4">
        <x-input-label for="duration" :value="__('Duration')" />
        <p class="my-2 text-gray-900">
            {{$enrollment->trainingSlot->program->duration}} Months
        </p>
        <x-input-error class="mt-2" :messages="$errors->first('duration')" />
    </div>

    <div class="my-4">
        <x-input-label for="cost" :value="__('Cost')" />
        <p class="my-2 text-gray-900">
            {{number_format($enrollment->trainingSlot->program->cost)}} XAF
        </p>
        <x-input-error class="mt-2" :messages="$errors->first('cost')" />
    </div>

    <div class="my-4">
        <x-input-label for="name" :value="__('Objective')" />
        <p class="my-3 text-gray-900 font-medium">
            {!! $enrollment->trainingSlot->program->objective !!}
        </p>
        <x-input-error class="mt-2" :messages="$errors->first('objective')" />
    </div>

    <div class="my-4">
        <x-input-label for="duration" :value="__('Enrollment Date')" />
        <p class="my-2 text-gray-900">
            {{$enrollment->trainingSlot->program->created_at->format('D, d M Y')}}
        </p>
    </div>

    <div class="my-4">
        <x-input-label for="duration" :value="__('Schedule Plan')" />
        <p class="my-2 text-gray-900">
            Name: {{$enrollment->trainingSlot->name}}
        </p>
        <p class="my-2 text-gray-900">
            Start Time: {{date('h:i A', strtotime($enrollment->trainingSlot->start_time))}}
        </p>
        <p class="my-2 text-gray-900">
            End Time: {{date('h:i A', strtotime($enrollment->trainingSlot->end_time))}}
        </p>
    </div>
</section>
