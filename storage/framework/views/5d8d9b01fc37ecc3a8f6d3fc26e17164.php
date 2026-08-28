<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/pages/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="rp-page">

    
    <div class="rp-header">

        <div class="rp-header__left">
            <h1>Reports</h1>
            <p class="rp-header__sub">
                Analytics and exportable reports on patients,
                recommendations and clinical activity
            </p>
        </div>

        <div class="rp-header__right">

            <button type="button" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 9-9"/>
                    <path d="M3 4v8h8"/>
                </svg>
                Refresh
            </button>

           <button type="button" id="rp-export-btn" class="pd-btn pd-btn--primary">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">
                    <path d="M12 3v12"/>
                    <path d="M7 10l5 5 5-5"/>
                    <path d="M5 21h14"/>
                </svg>
                Export
            </button>

        </div>
    </div>


    
    <div class="pd-card rp-filters">

        <div class="rp-filters__group">
            <label for="rp-date-from">From</label>
            <input
                type="date"
                id="rp-date-from"
                name="date_from"
            >
        </div>

        <div class="rp-filters__group">
            <label for="rp-date-to">To</label>
            <input
                type="date"
                id="rp-date-to"
                name="date_to"
            >
        </div>

        <div class="rp-filters__group">
            <label for="rp-report-type">Report type</label>

            <select id="rp-report-type" name="report_type">
                <option value="">All types</option>
                <option value="patients">Patients</option>
                <option value="recommendations">Recommendations</option>
                <option value="consultations">Consultations</option>
                <option value="audit">Audit / Activity</option>
            </select>
        </div>

        <div class="rp-filters__group">
            <label for="rp-doctor">Doctor</label>

            <select id="rp-doctor" name="doctor">
                <option value="">All doctors</option>

                <?php $__currentLoopData = $doctors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option value="<?php echo e(data_get($doctor, 'id')); ?>">
                        <?php echo e(data_get($doctor, 'name')); ?>

                    </option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
        </div>

        <div class="rp-filters__actions">

            <button
                type="button"
                class="pd-btn pd-btn--primary pd-btn--sm">
                Apply filters
            </button>

            <button
                type="button"
                class="pd-btn pd-btn--outline pd-btn--sm">
                Reset
            </button>

        </div>

    </div>


    
    <div class="rp-stats">

        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Total patients
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['total_patients'] ?? '—'); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Recommendations generated
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['total_recommendations'] ?? '—'); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4"/>
                    <path d="M8 2v4"/>
                    <path d="M3 10h18"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Consultations scheduled
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['total_consultations'] ?? '—'); ?>

                </strong>

            </div>

        </div>


        
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Conflicts flagged
                </span>

                <strong class="rp-stat__value">
                    <?php echo e($stats['total_conflicts'] ?? '—'); ?>

                </strong>

            </div>

        </div>

    </div>


    
    <div class="pd-card rp-reports-card">

        <div class="rp-section-header">

            <div>
                <h2 class="pd-card__title pd-card__title--no-icon">
                    Generated reports
                </h2>

                <p class="pd-card__subtitle">
                    Previously generated report exports
                </p>
            </div>

        </div>


        
        <div class="rp-table-wrapper">

            <table class="rp-table">

                <thead>
                    <tr>
                        <th>Report name</th>
                        <th>Type</th>
                        <th>Date range</th>
                        <th>Generated by</th>
                        <th>Generated on</th>
                        <th>Status</th>
                        <th class="rp-table__actions-header">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $reports ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php
                            $reportId = data_get($report, 'id');
                            $reportName = data_get($report, 'name', 'Untitled report');
                            $reportType = data_get($report, 'type', '—');
                            $dateFrom = data_get($report, 'date_from');
                            $dateTo = data_get($report, 'date_to');
                            $generatedBy = data_get($report, 'generated_by', '—');
                            $createdAt = data_get($report, 'created_at');
                            $status = data_get($report, 'status', 'pending');
                        ?>

                        <tr>

                            
                            <td>
                                <span class="rp-report-name">
                                    <?php echo e($reportName); ?>

                                </span>
                            </td>


                            
                            <td>
                                <?php echo e($reportType); ?>

                            </td>


                            
                            <td>

                                <?php if($dateFrom || $dateTo): ?>

                                    <?php echo e($dateFrom ?: '—'); ?>

                                    <span class="rp-date-separator">—</span>
                                    <?php echo e($dateTo ?: '—'); ?>


                                <?php else: ?>

                                    —

                                <?php endif; ?>

                            </td>


                            
                            <td>
                                <?php echo e($generatedBy); ?>

                            </td>


                            
                            <td>

                                <?php if($createdAt): ?>

                                    <?php echo e($createdAt); ?>


                                <?php else: ?>

                                    —

                                <?php endif; ?>

                            </td>


                            
                            <td>

                                <?php
                                    $safeStatus = strtolower((string) $status);

                                    $allowedStatuses = [
                                        'completed',
                                        'pending',
                                        'failed'
                                    ];

                                    if (!in_array($safeStatus, $allowedStatuses)) {
                                        $safeStatus = 'pending';
                                    }
                                ?>

                                <span class="rp-badge rp-badge--<?php echo e($safeStatus); ?>">
                                    <?php echo e(ucfirst($status)); ?>

                                </span>

                            </td>


                            
                            
                            <td class="rp-table__actions">

                                <?php if($reportId): ?>

                                    <a
                                        href="<?php echo e(route('reports.download', $reportId)); ?>"
                                        class="rp-download-btn">
                                        Download
                                    </a>

                                <?php else: ?>

                                    <span class="rp-no-action">
                                        —
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="7"
                                class="rp-table__empty">

                                No reports have been generated yet.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const applyBtn = document.querySelector('.rp-filters__actions .pd-btn--primary');
    const resetBtn = document.querySelector('.rp-filters__actions .pd-btn--outline');
    const exportBtn = document.getElementById('rp-export-btn');

    function buildQuery() {
        const params = new URLSearchParams();
        const dateFrom = document.getElementById('rp-date-from').value;
        const dateTo = document.getElementById('rp-date-to').value;
        const doctor = document.getElementById('rp-doctor').value;

        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (doctor) params.append('doctor', doctor);

        return params.toString();
    }

    // Export button → downloads CSV for the selected report type
    exportBtn.addEventListener('click', function () {
        const type = document.getElementById('rp-report-type').value || 'patients';
        const query = buildQuery();
        const url = `/reports/export/${type}` + (query ? `?${query}` : '');
        window.location.href = url;
    });

    // Apply filters → reloads the page with filters as query params
    applyBtn.addEventListener('click', function () {
        const query = buildQuery();
        window.location.href = `<?php echo e(route('reports.index')); ?>` + (query ? `?${query}` : '');
    });

    // Reset → clears filters
    resetBtn.addEventListener('click', function () {
        window.location.href = `<?php echo e(route('reports.index')); ?>`;
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/patients/reports.blade.php ENDPATH**/ ?>