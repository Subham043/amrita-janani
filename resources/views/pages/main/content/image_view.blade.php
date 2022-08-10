@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">

@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    @if($image->restricted==0)
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('storage/upload/images/'.$image->image)}})">
        <div class="blur-bg">
            <img src="{{asset('storage/upload/images/'.$image->image)}}" />
        </div>
    </div>
    @else
    @if(empty($imageAccess) || $imageAccess->status==0)
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('main/images/access-denied.jpg')}})">
        <div class="blur-bg" data-toggle="tooltip" data-placement="bottom" title="You do not have permission to access this image. Kindly request access for this image from admin by clicking on the request access button">
            <img src="{{asset('main/images/access-denied.jpg')}}" />
        </div>
    </div>
    @else
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('storage/upload/images/'.$image->image)}})">
        <div class="blur-bg">
            <img src="{{asset('storage/upload/images/'.$image->image)}}" />
        </div>
    </div>
    @endif
    @endif
    <hr/>
    <div class="container">
        <div class="row action-button-row">
            <div class="col-sm-12">
                <div class="info-content">
                    <h5>{{$image->title}}</h5>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="info-content">
                    <p><span id="view_count">{{$image->views}} views</span> <span id="favourite_count">{{$image->favourites}} favourites</span></p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 action-button-wrapper">
                <a href="{{route('content_image_makeFavourite',$image->uuid)}}" class="action-btn make-favourite-button">
                    @if($imageFav)
                    @if($imageFav->status == 1)
                    <i class="far fa-heart"></i> Make Unfavourite
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                </a>
                <button class="action-btn report-button" data-toggle="modal" data-target="#reportModal"><i class="far fa-flag"></i> Report</button>
                @if($image->restricted==1)
                @if(empty($imageAccess) || $imageAccess->status==0)
                <button class="action-btn access-button"  data-toggle="modal" data-target="#requestAccessModal" ><i class="far fa-question-circle"></i> Request Access</button>
                @endif
                @endif
            </div>
        </div>
    </div>
    <hr/>
    <div class="container info-container">
    <p>ID : <b>{{$image->uuid}}</b></p>
    <p>Format : <b>{{$image->file_format()}}</b></p>
    <p>Language : <b>{{$image->LanguageModel->name}}</b></p>
    <p>Visibility : <b>{{$image->restricted==0 ? 'Public' : 'Private'}}</b></p>
    <p>Uploaded By : <b>{{$image->User->name}}</b></p>
    <p>Uploaded At : <b>{{$image->time_elapsed()}}</b></p>
    </div>
    @if($image->description_unformatted)
    <hr/>
    <div class="container info-container info-major-content">
        <h6>Description</h6>
        {!!$image->description!!}
    </div>
    @endif

    <!-- Request Access Modal -->
    <div class="modal fade" id="requestAccessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="requestAccessForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reasonForAccess">Reason For Access</label>
                            <textarea class="form-control" id="reasonForAccess" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reasonForAccess">Captcha</label>
                            <div class="d-flex" style="align-items:center;">
                                <p id="captcha_container1">{!!captcha_img()!!} </p>
                                <span class="btn-captcha" onclick="reload_captcha('captcha_container1')" style="margin-left:10px;cursor:pointer;" title="reload captcha"><i class="fas fa-redo"></i></span>
                            </div>
                            <input type="text" class="form-control" id="captcha1" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="SubmitBtn">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report An Issue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="reportForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reasonForAccess">Describe briefly about the issue with the current image.</label>
                            <textarea class="form-control" id="reportMessage" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reasonForAccess">Captcha</label>
                            <div class="d-flex" style="align-items:center;">
                                <p id="captcha_container2">{!!captcha_img()!!} </p>
                                <span class="btn-captcha" onclick="reload_captcha('captcha_container2')" style="margin-left:10px;cursor:pointer;" title="reload captcha"><i class="fas fa-redo"></i></span>
                            </div>
                            <input type="text" class="form-control" id="captcha2" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="SubmitBtn2">Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/img-previewer.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
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

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

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
        const response = await axios.post('{{route('content_image_requestAccess', $image->uuid)}}', formData)
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

<script type="text/javascript">

const validationModal2 = new JustValidate('#reportForm', {
    errorFieldCssClass: 'is-invalid',
});

validationModal2
.addField('#reportMessage', [
{
    rule: 'required',
    errorMessage: 'Message is required',
},
{
    rule: 'customRegexp',
    value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
    errorMessage: 'Message is containing invalid characters',
},
])
.addField('#captcha2', [
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
    var submitBtn = document.getElementById('SubmitBtn2')
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
        formData.append('message',document.getElementById('reportMessage').value)
        formData.append('captcha',document.getElementById('captcha2').value)
        const response = await axios.post('{{route('content_image_report', $image->uuid)}}', formData)
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
            Report
            `
        submitBtn.disabled = false;
    }
})

</script>

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
@stop