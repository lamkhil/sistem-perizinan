


<?php if(session('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: <?php echo json_encode(session('success'), 15, 512) ?>,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/components/notification-popup.blade.php ENDPATH**/ ?>