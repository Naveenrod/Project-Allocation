<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ url('/projects') }}" class="hover:text-gu-navy transition-colors">Projects</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">{{ $project->title }}</span>
        </div>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="section-title">{{ $project->title }}</h1>
                <p class="section-subtitle">
                    Trimester {{ $project->trimester }}, {{ $project->year }}
                    &mdash; offered by <strong>{{ $project->industryPartner->name }}</strong>
                </p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                @if (auth()->user()->usertype === 'student')
                    <a href="{{ url('projects/' . $project->id . '/apply') }}" class="btn-primary">Apply Now</a>
                @elseif (auth()->user()->usertype === 'industry_partner' && auth()->user()->industryPartner->id === $project->industry_partner_id)
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn-secondary">Edit</a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                          onsubmit="return confirm('Delete this project? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="page-wrapper">
        <div class="grid gap-6 lg:grid-cols-3">

            <!-- Main info -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Description card -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-gu-dark">Project Overview</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700 leading-relaxed">{{ $project->description }}</p>

                        <div class="grid grid-cols-2 gap-4 mt-6 pt-5 border-t border-gray-100">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Team Size</p>
                                <p class="mt-1 font-semibold text-gu-dark">{{ $project->team_size }} students</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Offering</p>
                                <p class="mt-1 font-semibold text-gu-dark">Trimester {{ $project->trimester }}, {{ $project->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicants card -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-gu-dark">Applicants</h2>
                        <span class="badge-navy">{{ $project->applicants->count() }}</span>
                    </div>
                    <div class="card-body">
                        @forelse ($project->applicants as $applicant)
                            <div class="flex items-start gap-3 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="w-9 h-9 rounded-full bg-gu-navy/10 flex items-center justify-center text-gu-navy font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($applicant->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gu-dark text-sm">{{ $applicant->name }}</p>
                                    <p class="text-sm text-gray-500 mt-0.5 line-clamp-2">{{ $applicant->pivot->justification }}</p>
                                </div>
                                @if ($applicant->pivot->assigned)
                                    <span class="badge-green flex-shrink-0">Assigned</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">No applications received yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Images -->
                @if ($project->files->where('file_type', 'image')->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gu-dark">Images</h2>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($project->files->where('file_type', 'image') as $image)
                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                         alt="Project image"
                                         class="w-full h-40 object-cover rounded-lg border border-gray-100">
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PDFs -->
                @if ($project->files->where('file_type', 'pdf')->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gu-dark">Documents</h2>
                        </div>
                        <div class="card-body space-y-2">
                            @foreach ($project->files->where('file_type', 'pdf') as $pdf)
                                <a href="{{ asset('storage/' . $pdf->file_path) }}" target="_blank" rel="noopener noreferrer"
                                   class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-gu-navy/30 hover:bg-gu-light transition-colors group">
                                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-gray-700 group-hover:text-gu-navy transition-colors truncate">{{ basename($pdf->file_path) }}</span>
                                    <svg class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Industry Partner</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gu-navy flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($project->industryPartner->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gu-dark">{{ $project->industryPartner->name }}</p>
                                <a href="{{ url('industry-partners/' . $project->industryPartner->id) }}"
                                   class="text-xs text-gu-navy hover:underline">View profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body space-y-3">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Quick Stats</h3>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Team size</span>
                            <span class="font-semibold text-gu-dark">{{ $project->team_size }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Applications</span>
                            <span class="font-semibold text-gu-dark">{{ $project->applicants->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Assigned</span>
                            <span class="font-semibold text-gu-dark">{{ $project->assignedStudents->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Spots left</span>
                            <span class="font-semibold {{ ($project->team_size - $project->assignedStudents->count()) > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ max(0, $project->team_size - $project->assignedStudents->count()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
