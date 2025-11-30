<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased">
    <?php if (isset($component)) { $__componentOriginal2880b66d47486b4bfeaf519598a469d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2880b66d47486b4bfeaf519598a469d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> <?php echo e($header ?? 'Dashboard'); ?> <?php $__env->endSlot(); ?>
        <?php echo e($slot); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $attributes = $__attributesOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $component = $__componentOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__componentOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>

    <!-- Hidden logout form for auto-logout -->
    <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>

    
    <?php if (isset($component)) { $__componentOriginal30cfb8e27d377172ee355e8a9efdd409 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30cfb8e27d377172ee355e8a9efdd409 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification-popup','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30cfb8e27d377172ee355e8a9efdd409)): ?>
<?php $attributes = $__attributesOriginal30cfb8e27d377172ee355e8a9efdd409; ?>
<?php unset($__attributesOriginal30cfb8e27d377172ee355e8a9efdd409); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30cfb8e27d377172ee355e8a9efdd409)): ?>
<?php $component = $__componentOriginal30cfb8e27d377172ee355e8a9efdd409; ?>
<?php unset($__componentOriginal30cfb8e27d377172ee355e8a9efdd409); ?>
<?php endif; ?>
    <script>
        let inactivityTimer;
        let timeout = 300000; // 5 menit (300 detik)

        function resetTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(logoutUser, timeout);
        }

        function logoutUser() {
            Swal.fire({
                title: 'Sesi Berakhir',
                text: 'Anda tidak aktif selama 5 menit dan akan dikeluarkan dari sistem demi keamanan.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const logoutForm = document.getElementById('logout-form');
                    if (logoutForm) {
                        logoutForm.submit();
                    } else {
                        window.location.href = '<?php echo e(route("logout")); ?>';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            resetTimer();
        });

        // Reset timer on user activity
        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('click', resetTimer);
        document.addEventListener('scroll', resetTimer);
        document.addEventListener('keydown', resetTimer);
        document.addEventListener('touchstart', resetTimer);
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/components/sidebar-layout.blade.php ENDPATH**/ ?>