<script type="text/javascript">
    async function reload_captcha(id){
        try {
            const response = await axios.get('{{route('captcha_ajax')}}')
            document.getElementById(id).innerHTML = response.data.captcha
        } catch (error) {
            if(error?.response?.data?.error){
                errorToast(error?.response?.data?.error)
            }
        } finally{}
    }
</script>