<script>
    @if(Session::has('success'))
        $('body').pgNotification({
            style: 'bar',
            message: "{{ Session::get('success') }}",
            position: 'top',
            timeout: 3000,
            type: 'success'
        }).show();
    @endif
    @if(Session::has('info'))
        $('body').pgNotification({
            style: 'bar',
            message: "{{ Session::get('info') }}",
            position: 'top',
            timeout: 3000,
            type: 'info'
        }).show();
    @endif
    @if(Session::has('error'))
        $('body').pgNotification({
            style: 'bar',
            message: "{{ Session::get('error') }}",
            position: 'top',
            timeout: 3000,
            type: 'error'
        }).show();
    @endif
</script>