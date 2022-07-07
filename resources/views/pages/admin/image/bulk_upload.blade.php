@extends('layouts.admin.dashboard')


@section('css')
<link rel="stylesheet" href="{{ asset('admin/libs/filepond/filepond.min.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
@stop


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Images</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Images</a></li>
                            <li class="breadcrumb-item active">Bulk Upload</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Images</h4>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <button type="button" class="btn rounded-pill btn-secondary waves-effect" data-bs-toggle="modal" data-bs-target="#myModal">Guide</button>
                            </div>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form id="countryForm" method="post" action="{{route('image_bulk_upload_store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="excel" class="form-label">Excel File</label>
                                        <input class="form-control" type="file" name="excel" id="excel">
                                        @error('excel') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="upload" class="form-label">Upload Image</label>
                                        <input class="form-control filepond" type="file" name="upload" id="upload" multiple data-allow-reorder="true" data-max-file-size="120MB" data-max-files="20">
                                        @error('upload') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-xxl-12 col-md-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Upload</button>
                                </div>
                                
                            </div>
                            </form>
                            <!--end row-->
                        </div>
                        
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->

@include('pages.admin.image.tutorial_modal')

@stop          
           

@section('javascript')
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>
<script src="{{ asset('admin/libs/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('admin/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('admin/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
<script src="{{ asset('admin/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

<script type="text/javascript">

FilePond.registerPlugin(FilePondPluginImagePreview);
    // Get a reference to the file input element
const inputElement = document.querySelector('#upload');
// Create the FilePond instance
const pond = FilePond.create(inputElement,{allowMultiple: true});


// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#excel', [
    {
        rule: 'minFilesCount',
        value: 1,
        errorMessage: 'Please upload an excel',
    },
    {
        rule: 'files',
        value: {
            files: {
                extensions: ['xls', 'xlsx']
            },
        },
        errorMessage: 'Please upload a valid excel',
    },
  ])
  .addField('#upload', [
    {
        validator: (value, fields) => {
        if (pond.getFiles().length === 0) {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select atleast one upload image',
    },
    {
        validator: (value, fields) => {
        if (pond.getFiles().length === 20) {
            return false;
        }
        return true;
        },
        errorMessage: 'Maximum 20 images are allowed',
    },
    {
        validator: (value, fields) => {
        if (pond.getFiles().length > 0) {
            for (var i = 0; i < pond.getFiles().length; i++) {
                switch (pond.getFiles()[i].fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'webp':
                        continue;
                    default:
                        return false;
                }
            }
        }
        return true;
        },
        errorMessage: 'Please select a valid upload image',
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

        
        var submitBtn = document.getElementById('submitBtn')
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
        formData.append('excel',document.getElementById('excel').files[0])
        for (var i = 0; i < pond.getFiles().length; i++) {
            formData.append('upload[]',pond.getFiles()[i].file)
        }
        // formData.append('refreshUrl','{{URL::current()}}')
        
        const response = await axios.post('{{route('image_bulk_upload_store')}}', formData)
        successToast(response.data.message)
        setTimeout(function(){
            window.location.replace(response.data.url);
        }, 1000);
      } catch (error) {
          console.log(error);
        if(error?.response?.data?.form_error?.excel){
            errorToast(error?.response?.data?.form_error?.excel[0])
        }
        if(error?.response?.data?.form_error?.upload){
            errorToast(error?.response?.data?.form_error?.upload[0])
        }
      } finally{
            submitBtn.innerHTML =  `
                Upload
                `
            submitBtn.disabled = false;
        }
  });
</script>

@stop