@if(session('error'))   
        <div class="container mt-4 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EDIT PROJECT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-5">
                        <form method="POST" action="{{ url('projects/'. $project->id) }}">
                            @csrf
                            @method('PUT')
                            <div>
                                <x-input-label for="project_title" :value="__('PROJECT TITLE')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $project->title) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="project_title" :value="__('DESCRIPTION')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description', $project->description) }}}" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="team_size" :value="__('TEAM SIZE(3-6)')" />
                                <x-text-input id="team_size" name="team_size" type="text" class="mt-1 block w-full" value="{{ old('team_size', $project->team_size) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('team_size')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="trimester" :value="__('TRIMESTER')" />
                                <select id="trimester" name="trimester" class="block mt-1 w-full">
                                    <option value="">Choose Option</option>
                                    <option value="1" {{ old('trimester', $project->trimester) === '1' ? 'selected' : '' }}>Trimister 1</option>
                                    <option value="1" {{ old('trimester', $project->trimester) === '2' ? 'selected' : '' }}>Trimister 2</option>
                                    <option value="3" {{ old('trimester', $project->trimester) === '3' ? 'selected' : '' }}>Trimister 3</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('trimester')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="year" :value="__('YEAR')" />
                                <select id="year" name="year" class="block mt-1 w-full">
                                    <option value="">Choose Option</option>
                                    <option value="2023" {{ old('year', $project->year) === '2023' ? 'selected' :''}}>2023</option>
                                    <option value="2024" {{ old('year', $project->year) === '2024' ? 'selected' : ''}}>2024</option>
                                    <option value="2025" {{ old('year', $project->year) === '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ old('year', $project->year) === '2026' ? 'selected' : '' }}>2026</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('year')" />
                            </div>
                            <br>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('UPDATE') }}</x-primary-button>
                            </div>

                    </div>
                </div>
            </div>
    
        <div>  
    <div>
</x-app-layout>
  