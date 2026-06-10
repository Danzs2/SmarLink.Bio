<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{!! session('success') !!}',
            confirmButtonColor: '#4F46E5',
            customClass: { popup: 'rounded-3xl' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Peringatan Sistem!',
            text: '{!! session('error') !!}',
            confirmButtonColor: '#E11D48',
            customClass: { popup: 'rounded-3xl' }
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{!! session('info') !!}',
            confirmButtonColor: '#3B82F6',
            customClass: { popup: 'rounded-3xl' }
        });
    @endif
</script>