<?php $__env->startSection('title', 'Clinical Data Entry'); ?>

<?php ($active = 'clinical-data'); ?>

<?php $__env->startSection('content'); ?>
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>Clinical Data Entry</h1>
            <?php if(!empty($patient)): ?>
                <p>Record or update the clinical assessment for <?php echo e($patient['name']); ?> — resectability, performance status, CA19-9 and comorbidities.</p>
            <?php else: ?>
                <p>Choose a patient below, then record their clinical assessment — resectability, performance status, CA19-9 and comorbidities.</p>
            <?php endif; ?>
        </div>
        <?php if(!empty($patient)): ?>
        <a href="<?php echo e(url('/patients/' . $patient['id'])); ?>" class="patients-page__btn patients-page__btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Patient File
        </a>
        <?php endif; ?>
    </div>

    <form class="clinical-form" method="POST" action="<?php echo e(!empty($patient) ? route('clinical-data.store', ['id' => $patient['id']]) : route('clinical-data.storeAny')); ?>">
        <?php echo csrf_field(); ?>
        <?php if(!empty($evaluation)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="clinical-form__error"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <?php if(empty($patient)): ?>
        
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c0-3.6 3.1-6 7-6s7 2.4 7 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Patient</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field clinical-form__field--full">
                    <label for="patient_id">Select patient</label>
                    <select id="patient_id" name="patient_id" required>
                        <option value="">Select a patient...</option>
                        <?php $__currentLoopData = ($patients ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p['id']); ?>" <?php if(old('patient_id') == $p['id']): echo 'selected'; endif; ?>>
                                <?php echo e($p['name']); ?> — <?php echo e($p['mrn']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if(empty($patients)): ?>
                        <p class="clinical-form__empty">No patients on record yet — add one from the Patients page first.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12h8M8 15h8M8 18h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Consultation</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="consultation_date">Consultation date</label>
                    <input
                        type="date"
                        id="consultation_date"
                        name="consultation_date"
                        value="<?php echo e(old('consultation_date', $evaluation['consultation_date'] ?? '')); ?>"
                        required
                    >
                </div>

                <div class="clinical-form__field">
                    <label for="performance_status">Performance status (ECOG / WHO)</label>
                    <select id="performance_status" name="performance_status" required>
                        <option value="">Select...</option>
                        <option value="0" <?php if(old('performance_status', $evaluation['performance_status'] ?? '') == '0'): echo 'selected'; endif; ?>>0 — Fully active</option>
                        <option value="1" <?php if(old('performance_status', $evaluation['performance_status'] ?? '') == '1'): echo 'selected'; endif; ?>>1 — Restricted in strenuous activity</option>
                        <option value="2" <?php if(old('performance_status', $evaluation['performance_status'] ?? '') == '2'): echo 'selected'; endif; ?>>2 — Ambulatory, up &gt;50% of waking hours</option>
                        <option value="3" <?php if(old('performance_status', $evaluation['performance_status'] ?? '') == '3'): echo 'selected'; endif; ?>>3 — Limited self-care, in bed &gt;50%</option>
                        <option value="4" <?php if(old('performance_status', $evaluation['performance_status'] ?? '') == '4'): echo 'selected'; endif; ?>>4 — Completely disabled</option>
                    </select>
                </div>

                <div class="clinical-form__field">
                    <label for="clinical_stage">Clinical stage</label>
                    <input
                        type="text"
                        id="clinical_stage"
                        name="clinical_stage"
                        placeholder="e.g. cT3N1M0"
                        value="<?php echo e(old('clinical_stage', $evaluation['clinical_stage'] ?? '')); ?>"
                    >
                </div>
            </div>
        </div>

        
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h2>Tumor Evaluation</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="resectability">Resectability status</label>
                    <select id="resectability" name="resectability" required>
                        <option value="">Select...</option>
                        <option value="resectable" <?php if(old('resectability', $evaluation['resectability'] ?? '') == 'resectable'): echo 'selected'; endif; ?>>Resectable</option>
                        <option value="borderline" <?php if(old('resectability', $evaluation['resectability'] ?? '') == 'borderline'): echo 'selected'; endif; ?>>Borderline</option>
                        <option value="locally_advanced" <?php if(old('resectability', $evaluation['resectability'] ?? '') == 'locally_advanced'): echo 'selected'; endif; ?>>Locally advanced</option>
                        <option value="metastatic" <?php if(old('resectability', $evaluation['resectability'] ?? '') == 'metastatic'): echo 'selected'; endif; ?>>Metastatic</option>
                    </select>
                </div>

                <div class="clinical-form__field">
                    <label for="ca19_9">CA19-9 level (U/mL)</label>
                    <input
                        type="number"
                        step="0.1"
                        min="0"
                        id="ca19_9"
                        name="ca19_9"
                        placeholder="e.g. 320.5"
                        value="<?php echo e(old('ca19_9', $evaluation['ca19_9'] ?? '')); ?>"
                    >
                </div>

                <div class="clinical-form__field">
                    <label for="ca19_9_date">CA19-9 measurement date</label>
                    <input
                        type="date"
                        id="ca19_9_date"
                        name="ca19_9_date"
                        value="<?php echo e(old('ca19_9_date', $evaluation['ca19_9_date'] ?? '')); ?>"
                    >
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="cholestasis" value="1" <?php if(old('cholestasis', $evaluation['cholestasis'] ?? false)): echo 'checked'; endif; ?>>
                        Cholestasis present <span>(affects CA19-9 interpretability)</span>
                    </label>
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="surgical_contraindication" value="1" <?php if(old('surgical_contraindication', $evaluation['surgical_contraindication'] ?? false)): echo 'checked'; endif; ?>>
                        Surgical contraindication
                    </label>
                </div>
            </div>
        </div>

        
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7-4.4-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.6-9.5 9-9.5 9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                <h2>Comorbidities</h2>
            </div>
            <div class="clinical-form__comorbidities">
                <?php $__empty_1 = true; $__currentLoopData = ($comorbidities ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comorbidity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="clinical-form__comorbidity-row">
                    <label class="clinical-form__checkbox">
                        <input
                            type="checkbox"
                            name="comorbidities[]"
                            value="<?php echo e($comorbidity['id']); ?>"
                            <?php if(in_array($comorbidity['id'], old('comorbidities', $selectedComorbidities ?? []))): echo 'checked'; endif; ?>
                        >
                        <?php echo e($comorbidity['label']); ?>

                    </label>
                    <select name="severity[<?php echo e($comorbidity['id']); ?>]">
                        <option value="">Severity</option>
                        <option value="mild">Mild</option>
                        <option value="moderate">Moderate</option>
                        <option value="severe">Severe</option>
                    </select>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="clinical-form__empty">No comorbidities on record for this patient yet.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                <h2>Additional Notes</h2>
            </div>
            <div class="clinical-form__field clinical-form__field--full">
                <textarea id="comment" name="comment" rows="4" placeholder="Optional clinical remarks..."><?php echo e(old('comment', $evaluation['comment'] ?? '')); ?></textarea>
            </div>
        </div>

        <div class="clinical-form__actions">
            <a href="<?php echo e(!empty($patient) ? url('/patients/' . $patient['id']) : url('/patients')); ?>" class="clinical-form__cancel">Cancel</a>
            <button type="submit" class="clinical-form__submit">Save Clinical Data</button>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/clinical-form.blade.php ENDPATH**/ ?>