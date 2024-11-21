@if(session('error'))   
        <div class="container mt-4 alert alert-danger">
            {{ session('error') }}
        </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CREATE PROJECT') }}
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-5">
                        <form method="POST" action="{{ url('projects') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <x-input-label for="project_title" :value="__('PROJECT TITLE')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="project_title" :value="__('DESCRIPTION')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="team_size" :value="__('TEAM SIZE(3-6)')" />
                                <x-text-input id="team_size" name="team_size" type="text" class="mt-1 block w-full" value="{{ old('team_size') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('team_size')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="trimester" :value="__('TRIMESTER')" />
                                <select id="trimester" name="trimester" class="block mt-1 w-full">
                                    <option value="">Choose Option</option>
                                    <option value="1" {{ old('trimester') === '1' ? 'selected' : '' }}>Trimister 1</option>
                                    <option value="1" {{ old('trimester') === '2' ? 'selected' : '' }}>Trimister 2</option>
                                    <option value="3" {{ old('trimester') === '3' ? 'selected' : '' }}>Trimister 3</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('trimester')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="year" :value="__('YEAR')" />
                                <select id="year" name="year" class="block mt-1 w-full">
                                    <option value="">Choose Option</option>
                                    <option value="2023" {{ old('year') === '2023' ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ old('year') === '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ old('year') === '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ old('year') === '2026' ? 'selected' : '' }}>2026</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('year')" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="project_files" :value="__('UPLOAD FILE')" />
                                <x-text-input id="project_files" name="project_files" type="file" class="mt-1 block w-full" value="{{ old('team_size') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('project_files.*')" />
                            </div>
                            <br>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('CREATE PROJECT') }}</x-primary-button>
                            </div>

                    </div>
                </div>
            </div>
    
        <div>  
    <div>
</x-app-layout>
    
       

            <!-- Project Title -->
            {{-- <div class="mb-3">
                <label for="title" class="form-label">Project Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Description -->
            {{-- <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            {{-- <!-- Team Size -->
            <div class="mb-3">
                <label for="team_size" class="form-label">Team Size (3-6)</label>
                <input type="number" class="form-control @error('team_size') is-invalid @enderror" id="team_size" name="team_size" value="{{ old('team_size') }}">
                @error('team_size')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Trimester -->
            {{-- <div class="mb-3">
                <label for="trimester" class="form-label">Trimester (1-3)</label>
                <input type="number" class="form-control @error('trimester') is-invalid @enderror" id="trimester" name="trimester" value="{{ old('trimester') }}">
                @error('trimester')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Year -->
            {{-- <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}">
                @error('year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- File Upload -->
            {{-- <div class="mb-3">
                <label for="project_files" class="form-label">Upload Files</label>
                <input type="file" class="form-control-file @error('project_files.*') is-invalid @enderror" id="project_files" name="project_files[]" multiple>
                @error('project_files.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('CREATE PROJECT') }}</x-primary-button>
            </div>
        </form>
    </div> --}}

