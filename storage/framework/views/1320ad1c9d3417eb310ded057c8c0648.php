<?php $__env->startSection('title', 'Patient Details'); ?>

<?php ($active = 'patients'); ?>



<?php $__env->startSection('content'); ?>
<div class="pd-page">

    
    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">ID: P<?php echo e(str_pad($patient->patient_id, 5, '0', STR_PAD_LEFT)); ?></span>
                    <span class="pd-header__status"><?php echo e(ucfirst($patient->status)); ?></span>
                </div>
                <div class="pd-header__sub">
                    <span><?php echo e($patient->age); ?> years</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="14" r="5" stroke="currentColor" stroke-width="1.6"/><path d="M14 10l6-6M14 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span><?php echo e($patient->date_of_birth->format('d/m/Y')); ?></span>
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <div class="pd-header__doctor">
                <span>Responsible Doctor</span>
                <strong><?php echo e($latest && $latest->doctor ? $latest->doctor->name : 'Unassigned'); ?></strong>
            </div>
            <a href="<?php echo e(route('clinical-data.edit', $patient->patient_id)); ?>" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                Enter Clinical Data
            </a>
            <a href="<?php echo e(route('patients.edit', $patient->patient_id)); ?>" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 21h4l11-11-4-4L4 17v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                Edit Patient
            </a>
            <form method="POST" action="<?php echo e(route('patients.destroy', $patient->patient_id)); ?>" onsubmit="return confirm('Delete this patient? This cannot be undone.');" style="display:inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="pd-btn pd-btn--icon" aria-label="Delete patient">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7h12M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m-8 0v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="pd-layout">

        
        <div class="pd-main">

            
            <div class="pd-card">
                <h2 class="pd-card__title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    Clinical Data Summary
                </h2>

                <div class="pd-clinical">
                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Resectability Status</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->resectability_status ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Clinical Stage</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->clinical_stage ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Performance Status (ECOG)</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->ecog ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">CA19-9</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->ca19_9 ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Major Comorbidities</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->comorbidities ?? '—'); ?></strong>
                            </div>
                        </li>
                    </ul>
                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Surgical Contraindications</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->surgical_contraindications ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Distant Metastases</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->distant_metastases ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Vascular Involvement</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->vascular_involvement ?? '—'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Weight / BMI</span>
                                <strong class="pd-clinical__value"><?php echo e($latest->weight_bmi ?? '—'); ?></strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="pd-card">
                <div class="pd-consult__head">
                    <h2 class="pd-card__title pd-card__title--no-icon">Consultations &amp; Follow-up</h2>
                    <button type="button" class="pd-btn pd-btn--primary pd-btn--sm">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        Schedule Consultation
                    </button>
                </div>

                <?php if($latest): ?>
                    <span class="pd-consult__upcoming-label">Latest Consultation</span>
                    <div class="pd-consult__box">
                        <strong><?php echo e(optional($latest->consultation_date)->format('d/m/Y \\a\\t H:i') ?? '—'); ?></strong>
                        <span><?php echo e($latest->department ?? 'Not specified'); ?></span>
                        <span class="pd-consult__doctor"><?php echo e($latest->doctor->name ?? 'Unassigned'); ?></span>
                    </div>
                <?php else: ?>
                    <p style="color:#6b7280;font-size:14px;">No consultations recorded yet.</p>
                <?php endif; ?>

                <a href="#" class="pd-link pd-link--right">View Schedule &rarr;</a>
            </div>

        </div>

        
        <aside class="pd-side">

            
            <div class="pd-card">
                <h2 class="pd-card__title pd-card__title--no-icon">Recommendation generated</h2>
                <p class="pd-card__subtitle">Based on patient data and clinical rules</p>

                <p style="color:#6b7280;font-size:14px;">No recommendation available yet for this patient.</p>

                <div class="pd-recommendation__actions">
                    <a href="<?php echo e(route('patients.clinical-explanation', $patient->patient_id)); ?>" class="pd-btn pd-btn--outline pd-btn--block">View Explanation</a>
                    <a href="#" class="pd-btn pd-btn--primary pd-btn--block">View Details</a>
                </div>
            </div>

            
            <div class="pd-card">
                <h2 class="pd-card__title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Modification History
                </h2>

                <p style="color:#6b7280;font-size:14px;">No activity history available yet.</p>
            </div>

        </aside>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/details.blade.php ENDPATH**/ ?>