<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une carte étudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('student-cards.store') }}">
                @csrf

                <!-- Users -->
                <div>
                    <x-input-label for="user_id" :value="__('Utilisateur')" />

                    <select
                        name="user_id"
                        id="user_id"
                    >
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id', ) == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="school" :value="__('Ecole')" />

                    <select
                        name="school"
                        id="school"
                    >
                        @foreach($schools as $school)
                            <option value="{{ $school->value }}" @selected(old('school', ) === $school->value)>{{ $school }}</option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('school')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />

                    <textarea id="description" class="block mt-1 w-full" name="description">{{ old('description') }}</textarea>

                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Internal -->
                <div class="block mt-4">
                    <label for="is_internal" class="inline-flex items-center">
                        <input
                            id="is_internal"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="is_internal"
                            @checked(old('is_internal'))
                        >
                        <span class="ml-2 text-sm text-gray-600">{{ __('Interne ?') }}</span>
                    </label>
                </div>

                <div>
                    <x-input-label for="date_of_birth" :value="__('Date de naissance')" />
                    <input
                        type="date"
                        name="date_of_birth"
                        id="date_of_birth"
                        value="{{ old('date_of_birth') }}"
                    />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Créer') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
