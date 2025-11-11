<div class="amd-soft-empl-sidebar">
    <div class="amd-soft-empl-sidebar-step">

        @php
            $steps = [
                ['label' => 'Personal Info', 'route' => 'employee.create.basic', 'icon' => 'fas fa-user'],
                ['label' => 'Education', 'route' => 'employee.create.education', 'icon' => 'fas fa-graduation-cap'],
                ['label' => 'Work', 'route' => 'employee.create.work', 'icon' => 'fas fa-briefcase'],
                ['label' => 'Document', 'route' => 'employee.create.document', 'icon' => 'fas fa-file-alt'],
                ['label' => 'Bank', 'route' => 'employee.create.bank', 'icon' => 'fas fa-university'],
                ['label' => 'System Access', 'route' => 'employee.create.system.access', 'icon' => 'fas fa-key'],
            ];

            // Get current route suffix
            $currentRoute = request()->route()->getName() ?? '';
            $currentSuffix = substr(strrchr($currentRoute, '.'), 1) ?: '';
        @endphp

        @foreach ($steps as $index => $step)
            @php
                // Get suffix of step route
                $stepSuffix = substr(strrchr($step['route'], '.'), 1) ?: '';
                $isActive = $currentSuffix === $stepSuffix;
                $isClickable = isset($data['employeeId']);
                $isCompleted = $data['stepCompleted'][$index] ?? false;
            @endphp

            @if ($isClickable)
                {{-- top tabs  --}}
                <a href="{{ route($step['route'], ['employeeId' => $data['employeeId']]) }}"
                    class="amd-soft-empl-step-link">
                    <button
                        class="amd-btn amd-btn-primary amd-btn-xs emp-info-switch{{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }}"
                        data-step="{{ $index + 1 }}">
                        {{ $step['label'] }}<i class="{{ $step['icon'] }} "></i>
                    </button>
                </a>
            @else
                {{-- bottom tabs A,B,C --}}
                <button class="amd-soft-empl-step-circle disabled cursor-not-allowed opacity-60"
                    data-step="{{ $index + 1 }}" title="Complete Personal Info first" disabled>
                    {{ $step['label'] }}
                </button>
            @endif

            {{-- Render line between steps, except after the last one --}}
            @if ($index < count($steps) - 1)
                <div class="amd-soft-empl-line-segment">
                    <div class="amd-soft-empl-line-fill"></div>
                </div>
            @endif
        @endforeach

    </div>
</div>

<style>
    .amd-soft-empl-step-circle.completed {
        background-color: #2522c5;
        /* green-500 */
        color: #fff;
        border-color: #0d0b99;
    }
</style>
