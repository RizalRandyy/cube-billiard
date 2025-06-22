@php
    $selectedRoleId = old('role_id', $user->roles->first()->id ?? '');
@endphp

<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <x-button target="" href="{{ route('admin.users.index') }}" variant="black" size="sm"
                class="justify-center gap-2">
                <x-icons.arrow-left class="w-4 h-4" aria-hidden="true" />
            </x-button>
            <h2 class="text-xl font-semibold leading-tight">
                @section('title', __('Edit Pengguna'))
                {{ __('Edit Pengguna') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <section class="bg-white">
            <div>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                        {{-- Name --}}
                        <div class="sm:col-span-2">
                            <x-form.input-label for="name" :value="__('Nama')"></x-form.input-label>
                            <x-form.input id="name" type="text" name="name"
                                value="{{ old('name', $user->name) }}" placeholder="Nama lengkap"
                                required></x-form.input>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Role --}}
                        <div class="sm:col-span-2">
                            <x-form.input-label for="role_id" :value="__('Role')" />

                            <x-form.select id="role_id" name="role_id" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ (string) $selectedRoleId === (string) $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </x-form.select>

                            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div class="w-full">
                            <x-form.input-label for="email" :value="__('Email')"></x-form.input-label>
                            <x-form.input id="email" type="email" name="email"
                                value="{{ old('email', $user->email) }}" placeholder="Email" required></x-form.input>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Phone --}}
                        <div class="w-full">
                            <x-form.input-label for="phone" :value="__('Nomor Telepon')"></x-form.input-label>
                            <x-form.input id="phone" type="tel" name="phone"
                                value="{{ old('phone', $user->phone) }}" placeholder="Nomor telepon" required
                                pattern="[0-9]{10,15}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"></x-form.input>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-4 sm:mt-6">
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-black hover:bg-gray-700 transition-all duration-300 ease-in-out rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</x-app-layout>
