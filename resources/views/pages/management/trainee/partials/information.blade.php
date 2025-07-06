<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("View profile information of the trainee.") }}
        </p>
    </header>

    <div class="my-4">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $enrollment->user->name)" required autofocus autocomplete="name" disabled />
        <x-input-error class="mt-2" :messages="$errors->first('name')" />
    </div>

    <div class="my-4">
        <x-input-label for="name" :value="__('Email')" />
        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', $enrollment->user->email)" required autofocus autocomplete="name" disabled />
        <x-input-error class="mt-2" :messages="$errors->first('email')" />
    </div>

    <div class="my-4">
        <x-input-label for="telephone" :value="__('Telephone')" />
        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone', $enrollment->user->telephone)" required autofocus autocomplete="name" disabled />
        <x-input-error class="mt-2" :messages="$errors->first('telephone')" />
    </div>

    <div class="my-4">
        <x-input-label for="address" :value="__('Address')" />
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $enrollment->user->address)" required autofocus autocomplete="address" disabled />
        <x-input-error class="mt-2" :messages="$errors->first('address')" />
    </div>

    <div class="my-4">
        <x-input-label for="role" :value="__('Role')" />
        <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $enrollment->user->role->name)" required autofocus autocomplete="address" disabled />
        <x-input-error class="mt-2" :messages="$errors->first('role')" />
    </div>
</section>
