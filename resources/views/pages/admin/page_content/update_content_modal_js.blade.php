<script>
    async function editHandlers(id){
        try {
            var formData = new FormData();
            formData.append('id',id)
            const response = await axios.post('{{route('getPageContent')}}', formData)
            console.log(response);
            document.getElementById('heading_update').value = response.data.data.heading;
            document.getElementById('image_position_update').value = response.data.data.image_position;
            quillDescriptionUpdate.root.innerHTML = response.data.data.description;
            document.getElementById('item_id').value = response.data.data.id;
        } catch (error) {
            console.log(error);
        }
    }
</script>

<script type="text/javascript">

    // initialize the validation library
    const validationUpdateModal = new JustValidate('#modalUpdateForm', {
          errorFieldCssClass: 'is-invalid',
    });
    // apply rules to form fields
    validationUpdateModal
    .addField('#heading_update', [
        {
          rule: 'required',
          errorMessage: 'Heading is required',
        },
        {
            rule: 'customRegexp',
            value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\?\'\r\n+=,]+$/i,
            errorMessage: 'Heading is invalid',
        },
      ])
      .addField('#image_update', [
        {
            rule: 'minFilesCount',
            value: 0,
            errorMessage: 'Please select an image',
        },
        {
            rule: 'files',
            value: {
                files: {
                    extensions: ['jpg','jpeg','png', 'web3']
                },
            },
            errorMessage: 'Please select a valid image',
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
    
            
            var submitBtn = document.getElementById('updateBtnModal')
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
            formData.append('heading',document.getElementById('heading_update').value)
            formData.append('id',document.getElementById('item_id').value)
            formData.append('image_position',document.getElementById('image_position_update').value)
            formData.append('page_id',{{$page_detail->id}})
            formData.append('description_unformatted',quillDescriptionUpdate.getText())
            formData.append('description',quillDescriptionUpdate.root.innerHTML)
            if(document.getElementById('image_update').files[0]){
                formData.append('image',document.getElementById('image_update').files[0])
            }
            // formData.append('refreshUrl','{{URL::current()}}')
            
            const response = await axios.post('{{route('updatePageContent')}}', formData)
            successToast(response.data.message)
            setTimeout(function(){
                window.location.replace(response.data.url);
            }, 1000);
          } catch (error) {
              console.log(error);
            if(error?.response?.data?.form_error?.heading){
                errorToast(error?.response?.data?.form_error?.heading[0])
            }
            if(error?.response?.data?.form_error?.description_unformatted){
                errorToast(error?.response?.data?.form_error?.description_unformatted[0])
            }
            if(error?.response?.data?.form_error?.audio){
                errorToast(error?.response?.data?.form_error?.audio[0])
            }
          } finally{
                submitBtn.innerHTML =  `
                    Update
                    `
                submitBtn.disabled = false;
            }
    });
    </script>