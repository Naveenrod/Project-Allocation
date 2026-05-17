<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ url('/projects') }}" class="hover:text-gu-navy transition-colors">Projects</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">New Project</span>
        </div>
        <h1 class="section-title">Create Project</h1>
        <p class="section-subtitle">Submit a new WIL project for student allocation</p>
    </x-slot>

    <div class="page-wrapper max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="font-semibold text-gu-dark">Project Details</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('projects') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="form-group">
                        <label for="title" class="form-label">Project Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}"
                            class="form-input" placeholder="e.g. AI-powered patient triage system" required />
                        <x-input-error class="mt-1.5" :messages="$errors->get('title')" />
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-input resize-none"
                            placeholder="Describe the project goals, technologies involved, and what students will work on...">{{ old('description') }}</textarea>
                        <x-input-error class="mt-1.5" :messages="$errors->get('description')" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group">
                            <label for="team_size" class="form-label">Team Size</label>
                            <input id="team_size" name="team_size" type="number" min="3" max="6"
                                value="{{ old('team_size') }}"
                                class="form-input" placeholder="3–6" required />
                            <p class="text-xs text-gray-400 mt-1">Between 3 and 6</p>
                            <x-input-error class="mt-1.5" :messages="$errors->get('team_size')" />
                        </div>

                        <div class="form-group">
                            <label for="trimester" class="form-label">Trimester</label>
                            <select id="trimester" name="trimester" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1" {{ old('trimester') == '1' ? 'selected' : '' }}>Trimester 1</option>
                                <option value="2" {{ old('trimester') == '2' ? 'selected' : '' }}>Trimester 2</option>
                                <option value="3" {{ old('trimester') == '3' ? 'selected' : '' }}>Trimester 3</option>
                            </select>
                            <x-input-error class="mt-1.5" :messages="$errors->get('trimester')" />
                        </div>

                        <div class="form-group">
                            <label for="year" class="form-label">Year</label>
                            <select id="year" name="year" class="form-select" required>
                                <option value="">Select</option>
                                <option value="2023" {{ old('year') == '2023' ? 'selected' : '' }}>2023</option>
                                <option value="2024" {{ old('year') == '2024' ? 'selected' : '' }}>2024</option>
                                <option value="2025" {{ old('year') == '2025' ? 'selected' : '' }}>2025</option>
                                <option value="2026" {{ old('year') == '2026' ? 'selected' : '' }}>2026</option>
                            </select>
                            <x-input-error class="mt-1.5" :messages="$errors->get('year')" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project_files" class="form-label">Supporting Files <span class="font-normal text-gray-400">(optional)</span></label>
                        <input id="project_files" name="project_files[]" type="file"
                            class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gu-navy/10 file:text-gu-navy hover:file:bg-gu-navy/20"
                            multiple accept=".jpg,.jpeg,.png,.pdf" />
                        <p class="text-xs text-gray-400 mt-1">Images (JPG, PNG) or PDF documents. Max 2MB each.</p>
                        <x-input-error class="mt-1.5" :messages="$errors->get('project_files.*')" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ url('/projects') }}" class="btn-secondary">Cancel</a>
                        <x-primary-button>Create Project</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
