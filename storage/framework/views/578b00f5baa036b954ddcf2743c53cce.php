


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
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main>
                <?php if(isset($header)): ?>
                    <header class="bg-white shadow">
                        <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <?php echo e($header); ?>

                        </div>
                    </header>
                <?php endif; ?> 
                
                
                <?php echo e($slot); ?>

            </main>
        </div>

        
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
            let timeout = 300000; // 5 menit

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
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        const logoutForm = document.getElementById('logout-form');
                        if (logoutForm) {
                            logoutForm.submit();
                        }
                    }
                });
            }

            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;
        </script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/layouts/app.blade.php ENDPATH**/ ?>