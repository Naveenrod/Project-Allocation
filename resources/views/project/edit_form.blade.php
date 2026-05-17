<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ url('/projects') }}" class="hover:text-gu-navy transition-colors">Projects</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ url('projects/' . $project->id) }}" class="hover:text-gu-navy transition-colors">{{ $project->title }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">Edit</span>
        </div>
        <h1 class="section-title">Edit Project</h1>
        <p class="section-subtitle">Update the details for this WIL project</p>
    </x-slot>

    <div class="page-wrapper max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="font-semibold text-gu-dark">Project Details</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('projects/' . $project->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title" class="form-label">Project Title</label>
                        <input id="title" name="title" type="text"
                            value="{{ old('title', $project->title) }}"
                            class="form-input" required />
                        <x-input-error class="mt-1.5" :messages="$errors->get('title')" />
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-input resize-none">{{ old('description', $project->description) }}</textarea>
                        <x-input-error class="mt-1.5" :messages="$errors->get('description')" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group">
                            <label for="team_size" class="form-label">Team Size</label>
                            <input id="team_size" name="team_size" type="number" min="3" max="6"
                                value="{{ old('team_size', $project->team_size) }}"
                                class="form-input" required />
                            <p class="text-xs text-gray-400 mt-1">Between 3 and 6</p>
                            <x-input-error class="mt-1.5" :messages="$errors->get('team_size')" />
                        </div>

                        <div class="form-group">
                            <label for="trimester" class="form-label">Trimester</label>
                            <select id="trimester" name="trimester" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1" {{ old('trimester', $project->trimester) == 1 ? 'selected' : '' }}>Trimester 1</option>
                                <option value="2" {{ old('trimester', $project->trimester) == 2 ? 'selected' : '' }}>Trimester 2</option>
                                <option value="3" {{ old('trimester', $project->trimester) == 3 ? 'selected' : '' }}>Trimester 3</option>
                            </select>
                            <x-input-error class="mt-1.5" :messages="$errors->get('trimester')" />
                        </div>

                        <div class="form-group">
                            <label for="year" class="form-label">Year</label>
                            <select id="year" name="year" class="form-select" required>
                                <option value="">Select</option>
                                <option value="2023" {{ old('year', $project->year) == 2023 ? 'selected' : '' }}>2023</option>
                                <option value="2024" {{ old('year', $project->year) == 2024 ? 'selected' : '' }}>2024</option>
                                <option value="2025" {{ old('year', $project->year) == 2025 ? 'selected' : '' }}>2025</option>
                                <option value="2026" {{ old('year', $project->year) == 2026 ? 'selected' : '' }}>2026</option>
                            </select>
                            <x-input-error class="mt-1.5" :messages="$errors->get('year')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ url('projects/' . $project->id) }}" class="btn-secondary">Cancel</a>
                        <x-primary-button>Save Changes</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
