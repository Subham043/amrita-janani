<script type="text/javascript">

const validationModal = new JustValidate('#requestAccessForm', {
    errorFieldCssClass: 'is-invalid',
});

validationModal
.addField('#reasonForAccess', [
{
    rule: 'required',
    errorMessage: 'Reason is required',
},
{
    rule: 'customRegexp',
    value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
    errorMessage: 'Reason is containing invalid characters',
},
])
.addField('#captcha1', [
{
    rule: 'required',
    errorMessage: 'Captcha is required',
}
])
.onSuccess(async (event) => {
    event.target.preventDefault;
    const errorToast = (message) =>{
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'bottomCenter',
            timeout:7000
        });
    }
    const successToast = (message) =>{
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'bottomCenter',
            timeout:6000
        });
    }
    var submitBtn = document.getElementById('SubmitBtn')
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center">
            <span class="spinner-border flex-shrink-0" role="status">
                <span class="visually-hidden"></span>
            </span>
            <span class="flex-grow-1 ms-2">
                &nbsp; Submiting...
            </span>
        </span>
        `
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('message',document.getElementById('reasonForAccess').value)
        formData.append('captcha',document.getElementById('captcha1').value)
        const response = await axios.post('{{$url}}', formData)
        successToast(response.data.message)
        event.target.reset()
        setTimeout(()=>{
            location.reload()
        }, 1000)
    } catch (error) {
        if(error?.response?.data?.form_error?.message){
            errorToast(error?.response?.data?.form_error?.message[0])
        }
        if(error?.response?.data?.form_error?.captcha){
            errorToast(error?.response?.data?.form_error?.captcha[0])
        }
        if(error?.response?.data?.error){
            errorToast(error?.response?.data?.error)
        }
    } finally{
        submitBtn.innerHTML =  `
            Request
            `
        submitBtn.disabled = false;
    }
})

</script>