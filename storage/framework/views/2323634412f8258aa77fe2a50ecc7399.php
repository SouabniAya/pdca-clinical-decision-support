<?php $__env->startSection('title', 'Recommendation Detail'); ?>

<?php ($active = 'recommendations'); ?>

<?php $__env->startSection('content'); ?>
<div class="pd-page">

    
    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1><?php echo e($rec['patient_name']); ?></h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">Record #<?php echo e($rec['dossier_id']); ?></span>
                    <span class="pd-header__status">Consultation on <?php echo e($rec['consultation_date']); ?></span>
                </div>
                <div class="pd-header__sub">
                    <span><?php echo e($rec['age']); ?> years</span>
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <div class="pd-header__doctor">
                <span>Responsible Doctor</span>
                <strong><?php echo e($rec['doctor']); ?></strong>
            </div>
        </div>
    </div>

    <div class="pd-main">

            
            <div class="pd-clinical-grid">

                
                <div class="pd-card">
                    <h2 class="pd-card__title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        Clinical Evaluation
                    </h2>

                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Resectability</span>
                                <strong class="pd-clinical__value"><?php echo e($rec['stage_label']); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Performance Status (ECOG)</span>
                                <strong class="pd-clinical__value"><?php echo e($rec['clinical']['performance_status']); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">CA19-9</span>
                                <strong class="pd-clinical__value"><?php echo e($rec['clinical']['ca19_9']); ?> U/mL<?php echo e($rec['clinical']['cholestasis'] ? ' (cholestasis present)' : ''); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Bilirubin</span>
                                <strong class="pd-clinical__value"><?php echo e($rec['clinical']['bilirubin_elevated'] ? '≥ 1.5x ULN' : '< 1.5x ULN'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Comorbidities / Surgical CI</span>
                                <strong class="pd-clinical__value">
                                    <?php echo e(($rec['clinical']['severe_comorbidities'] || $rec['clinical']['surgical_contraindication']) ? 'Present' : 'None'); ?>

                                </strong>
                            </div>
                        </li>
                    </ul>
                </div>

                
                <div class="pd-card">
                    <h2 class="pd-card__title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        ABC Stratification
                    </h2>

                    <?php if($result['abc_type']): ?>
                        <div class="pd-abc-type">
                            <span>Resectability Type</span>
                            <strong><?php echo e($result['abc_type']); ?></strong>
                        </div>
                    <?php else: ?>
                        <p class="pd-card__subtitle">Not applicable to this resectability category.</p>
                    <?php endif; ?>

                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Criterion B (Biological)</span>
                                <strong class="pd-clinical__value">CA19-9 &gt; 500 U/mL, no cholestasis &mdash; <?php echo e((!$rec['clinical']['cholestasis'] && $rec['clinical']['ca19_9'] > 500) ? 'Present' : 'Absent'); ?></strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Criterion C (Clinical)</span>
                                <strong class="pd-clinical__value">ECOG &ge; 1 &mdash; <?php echo e($rec['clinical']['performance_status'] >= 1 ? 'Present' : 'Absent'); ?></strong>
                            </div>
                        </li>
                    </ul>

                    <?php if(!empty($result['transversal_note'])): ?>
                        <p class="pd-card__note"><?php echo e($result['transversal_note']); ?></p>
                    <?php endif; ?>
                </div>

            </div>

            
            <div class="pd-card pd-card--centered">
                <h2 class="pd-card__title pd-card__title--no-icon">Generated Recommendation</h2>
                <p class="pd-card__subtitle">Computed by the rule engine from the clinical evaluation above.</p>

                <?php if($result['conflict']): ?>
                    <div class="pd-conflict">
                        <strong>Ambiguous case &mdash; referred to RCP</strong>
                        <p><?php echo e($result['conflict_reason']); ?></p>
                    </div>
                <?php endif; ?>

                <div class="ce-table-wrap">
                    <table class="ce-table">
                        <thead>
                            <tr>
                                <th>Rule ID</th>
                                <th>Recommendation</th>
                                <th>Grade</th>
                                <th>Justification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="ce-table__rule-id"><?php echo e($result['rule_id']); ?></span></td>
                                <td><span class="ce-table__result"><?php echo e($result['recommendation']); ?></span></td>
                                <td><?php echo e($result['grade']); ?></td>
                                <td class="ce-table__justification"><?php echo e($result['justification']); ?></td>
                            </tr>
                            <?php if($result['overlay_rule']): ?>
                            <tr>
                                <td><span class="ce-table__rule-id"><?php echo e($result['overlay_rule']['rule_id']); ?></span></td>
                                <td><span class="ce-table__result"><?php echo e($result['overlay_rule']['recommendation']); ?></span></td>
                                <td><?php echo e($result['overlay_rule']['grade']); ?></td>
                                <td class="ce-table__justification"><?php echo e($result['overlay_rule']['justification']); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pd-justification">
                    <span>Source</span>
                    <strong>TNCD, Chapter 9, §<?php echo e($result['source']); ?></strong>
                </div>
            </div>

    </div>

    
    <div class="pd-action-bar">
        <a href="<?php echo e(route('recommendations.index')); ?>" class="pd-btn pd-btn--outline">Back to List</a>

        <form method="POST" action="<?php echo e(route('recommendations.reject', $rec['id'])); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="pd-btn pd-btn--outline pd-btn--block">Reject</button>
        </form>

        <form method="POST" action="<?php echo e(route('recommendations.rcp', $rec['id'])); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="pd-btn pd-btn--outline pd-btn--block">Send to RCP</button>
        </form>

        <form method="POST" action="<?php echo e(route('recommendations.validate', $rec['id'])); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="pd-btn pd-btn--primary pd-btn--block">Validate Recommendation</button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/recommendations/show.blade.php ENDPATH**/ ?>