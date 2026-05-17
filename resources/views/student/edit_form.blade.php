<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('students.show', $student->id) }}" class="hover:text-gu-navy transition-colors">{{ $student->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">Edit Profile</span>
        </div>
        <h1 class="section-title">Edit Profile</h1>
        <p class="section-subtitle">Update your academic details and preferred roles</p>
    </x-slot>

    <div class="page-wrapper max-w-xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="font-semibold text-gu-dark">Academic Details</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('students.update', $student->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- GPA -->
                    <div class="form-group">
                        <label for="gpa" class="form-label">GPA</label>
                        <p class="text-xs text-gray-400 mb-1.5">Enter your current GPA on a 0–7 scale</p>
                        <input id="gpa" name="gpa" type="number" step="0.01" min="0" max="7"
                            value="{{ old('gpa', $student->gpa) }}"
                            class="form-input w-40" required placeholder="e.g. 5.50" />
                        <x-input-error class="mt-1.5" :messages="$errors->get('gpa')" />
                    </div>

                    <!-- Roles -->
                    <div class="form-group">
                        <label class="form-label">Preferred Roles</label>
                        <p class="text-xs text-gray-400 mb-3">Select all roles that match your skills and experience</p>
                        <div class="space-y-2">
                            @foreach([
                                'software_developer' => 'Software Developer',
                                'project_manager'    => 'Project Manager',
                                'business_analyst'   => 'Business Analyst',
                                'tester'             => 'Tester / QA',
                                'client_liaison'     => 'Client Liaison',
                            ] as $value => $label)
                                <label for="{{ $value }}"
                                    class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-gu-navy/30 hover:bg-gu-light cursor-pointer transition-colors {{ in_array($value, $studentRoles) ? 'border-gu-navy/40 bg-gu-navy/5' : '' }}">
                                    <input type="checkbox" id="{{ $value }}" name="roles[]" value="{{ $value }}"
                                        {{ in_array($value, $studentRoles) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-gu-navy focus:ring-gu-navy" />
                                    <span class="text-sm font-medium text-gu-dark">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error class="mt-1.5" :messages="$errors->get('roles')" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('students.show', $student->id) }}" class="btn-secondary">Cancel</a>
                        <x-primary-button>Save Changes</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
