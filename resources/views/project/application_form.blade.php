<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ url('/projects') }}" class="hover:text-gu-navy transition-colors">Projects</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ url('projects/' . $project->id) }}" class="hover:text-gu-navy transition-colors">{{ $project->title }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">Apply</span>
        </div>
        <h1 class="section-title">Apply for Project</h1>
        <p class="section-subtitle">{{ $project->title }}</p>
    </x-slot>

    <div class="page-wrapper max-w-2xl mx-auto">
        <!-- Project summary -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gu-navy flex items-center justify-center text-white font-bold flex-shrink-0">
                        {{ strtoupper(substr($project->title, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gu-dark">{{ $project->title }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Trimester {{ $project->trimester }}, {{ $project->year }}
                            &bull; {{ $project->industryPartner->name }}
                            &bull; Team of {{ $project->team_size }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application form -->
        <div class="card">
            <div class="card-header">
                <h2 class="font-semibold text-gu-dark">Your Application</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/application/' . $project->id) }}">
                    @csrf

                    <div class="form-group mb-6">
                        <label for="justification" class="form-label">
                            Why are you a good fit for this project?
                        </label>
                        <p class="text-xs text-gray-400 mb-2">Describe your relevant skills, experience, and motivation. Be specific about what you can contribute.</p>
                        <textarea id="justification" name="justification" rows="5" required
                            class="form-input resize-none"
                            placeholder="Explain your relevant experience and why you're interested in this project...">{{ old('justification') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('justification')" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ url('projects/' . $project->id) }}" class="btn-secondary">Cancel</a>
                        <x-primary-button>Submit Application</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
