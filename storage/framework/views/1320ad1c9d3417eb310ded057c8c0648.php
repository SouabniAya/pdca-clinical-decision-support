<?php $__env->startSection('title', 'Patient Details'); ?>

<?php ($active = 'patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="pd-page">

    
    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1>Ahmed Benali</h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">ID: P00128</span>
                    <span class="pd-header__status">Active</span>
                </div>
                <div class="pd-header__sub">
                    <span>62 years</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="14" r="5" stroke="currentColor" stroke-width="1.6"/><path d="M14 10l6-6M14 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>12/05/2024</span>
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <div class="pd-header__doctor">
                <span>Responsible Doctor</span>
                <strong>Dr. Taieb</strong>
            </div>
            <a href="#" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 21h4l11-11-4-4L4 17v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                Edit Patient
            </a>
            <button type="button" class="pd-btn pd-btn--icon" aria-label="More options">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
            </button>
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
                                <strong class="pd-clinical__value">Locally Advanced</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Clinical Stage</span>
                                <strong class="pd-clinical__value">III</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Performance Status (ECOG)</span>
                                <strong class="pd-clinical__value">1</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">CA19-9</span>
                                <strong class="pd-clinical__value">350 U/mL</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Major Comorbidities</span>
                                <strong class="pd-clinical__value">Hypertension</strong>
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
                                <strong class="pd-clinical__value">None</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Distant Metastases</span>
                                <strong class="pd-clinical__value">No</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Vascular Involvement</span>
                                <strong class="pd-clinical__value">Yes (Mesenteric Vein)</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Weight / BMI</span>
                                <strong class="pd-clinical__value">72 kg / 24.1</strong>
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

                <span class="pd-consult__upcoming-label">Upcoming Consultation</span>
                <div class="pd-consult__box">
                    <strong>18/05/2024 &middot; 10:00</strong>
                    <span>Oncology Department</span>
                    <span class="pd-consult__doctor">Dr. Taieb</span>
                </div>

                <a href="#" class="pd-link pd-link--right">View Schedule &rarr;</a>
            </div>

        </div>

        
        <aside class="pd-side">

            <div class="pd-card">
                <h2 class="pd-card__title pd-card__title--no-icon">Recommendation generated</h2>
                <p class="pd-card__subtitle">Based on patient data and clinical rules</p>

                <div class="pd-recommendation">
                    <span class="pd-recommendation__label">RECOMMENDED TREATMENT</span>
                    <div class="pd-recommendation__body">
                        <span class="pd-recommendation__icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.6"/><path d="M12 11v5M9.5 13.5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <strong>Induction Chemotherapy</strong>
                            <span>mFOLFIRINOX</span>
                        </div>
                    </div>
                    <p class="pd-recommendation__meta">Generated on <strong>12/05/2024</strong> at <strong>14:30</strong></p>
                </div>

                <div class="pd-recommendation__actions">
                    <a href="<?php echo e(route('patients.clinical-explanation', 1)); ?>" class="pd-btn pd-btn--outline pd-btn--block">View Explanation</a>
                    <a href="#" class="pd-btn pd-btn--primary pd-btn--block">View Details</a>
                </div>
            </div>

            <div class="pd-card">
                <h2 class="pd-card__title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Modification History
                </h2>

                <ul class="pd-timeline">
                    <li>
                        <span class="pd-timeline__dot pd-timeline__dot--edit">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        </span>
                        <div>
                            <span class="pd-timeline__date">12/05/2024 at 14:30</span>
                            <strong class="pd-timeline__label">Clinical data updated</strong>
                        </div>
                    </li>
                    <li>
                        <span class="pd-timeline__dot pd-timeline__dot--add">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <span class="pd-timeline__date">12/05/2024 at 10:15</span>
                            <strong class="pd-timeline__label">Recommendation generated</strong>
                        </div>
                    </li>
                    <li>
                        <span class="pd-timeline__dot pd-timeline__dot--user">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <span class="pd-timeline__date">12/05/2024 at 09:45</span>
                            <strong class="pd-timeline__label">Patient created</strong>
                        </div>
                    </li>
                </ul>
            </div>

        </aside>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/details.blade.php ENDPATH**/ ?>