<script>
    window.addEventListener('swal',function(e) {
        // Swal.fire(e.detail);
        Swal.fire({
            title:  e.detail.title,
            icon: e.detail.icon,
            iconColor: e.detail.iconColor,
            timer: e.detail.timer,
            position: e.detail.position,
            toast:  true,
            timerProgressBar: true,
            showConfirmButton:  false,
        });
    });
</script>
