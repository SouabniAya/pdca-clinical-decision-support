<?php $__env->startSection('title', 'Clinical Explanation'); ?>

<?php ($active = 'patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="ce-page">

    <div class="ce-page__head">
        <div>
            <h1>Clinical Explanation</h1>
            <p>This page presents the clinical rule applied, the decision path followed, and the medical justification for the generated recommendation.</p>
        </div>

        <div class="ce-patient-card">
            <span class="ce-patient-card__avatar"></span>
            <div class="ce-patient-card__body">
                <strong><?php echo e(trim($patient->first_name . ' ' . $patient->last_name)); ?></strong>
                <div class="ce-patient-card__meta">
                    <span class="ce-patient-card__id">ID: P<?php echo e(str_pad($patient->patient_id, 5, '0', STR_PAD_LEFT)); ?></span>
                    <span class="ce-patient-card__status"><?php echo e(ucfirst($patient->status ?? 'active')); ?></span>
                    <span class="ce-patient-card__age"><?php echo e($patient->age); ?> years</span>
                    <span><?php echo e($patient->date_of_birth?->format('d/m/Y')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <?php if(!$recommendation): ?>

        <div class="ce-card">
            <h2 class="ce-card__title">No Recommendation Yet</h2>
            <p style="color:#6b7280;">This patient has no clinical evaluation on record, so no rule has been applied yet.</p>
            <a href="<?php echo e(route('clinical-data.edit', $patient->patient_id)); ?>" class="pd-btn pd-btn--primary" style="display:inline-flex; margin-top:12px;">Add Clinical Data</a>
        </div>

    <?php else: ?>

        <div class="ce-card">
            <h2 class="ce-card__title">Applied Clinical Rule</h2>

            <div class="ce-table-wrap">
                <table class="ce-table">
                    <thead>
                        <tr>
                            <th>Rule ID</th>
                            <th>Clinical Rule</th>
                            <th>Result</th>
                            <th>Justification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#" onclick="event.preventDefault();" class="ce-table__rule-id"><?php echo e($recommendation->rule_id); ?></a></td>
                            <td><?php echo e($recommendation->recommendation_text); ?></td>
                            <td><span class="ce-table__result">Applied</span></td>
                            <td class="ce-table__justification"><?php echo e($recommendation->justification); ?></td>
                        </tr>

                        <?php if(!empty($recommendation->details['overlay_rule'])): ?>
                        <tr>
                            <td><span class="ce-table__rule-id"><?php echo e($recommendation->details['overlay_rule']['rule_id']); ?></span></td>
                            <td><?php echo e($recommendation->details['overlay_rule']['recommendation']); ?></td>
                            <td><span class="ce-table__result">Applied (overlay)</span></td>
                            <td class="ce-table__justification"><?php echo e($recommendation->details['overlay_rule']['justification']); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($recommendation->conflict): ?>
                <div class="pd-conflict" style="margin-top:16px;">
                    <strong>Ambiguous case — referred to RCP</strong>
                    <p><?php echo e($recommendation->conflict_reason); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="ce-justification">
            <h3>Clinical Justification for the Recommendation</h3>
            <p>
                According to <?php echo e($recommendation->source ?? 'TNCD'); ?>

                (grade <?php echo e($recommendation->grade ?? 'N/A'); ?>),
                <?php echo e($recommendation->justification); ?>

            </p>

            <?php if(!empty($recommendation->details['transversal_note'])): ?>
                <p style="margin-top:10px; color:#6b7280;"><?php echo e($recommendation->details['transversal_note']); ?></p>
            <?php endif; ?>
        </div>

        <div style="max-width:960px; margin:20px auto 0;">
            <a href="<?php echo e(route('recommendations.show', $recommendation->recommendation_id)); ?>" class="pd-btn pd-btn--outline">View Full Recommendation</a>
        </div>

    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/clinical-explanation.blade.php ENDPATH**/ ?>