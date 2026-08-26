<?php $__env->startSection('title', 'New Patient'); ?>

<?php ($active = 'patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>New Patient</h1>
            <p>Register a new patient in the system.</p>
        </div>
        <a href="<?php echo e(route('patients.index')); ?>" class="patients-page__btn" style="background:#fff;color:#111;border:1px solid #e2e2e2;">
            &larr; Back to Patients
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;color:#b3261e;border-radius:8px;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="patients-table-wrap" style="padding:24px;">
        <form method="POST" action="<?php echo e(route('patients.store')); ?>">
            <?php echo csrf_field(); ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:22px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">First Name</label>
                    <input type="text" name="first_name" value="<?php echo e(old('first_name')); ?>" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo e(old('last_name')); ?>" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Sex</label>
                    <select name="sex" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                        <option value="">Select...</option>
                        <option value="M" <?php if(old('sex') === 'M'): echo 'selected'; endif; ?>>Male</option>
                        <option value="F" <?php if(old('sex') === 'F'): echo 'selected'; endif; ?>>Female</option>
                    </select>
                </div>
                <div style="grid-column:1 / -1;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Medical Record Number</label>
                    <input type="text" name="medical_record_number" value="<?php echo e(old('medical_record_number')); ?>" placeholder="e.g. MRN-2026-0001" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
            </div>

            <button type="submit" class="patients-page__btn">
                Add Patient
            </button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\medcare-clone\resources\views/patients/create.blade.php ENDPATH**/ ?>