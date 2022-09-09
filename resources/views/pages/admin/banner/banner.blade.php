@extends('layouts.admin.dashboard')


@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />

@stop


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Page</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                            <li class="breadcrumb-item active">Banner Images</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{ route('banner_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Banner</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <div>
                                            <label for="image" class="form-label">Image</label>
                                            <input class="form-control" type="file" name="image" id="image">
                                            @error('image')
                                            <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary jpges-effect waves-light"
                                            id="submitBtn">Upload</button>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Banner Images</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="text-muted">

                            <div id="image-container">
                            
                                <div class="row gallery-wrapper" style="position: relative;">
                                    @foreach ($images as $item)
                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <img class="gallery-img img-fluid mx-auto" src="{{asset('storage/upload/banners/'.$item->image)}}" alt="">
                                            </div>

                                            <div class="box-content">
                                                <div class="d-flex align-items-center mt-1">
                                                    <div class="flex-shrink-0">
                                                        <div class="d-flex gap-3">
                                                            <button type="button" class="btn btn-sm fs-18 btn-link text-body text-decoration-none px-0 text-danger" onclick="deleteHandler('{{route('banner_delete', $item->id)}}')">
                                                                <i class="ri-delete-bin-fill text-danger fs-18 align-bottom me-1"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->


</div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop


@section('javascript')
<script src="{{ asset('admin/js/pages/img-previewer.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>


<script type="text/javascript">
// initialize the validation library
const validation = new JustValidate('#countryForm', {
    errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#image', [
    {
        rule: 'minFilesCount',
        value: 1,
        errorMessage: 'Please select an image',
    },
    {
        rule: 'files',
        value: {
            files: {
                extensions: ['jpeg', 'png', 'jpg', 'webp']
            },
        },
        errorMessage: 'Please select a valid image',
    },
  ])
    .onSuccess(async (event) => {
        // event.target.submit();

        const errorToast = (message) => {
            iziToast.error({
                title: 'Error',
                message: message,
                position: 'bottomCenter',
                timeout: 7000
            });
        }
        const successToast = (message) => {
            iziToast.success({
                title: 'Success',
                message: message,
                position: 'bottomCenter',
                timeout: 6000
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
            formData.append('image',document.getElementById('image').files[0])

            const response = await axios.post('{{ route('banner_store') }}', formData)
            successToast(response.data.message)
            setTimeout(function() {
                window.location.replace(response.data.url);
            }, 1000);
        } catch (error) {
            console.log(error);
            if(error?.response?.data?.form_error?.image){
                errorToast(error?.response?.data?.form_error?.image[0])
            }
        } finally {
            submitBtn.innerHTML = `
                Upload
                `
            submitBtn.disabled = false;
        }
    });
</script>



<script>
function deleteHandler(url) {
    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: 'Are you sure about that?',
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function(instance, toast) {

                window.location.replace(url);
                // instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

            }, true],
            ['<button>NO</button>', function(instance, toast) {

                instance.hide({
                    transitionOut: 'fadeOut'
                }, toast, 'button');

            }],
        ],
        onClosing: function(instance, toast, closedBy) {
            console.info('Closing | closedBy: ' + closedBy);
        },
        onClosed: function(instance, toast, closedBy) {
            console.info('Closed | closedBy: ' + closedBy);
        }
    });
}
</script>

<script>
    const myViewer = new ImgPreviewer('#image-container',{
      // aspect ratio of image
        fillRatio: 0.9,
        // attribute that holds the image
        dataUrlKey: 'src',
        // additional styles
        style: {
            modalOpacity: 0.6,
            headerOpacity: 0,
            zIndex: 99
        },
        // zoom options
        imageZoom: { 
            min: 0.1,
            max: 5,
            step: 0.1
        },
        // detect whether the parent element of the image is hidden by the css style
        bubblingLevel: 0,
        
    });
</script>

@stop