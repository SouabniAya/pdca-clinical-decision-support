<?php $__env->startSection('title', 'Reports'); ?>

<?php($active = 'reports')

@section('content')

<div class="rp-page">

    {{-- ================================================================
         Page Header
         ================================================================ --}}
    <div class="rp-header">

        <div class="rp-header__left">
            <h1>Reports</h1>

            <p class="rp-header__sub">
                View and manage clinical reports.
            </p>
        </div>

        <div class="rp-header__right">

            <a href="{{ url('/reports') }}" class="pd-btn pd-btn--secondary">
                Refresh
            </a>

        </div>

    </div>


    {{-- ================================================================
         Filters
         ================================================================ --}}
    <form
        method="GET"
        action="{{ route('reports.index') }}"
        class="rp-filters"
    >

        <div class="rp-filters__group">

            <label for="report-search">
                Search
            </label>

            <input
                id="report-search"
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Patient or report..."
            >

        </div>


        <div class="rp-filters__group">

            <label for="report-doctor">
                Doctor
            </label>

            <select id="report-doctor" name="doctor">

                <option value="">
                    All doctors
                </option>

                @foreach($doctors as $doctor)

                    @php
                        $doctorId = is_array($doctor)
                            ? ($doctor['id'] ?? '')
                            : ($doctor->id ?? '');

                        $doctorName = is_array($doctor)
                            ? ($doctor['name'] ?? 'Unknown')
                            : ($doctor->name ?? 'Unknown');
                    ?>

                    <option
                        value="<?php echo e($doctorId); ?>"
                        <?php if((string) request('doctor') === (string) $doctorId): echo 'selected'; endif; ?>
                    >
                        <?php echo e($doctorName); ?>

                    </option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>

        </div>


        <div class="rp-filters__group">

            <label for="report-status">
                Status
            </label>

            <select id="report-status" name="status">

                <option value="">
                    All statuses
                </option>

                <option
                    value="completed"
                    <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>
                >
                    Completed
                </option>

                <option
                    value="pending"
                    <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>
                >
                    Pending
                </option>

                <option
                    value="failed"
                    <?php if(request('status') === 'failed'): echo 'selected'; endif; ?>
                >
                    Failed
                </option>

            </select>

        </div>


        <div class="rp-filters__group">

            <label for="report-date">
                Date
            </label>

            <input
                id="report-date"
                type="date"
                name="date"
                value="<?php echo e(request('date')); ?>"
            >

        </div>


        <div class="rp-filters__actions">

            <button
                type="submit"
                class="pd-btn pd-btn--primary"
            >
                Apply Filters
            </button>

            <a
                href="<?php echo e(route('reports.index')); ?>"
                class="pd-link"
            >
                Clear
            </a>

        </div>

    </form>


    
    <div class="rp-stats">

        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M6 3h9l3 3v15H6V3Z"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M14 3v4h4M9 11h6M9 15h6"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />
                </svg>

            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Total Reports
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['total'] ?? count($reports ?? [])); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M5 12l4 4L19 6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Completed
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['completed'] ?? 0); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="8"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    <path
                        d="M12 8v4l2.5 2"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />
                </svg>

            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Pending
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['pending'] ?? 0); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="8"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    <path
                        d="M9 9l6 6M15 9l-6 6"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />
                </svg>

            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Failed
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['failed'] ?? 0); ?>

                </strong>

            </div>

        </div>

    </div>


    
    <div class="pd-card">

        <div class="pd-card__title">
            Reports Overview
        </div>

        <div class="rp-chart-placeholder">

            <span>
                Reports activity will appear here.
            </span>

        </div>

    </div>


    
    <div class="pd-card">

        <div class="pd-card__title">
            Clinical Reports
        </div>


        <div style="overflow-x: auto;">

            <table class="rp-table">

                <thead>

                    <tr>
                        <th>
                            Report
                        </th>

                        <th>
                            Patient
                        </th>

                        <th>
                            Doctor
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="rp-table__actions">
                            Actions
                        </th>
                    </tr>

                </thead>


                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php

                            $reportId = is_array($report)
                                ? ($report['id'] ?? null)
                                : ($report->id ?? null);

                            $reportTitle = is_array($report)
                                ? ($report['title'] ?? $report['name'] ?? 'Clinical Report')
                                : ($report->title ?? $report->name ?? 'Clinical Report');

                            $patientName = is_array($report)
                                ? ($report['patient'] ?? $report['patient_name'] ?? 'Unknown patient')
                                : ($report->patient ?? $report->patient_name ?? 'Unknown patient');

                            $doctorName = is_array($report)
                                ? ($report['doctor'] ?? $report['doctor_name'] ?? 'Unknown doctor')
                                : ($report->doctor ?? $report->doctor_name ?? 'Unknown doctor');

                            $reportDate = is_array($report)
                                ? ($report['date'] ?? $report['created_at'] ?? null)
                                : ($report->date ?? $report->created_at ?? null);

                            $status = is_array($report)
                                ? strtolower($report['status'] ?? 'pending')
                                : strtolower($report->status ?? 'pending');

                        ?>


                        <tr>

                            
                            <td>

                                <strong>
                                    <?php echo e($reportTitle); ?>

                                </strong>

                            </td>


                            
                            <td>
                                <?php echo e($patientName); ?>

                            </td>


                            
                            <td>
                                <?php echo e($doctorName); ?>

                            </td>


                            
                            <td>

                                <?php if($reportDate): ?>

                                    @try
                                        <?php echo e(\Carbon\Carbon::parse($reportDate)->format('d M Y')); ?>

                                    @catch(\Throwable $e)
                                        <?php echo e($reportDate); ?>

                                    @endtry

                                <?php else: ?>

                                    —

                                <?php endif; ?>

                            </td>


                            
                            <td>

                                <?php if($status === 'completed'): ?>

                                    <span class="rp-badge rp-badge--completed">
                                        Completed
                                    </span>

                                <?php elseif($status === 'failed'): ?>

                                    <span class="rp-badge rp-badge--failed">
                                        Failed
                                    </span>

                                <?php else: ?>

                                    <span class="rp-badge rp-badge--pending">
                                        Pending
                                    </span>

                                <?php endif; ?>

                            </td>


                            
                            <td class="rp-table__actions">

                                <?php if($reportId): ?>

                                    <a
                                        href="<?php echo e(route('reports.download', $reportId)); ?>"
                                        class="pd-link"
                                    >
                                        Download
                                    </a>

                                <?php else: ?>

                                    <span class="pd-link">
                                        View
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="6"
                                class="rp-table__empty"
                            >
                                No reports found.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/reports/index.blade.php ENDPATH**/ ?>