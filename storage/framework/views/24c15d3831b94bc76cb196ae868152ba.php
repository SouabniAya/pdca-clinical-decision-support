<?php $__env->startSection('title', 'Dashboard'); ?>

<?php ($active = 'dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-page">

    <div class="dashboard-page__head">
        <div>
            <h1>Dashboard</h1>
            <p>Overview of patients, recommendations, and recent activity.</p>
        </div>
        <a href="<?php echo e(route('patients.index')); ?>" class="dashboard-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M2.5 19c0-3 2.9-4.7 6.5-4.7s6.5 1.7 6.5 4.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            View All Patients
        </a>
    </div>

    
    <div class="dashboard-stats">

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M2.5 19c0-3 2.9-4.7 6.5-4.7s6.5 1.7 6.5 4.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="16.5" cy="8.3" r="2.4" stroke="currentColor" stroke-width="1.6"/><path d="M14.6 19c.3-2.3 2.1-3.7 4.4-3.7s4.1 1.4 4.4 3.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Registered Patients</h3>
                <strong><?php echo e($stats['total']); ?></strong>
                <span>Total patients</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Active Patients</h3>
                <strong><?php echo e($stats['active']); ?></strong>
                <span>Currently active</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Recommendations</h3>
                <strong><?php echo e($stats['pending_recommendations']); ?></strong>
                <span>Awaiting review</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>New Patients</h3>
                <strong><?php echo e($stats['new_this_month']); ?></strong>
                <span>This month</span>
            </div>
        </div>

    </div>

    
    <div class="dashboard-grid">

        <div class="dashboard-grid__col">

            
            <div class="dashboard-card">
                <div class="dashboard-card__head">
                    <h2>Patients by Status</h2>
                    <span class="dashboard-card__subtitle">Distribution across all <?php echo e($statusBreakdown['total']); ?> patients</span>
                </div>

                <div class="dashboard-donut">
                    <svg viewBox="0 0 180 180" class="dashboard-donut__chart">
                        
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-neutral-100)" stroke-width="22"/>

                        
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-cerulean)" stroke-width="22"
                                stroke-dasharray="<?php echo e($statusBreakdown['active']['dasharray']); ?> <?php echo e($statusBreakdown['circumference']); ?>"
                                stroke-dashoffset="0"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-sky)" stroke-width="22"
                                stroke-dasharray="<?php echo e($statusBreakdown['inactive']['dasharray']); ?> <?php echo e($statusBreakdown['circumference']); ?>"
                                stroke-dashoffset="-<?php echo e($statusBreakdown['active']['dasharray']); ?>"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        <text x="90" y="84" text-anchor="middle" class="dashboard-donut__value"><?php echo e($statusBreakdown['total']); ?></text>
                        <text x="90" y="104" text-anchor="middle" class="dashboard-donut__label">Patients</text>
                    </svg>

                    <ul class="dashboard-donut__legend">
                        <li><span class="dashboard-donut__dot" style="background: var(--color-cerulean)"></span>Active <strong><?php echo e($statusBreakdown['active']['pct']); ?>%</strong></li>
                        <li><span class="dashboard-donut__dot" style="background: var(--color-sky)"></span>Inactive <strong><?php echo e($statusBreakdown['inactive']['pct']); ?>%</strong></li>
                    </ul>
                </div>
            </div>

            
            <div class="dashboard-card">
                <div class="dashboard-card__head">
                    <h2>Recommendations to Review</h2>
                    <span class="dashboard-card__subtitle"><?php echo e($stats['pending_recommendations']); ?> recommendations awaiting clinician validation</span>
                </div>

                <ul class="dashboard-recos">

                    <?php $__empty_1 = true; $__currentLoopData = $pendingRecommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="dashboard-recos__item">
                            <div class="dashboard-recos__info">
                                <strong><?php echo e($item['patient_name']); ?></strong>
                                <span>
                                    Suggested: <?php echo e($item['recommendation_text'] ?? 'Pending analysis'); ?>

                                    <?php if($item['stage']): ?>
                                        &middot; <?php echo e($item['stage']); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                            <a href="<?php echo e(route('recommendations.show', $item['id'])); ?>" class="dashboard-recos__action">Review</a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="dashboard-recos__item">
                            <div class="dashboard-recos__info">
                                <span>No recommendations awaiting review.</span>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>

                <a href="<?php echo e(route('recommendations.index')); ?>" class="dashboard-activity__view-all">View All Recommendations</a>
            </div>

        </div>

        
        <div class="dashboard-card dashboard-card--activity">
            <div class="dashboard-card__head">
                <h2>Recent Activity</h2>
                <span class="dashboard-card__subtitle">Latest updates across patient records</span>
            </div>

            <ul class="dashboard-activity">

                <?php $__empty_1 = true; $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="dashboard-activity__item">
                        <span class="dashboard-activity__icon dashboard-activity__icon--<?php echo e($activity->icon); ?>">
                            <?php switch($activity->icon):
                                case ('new'): ?>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    <?php break; ?>
                                <?php case ('recommendation'): ?>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <?php break; ?>
                                <?php case ('status'): ?>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <?php break; ?>
                                <?php default: ?>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l4-1 10-10-3-3L5 16l-1 4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            <?php endswitch; ?>
                        </span>
                        <div class="dashboard-activity__body">
                            <p><?php echo $activity->message; ?></p>
                            <span>
                                <?php if($activity->detail): ?>
                                    <?php echo e($activity->detail); ?> &middot;
                                <?php endif; ?>
                                <?php echo e($activity->created_at->diffForHumans()); ?>

                            </span>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="dashboard-activity__item">
                        <div class="dashboard-activity__body">
                            <p>No recent activity yet.</p>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>

            <a href="<?php echo e(route('patients.index')); ?>" class="dashboard-activity__view-all">View All Patients</a>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/patients/dashboard.blade.php ENDPATH**/ ?>