<?php $__env->startSection('title', 'My Profile'); ?>

<?php ($active = 'profile'); ?>

<?php $__env->startSection('content'); ?>

<div class="doctor-profile-page">

    
    <div class="doctor-profile-page__head">

        <div>
            <a href="<?php echo e(route('dashboard')); ?>" class="doctor-profile-page__back">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path
                        d="M15 18l-6-6 6-6"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                Back to Dashboard
            </a>

            <h1>My Profile</h1>

            <p>
                View your personal and professional information.
            </p>
        </div>

    </div>


    
    <div class="doctor-profile-card">

        
        <div class="doctor-profile-card__identity">

            <div class="doctor-profile-card__avatar">

<img
    src="<?php echo e(asset('images/doctor-taieb.jpg')); ?>"
    alt="<?php echo e(auth()->user()->name ?? 'Dr. Taieb'); ?>"
>

            </div>

            <div class="doctor-profile-card__identity-info">

                <div class="doctor-profile-card__name-row">

                    <h2>
                        <?php echo e(auth()->user()->name ?? 'Dr. Taieb'); ?>

                    </h2>

                    <span class="doctor-profile-card__status">
                        <span></span>
                        Active
                    </span>

                </div>

                <p class="doctor-profile-card__role">
                    Doctor
                </p>

                <p class="doctor-profile-card__speciality">
                    Medical Doctor
                </p>

            </div>

        </div>


        
        <div class="doctor-profile-card__divider"></div>


        
        <section class="doctor-profile-section">

            <div class="doctor-profile-section__head">

                <div class="doctor-profile-section__icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">

                        <circle
                            cx="12"
                            cy="8"
                            r="4"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>

                <div>
                    <h3>Personal Information</h3>
                    <p>Your personal and contact information.</p>
                </div>

            </div>


            <div class="doctor-profile-info-grid">

                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Full Name
                    </span>

                    <strong>
                        <?php echo e(auth()->user()->name ?? 'Dr. Taieb'); ?>

                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Email Address
                    </span>

                    <strong>
                        <?php echo e(auth()->user()->email ?? 'doctor@example.com'); ?>

                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Phone Number
                    </span>

                    <strong>
                        <?php echo e(auth()->user()->phone ?? '+213 XX XX XX XX'); ?>

                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Location
                    </span>

                    <strong>
                        <?php echo e(auth()->user()->location ?? 'Algiers, Algeria'); ?>

                    </strong>

                </div>

            </div>

        </section>


        
        <section class="doctor-profile-section">

            <div class="doctor-profile-section__head">

                <div class="doctor-profile-section__icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">

                        <path
                            d="M4 20h16"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />

                        <path
                            d="M6 20V9l6-4 6 4v11"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M10 20v-5h4v5"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>

                <div>
                    <h3>Professional Information</h3>
                    <p>Your professional information.</p>
                </div>

            </div>


            <div class="doctor-profile-info-grid">

                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Role
                    </span>

                    <strong>
                        Doctor
                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Speciality
                    </span>

                    <strong>
                        Medical Oncology
                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Hospital / Institution
                    </span>

                    <strong>
                        University Hospital
                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        License Number
                    </span>

                    <strong>
                        MD-000000
                    </strong>

                </div>

            </div>

        </section>


        
        <section class="doctor-profile-section">

            <div class="doctor-profile-section__head">

                <div class="doctor-profile-section__icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">

                        <rect
                            x="5"
                            y="3"
                            width="14"
                            height="18"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M9 3h6v3H9z"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M8 12h8M8 16h5"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>

                <div>
                    <h3>Account Information</h3>
                    <p>Information about your account.</p>
                </div>

            </div>


            <div class="doctor-profile-info-grid">

                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Account Status
                    </span>

                    <strong class="doctor-profile-info__active">
                        <span></span>
                        Active
                    </strong>

                </div>


                <div class="doctor-profile-info">

                    <span class="doctor-profile-info__label">
                        Member Since
                    </span>

                    <strong>
                        <?php echo e(auth()->user()?->created_at?->format('F Y') ?? 'January 2026'); ?>

                    </strong>

                </div>

            </div>

        </section>

    </div>

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL HH\Documents\pdca-project\resources\views/patients/doctor-profile.blade.php ENDPATH**/ ?>