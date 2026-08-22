<?php $__env->startSection('title', 'User Management'); ?>

<?php ($active = 'users'); ?>

<?php $__env->startSection('content'); ?>
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>User List</h1>
            <p>View and manage users registered in the system.</p>
        </div>
        <a href="<?php echo e(route('users.create')); ?>" class="patients-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            New User
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="clinical-form__success" style="margin-bottom:16px;padding:12px 16px;background:#e6f7ec;color:#1a7f3c;border-radius:8px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="clinical-form__error" style="margin-bottom:16px;padding:12px 16px;background:#fdecea;color:#b3261e;border-radius:8px;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="GET" action="<?php echo e(route('users.index')); ?>" class="patients-toolbar">
        <div class="patients-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search user by name or ID...">
        </div>

        <select name="status" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Status</option>
            <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Active</option>
            <option value="inactive" <?php if(request('status') === 'inactive'): echo 'selected'; endif; ?>>Inactive</option>
        </select>

        <select name="role" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Role</option>
            <option value="Doctor" <?php if(request('role') === 'Doctor'): echo 'selected'; endif; ?>>Doctor</option>
            <option value="Nurse" <?php if(request('role') === 'Nurse'): echo 'selected'; endif; ?>>Nurse</option>
            <option value="Visitor" <?php if(request('role') === 'Visitor'): echo 'selected'; endif; ?>>Visitor</option>
            <option value="Administrator" <?php if(request('role') === 'Administrator'): echo 'selected'; endif; ?>>Administrator</option>
        </select>

        <button type="submit" class="patients-toolbar__filter" style="border:0;cursor:pointer;">
            Search
        </button>

        <a href="<?php echo e(route('users.index')); ?>" class="patients-toolbar__reset">
            Reset
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </form>

    <div class="patients-table-wrap">
        <table class="patients-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($user['id']); ?></td>
                    <td><?php echo e($user['name']); ?></td>
                    <td><?php echo e($user['email']); ?></td>
                    <td><span class="patients-table__status"><?php echo e($user['status']); ?></span></td>
                    <td><?php echo e($user['role']); ?></td>
                    <td>
                        <div class="patients-table__actions" style="position:relative;">
                            <a href="<?php echo e(route('users.show', $user['id'])); ?>" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="More options" onclick="toggleUserMenu(event, '<?php echo e($user['id']); ?>')">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>

                            <div class="user-actions-menu" id="menu-<?php echo e($user['id']); ?>" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid #e2e2e2;border-radius:8px;box-shadow:0 6px 16px rgba(0,0,0,.1);z-index:20;min-width:130px;overflow:hidden;">
                                <a href="<?php echo e(route('users.edit', $user['id'])); ?>" style="display:block;padding:10px 14px;color:#1a1a1a;text-decoration:none;font-size:14px;">Edit</a>
                                <form method="POST" action="<?php echo e(route('users.destroy', $user['id'])); ?>" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 14px;background:none;border:0;border-top:1px solid #f0f0f0;color:#c0392b;font-size:14px;cursor:pointer;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="#" class="patients-page__view-all">View All Users </a>

</div>

<script>
    function toggleUserMenu(event, id) {
        event.stopPropagation();
        document.querySelectorAll('.user-actions-menu').forEach(function (menu) {
            if (menu.id !== 'menu-' + id) menu.style.display = 'none';
        });
        var menu = document.getElementById('menu-' + id);
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
    document.addEventListener('click', function () {
        document.querySelectorAll('.user-actions-menu').forEach(function (menu) {
            menu.style.display = 'none';
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/users/index.blade.php ENDPATH**/ ?>