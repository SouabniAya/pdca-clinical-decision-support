<?php $__env->startSection('title', 'Help & User Guide'); ?>

<?php ($active = 'help'); ?>

<?php $__env->startSection('content'); ?>
<div class="help-page">

    <div class="help-page__head">
        <div>
            <h1>Help &amp; User Guide</h1>
            <p>Learn how the application works, how to enter clinical data, and find answers to common questions.</p>
        </div>
        <a href="#" class="help-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17v.01M12 13.5a2 2 0 1 0-2-2M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Download Guide (PDF)
        </a>
    </div>

    <div class="help-page__nav">
        <a href="#how-it-works" class="help-page__nav-link">How the App Works</a>
        <a href="#clinical-data" class="help-page__nav-link">Clinical Data Entry Guide</a>
        <a href="#faq" class="help-page__nav-link">FAQ</a>
    </div>

    
    <section id="how-it-works" class="help-page__section">
        <div class="help-page__section-head">
            <span class="help-page__section-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9.5 9.5a2.5 2.5 0 1 1 3.2 2.4c-.7.2-1.2.8-1.2 1.6v.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 17v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <h2>How the Application Works</h2>
        </div>

        <div class="help-page__cards">

            <div class="help-page__info-card">
                <span class="help-page__info-card-index">1</span>
                <h3>Register a Patient</h3>
                <p>Add a new patient record from the "New Patient" button on the Patient List page, then fill in the required demographic and clinical information.</p>
            </div>

            <div class="help-page__info-card">
                <span class="help-page__info-card-index">2</span>
                <h3>Enter Clinical Data</h3>
                <p>Complete the patient's clinical profile (stage, status, exam results) so the system has enough information to work with.</p>
            </div>

            <div class="help-page__info-card">
                <span class="help-page__info-card-index">3</span>
                <h3>Review Recommendations</h3>
                <p>The system automatically generates treatment recommendations based on the data entered. Review them on the patient's detail page.</p>
            </div>

            <div class="help-page__info-card">
                <span class="help-page__info-card-index">4</span>
                <h3>Track & Update</h3>
                <p>Keep the patient's status and stage up to date as their situation evolves. All changes are reflected instantly across the dashboard.</p>
            </div>

        </div>
    </section>

    
    <section id="clinical-data" class="help-page__section">
        <div class="help-page__section-head">
            <span class="help-page__section-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <h2>Clinical Data Entry Guide</h2>
        </div>

        <div class="help-page__table-wrap">
            <table class="help-page__table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Description</th>
                        <th>Tips</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Status</td>
                        <td>Indicates whether the patient is currently active, inactive, or archived in the system.</td>
                        <td>Update this field as soon as the patient's situation changes.</td>
                    </tr>
                    <tr>
                        <td>Stage</td>
                        <td>The clinical stage of the patient's condition (e.g. Localized, Locally Advanced, Metastatic).</td>
                        <td>Choose the stage that matches the most recent clinical assessment.</td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>Patient's current age, used as a factor in generating recommendations.</td>
                        <td>Double-check this value; it directly affects recommendation accuracy.</td>
                    </tr>
                    <tr>
                        <td>Last Updated</td>
                        <td>Automatically set whenever a patient's record is modified.</td>
                        <td>No manual action needed — this is handled by the system.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="help-page__note">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9v4M12 17v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
            <p>Accurate and complete clinical data leads to more reliable recommendations. Incomplete fields may reduce the system's confidence in its suggestions.</p>
        </div>
    </section>

    
    <section id="faq" class="help-page__section">
        <div class="help-page__section-head">
            <span class="help-page__section-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 10a4 4 0 1 1 5.5 3.7c-.9.4-1.5 1.1-1.5 2.1v.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 19v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
            </span>
            <h2>FAQ — Generated Recommendations</h2>
        </div>

        <div class="help-page__faq">

            <details class="help-page__faq-item" open>
                <summary>
                    How are the recommendations generated?
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p>Recommendations are generated automatically based on the patient's clinical data (stage, status, age, and exam results). The system compares this information against established clinical guidelines.</p>
            </details>

            <details class="help-page__faq-item">
                <summary>
                    Why does a patient have no recommendation yet?
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p>This usually means some required clinical fields are missing or incomplete. Complete the patient's profile to trigger a new recommendation.</p>
            </details>

            <details class="help-page__faq-item">
                <summary>
                    Can I edit a recommendation manually?
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p>Recommendations reflect the system's analysis and cannot be edited directly, but a clinician can always add notes or override the suggested course of action in the patient file.</p>
            </details>

            <details class="help-page__faq-item">
                <summary>
                    How often are recommendations updated?
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p>Every time a patient's clinical data is updated, the recommendation is automatically recalculated to reflect the latest information.</p>
            </details>

            <details class="help-page__faq-item">
                <summary>
                    Who can I contact for support?
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p>If you have questions not covered here, please contact your system administrator or the support team listed in the application settings.</p>
            </details>

        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/pages/help.blade.php ENDPATH**/ ?>