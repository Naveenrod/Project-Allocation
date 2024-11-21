@if(session('error'))   
<div class="container mt-4 alert alert-danger">
    {{ session('error') }}
</div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EDIT PROFILE') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form method="POST" action="{{ route('students.update', $student->id) }}">
                            @csrf
                            @method('PUT')
                            <!-- GPA -->
                            <div class="mb-3">
                                <div>
                                    <x-input-label class="font-semibold" for="gpa" :value="__('GPA')" /> 
                                    <x-text-input id="gpa" name="gpa" type="text" class="mt-1 block " :value="old('gpa', $student->gpa) " required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('gpa')" />
                                </div>
                            </div>
                            <br>
                
                            <!-- Roles -->
                            <div class="mb-3">
                                <label for="roles" class="font-semibold">Roles:</label><br>
                                @foreach(['software_developer', 'project_manager', 'business_analyst', 'tester', 'client_liaison'] as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="{{ $role }}" name="roles[]" value="{{ $role }}" {{ in_array($role, $studentRoles) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <x-primary-button>{{ __('UPDATE') }}</x-primary-button>
                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

