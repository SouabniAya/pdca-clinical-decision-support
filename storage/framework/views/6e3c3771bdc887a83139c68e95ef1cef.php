
<header class="app-header">

  <div class="app-header__search">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
      <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <input type="search" placeholder="Search...">
  </div>

  <div class="app-header__right">
    <button type="button" class="app-header__icon-btn" aria-label="Notifications">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M12 3a5 5 0 0 0-5 5v3.2c0 .6-.2 1.2-.6 1.7L5 15h14l-1.4-2.1a2.8 2.8 0 0 1-.6-1.7V8a5 5 0 0 0-5-5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
        <path d="M9.5 18a2.5 2.5 0 0 0 5 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      <span class="app-header__badge"></span>
    </button>

    <div class="app-header__profile" role="button" tabindex="0" aria-haspopup="true">
      <span class="app-header__avatar">
        <img src="<?php echo e(asset('images/avatar-placeholder.png')); ?>" alt="">
      </span>
      <span class="app-header__profile-name"><?php echo e(auth()->user()->name ?? 'Dr. Taieb'); ?></span>
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
  </div>

</header><?php /**PATH C:\laragon\www\medcare-clone\resources\views/components/header.blade.php ENDPATH**/ ?>