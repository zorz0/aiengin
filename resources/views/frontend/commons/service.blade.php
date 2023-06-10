<script type="text/javascript">

    try {
        window.opener.postMessage({
            success: true,
            token: '{{ $token }}'
        });
        window.close();
    } catch(e) {

    }
</script>
