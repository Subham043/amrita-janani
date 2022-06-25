<script type="text/javascript">
    async function reload_captcha(){
        try {
            const response = await axios.get('{{route('captcha_ajax')}}')
            document.getElementById('captcha_container').innerHTML = response.data.captcha
        } catch (error) {
            if(error?.response?.data?.error){
                errorToast(error?.response?.data?.error)
            }
        } finally{}
    }
</script>