<?php $__env->startSection('title', 'Clinical Explanation'); ?>

<?php ($active = 'patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="ce-page">

    <div class="ce-page__head">
        <div>
            <h1>Clinical Explanation</h1>
            <p>This page presents the clinical rules applied, the decision path followed, and the medical justification for the generated recommendation.</p>
        </div>

        <div class="ce-patient-card">
            <span class="ce-patient-card__avatar"></span>
            <div class="ce-patient-card__body">
                <strong>Ahmed Benali</strong>
                <div class="ce-patient-card__meta">
                    <span class="ce-patient-card__id">ID: P00128</span>
                    <span class="ce-patient-card__status">Active</span>
                    <span class="ce-patient-card__age">62 years</span>
                    <span>12/05/2024</span>
                </div>
            </div>
        </div>
    </div>

    <div class="ce-card">
        <h2 class="ce-card__title">Applied Clinical Rules</h2>

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
                        <td><span class="ce-table__rule-id">R5</span></td>
                        <td>Locally advanced and PS 0-1</td>
                        <td><span class="ce-table__result">Applied</span></td>
                        <td class="ce-table__justification">Indication for induction chemotherapy with mFOLFIRINOX followed by reassessment of resectability.</td>
                    </tr>
                    <tr>
                        <td><span class="ce-table__rule-id">R5</span></td>
                        <td>Locally advanced and PS 0-1</td>
                        <td><span class="ce-table__result">Applied</span></td>
                        <td class="ce-table__justification">Indication for induction chemotherapy with mFOLFIRINOX followed by reassessment of resectability.</td>
                    </tr>
                    <tr>
                        <td><span class="ce-table__rule-id">R5</span></td>
                        <td>Locally advanced and PS 0-1</td>
                        <td><span class="ce-table__result">Applied</span></td>
                        <td class="ce-table__justification">Indication for induction chemotherapy with mFOLFIRINOX followed by reassessment of resectability.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="ce-justification">
        <h3>Clinical Justification for the Recommendation</h3>
        <p>According to TNCD (Chapter 9, Section 9.5.3 REFERENCES, grade A), in patients with locally advanced pancreatic ductal adenocarcinoma and Performance Status 0-1, induction chemotherapy with mFOLFIRINOX is recommended. Resectability should be reassessed at each follow-up to consider secondary surgery when possible.</p>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/clinical-explanation.blade.php ENDPATH**/ ?>