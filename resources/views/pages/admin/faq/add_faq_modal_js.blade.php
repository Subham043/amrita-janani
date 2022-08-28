<script type="text/javascript">

    // initialize the validation library
    const validationAddModal = new JustValidate('#modalAddForm', {
          errorFieldCssClass: 'is-invalid',
    });
    // apply rules to form fields
    validationAddModal
      .addField('#question', [
        {
          rule: 'required',
          errorMessage: 'Question is required',
        },
        {
            rule: 'customRegexp',
            value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
            errorMessage: 'Question is invalid',
        },
      ])
      .addField('#answer', [
        {
          rule: 'required',
          errorMessage: 'Answer is required',
        },
        {
            rule: 'customRegexp',
            value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
            errorMessage: 'Answer is invalid',
        },
      ])
      .onSuccess(async (event) => {
        // event.target.submit();
    
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
    
            
            var submitBtn = document.getElementById('submitBtnModal')
            submitBtn.innerHTML = `
                <span class="d-flex align-items-center">
                    <span class="spinner-border flex-shrink-0" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span class="flex-grow-1 ms-2">
                        Loading...
                    </span>
                </span>
                `
            submitBtn.disabled = true;
        
          try {
            var formData = new FormData();
            formData.append('question',document.getElementById('question').value)
            formData.append('answer',document.getElementById('answer').value)
            // formData.append('refreshUrl','{{URL::current()}}')
            
            const response = await axios.post('{{route('faq_store')}}', formData)
            successToast(response.data.message)
            setTimeout(function(){
                window.location.replace(response.data.url);
            }, 1000);
          } catch (error) {
              console.log(error);
            if(error?.response?.data?.form_error?.question){
                errorToast(error?.response?.data?.form_error?.question[0])
            }
            if(error?.response?.data?.form_error?.answer){
                errorToast(error?.response?.data?.form_error?.answer[0])
            }
          } finally{
                submitBtn.innerHTML =  `
                    Add
                    `
                submitBtn.disabled = false;
            }
      });
</script>