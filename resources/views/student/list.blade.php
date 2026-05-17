<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="section-title">Students</h1>
                <p class="section-subtitle">Enrolled WIL students and their application status</p>
            </div>
        </div>
    </x-slot>

    <div class="page-wrapper">
        <div class="grid gap-6 lg:grid-cols-3">

            <!-- Student list -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-gu-dark">All Students</h2>
                        <span class="badge-navy">{{ $students->total() }}</span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($students as $student)
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gu-light transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gu-navy/10 flex items-center justify-center text-gu-navy font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gu-dark text-sm">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $student->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if ($student->gpa)
                                        <span class="badge-gold text-xs">GPA {{ number_format($student->gpa, 1) }}</span>
                                    @endif
                                    <a href="{{ route('students.show', $student->id) }}" class="btn-secondary btn-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-gray-400 text-sm">No students enrolled yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($students->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Auto-assign panel (teacher only) -->
            <div class="space-y-5">
                <div class="card border-gu-navy/20">
                    <div class="card-header bg-gu-navy/5">
                        <h2 class="font-semibold text-gu-dark">Auto-Assignment</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-gray-500 mb-5">
                            Run the GPA-sorted assignment algorithm for a specific offering period. Students will be matched to their applied projects based on GPA priority and team capacity.
                        </p>
                        <form method="POST" action="{{ route('auto-assign') }}" class="space-y-4">
                            @csrf

                            <div class="form-group">
                                <label for="year" class="form-label">Year</label>
                                <select id="year" name="year" class="form-select" required>
                                    <option value="">Select year</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="trimester" class="form-label">Trimester</label>
                                <select id="trimester" name="trimester" class="form-select" required>
                                    <option value="">Select trimester</option>
                                    <option value="1">Trimester 1</option>
                                    <option value="2">Trimester 2</option>
                                    <option value="3">Trimester 3</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-gold w-full justify-center"
                                onclick="return confirm('Run auto-assignment for the selected period? This will reset any existing assignments for that offering.')">
                                Run Auto-Assignment
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
