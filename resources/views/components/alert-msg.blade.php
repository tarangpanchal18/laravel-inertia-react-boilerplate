<script>
@if (session('success'))
    swal.fire('Success', '{{ session("success") }}', 'success');
@endif

@if (session('error'))
    swal.fire('Success', '{{ session("error") }}', 'error');
@endif
</script>
