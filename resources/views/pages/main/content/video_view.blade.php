@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/css/plugins/plyr.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">

@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    @if($video->restricted==0)
    <div class="main-image-container" >
        <div class="plyr__video-embed" id="player">
            <iframe
                @if(strpos($video->video,'vimeo') !== false)
                src="{{$video->video}}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                @else
                src="{{$video->video}}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                @endif
                allowfullscreen
                allowtransparency
                allow="autoplay"
            ></iframe>
        </div>
    </div>
    @else
    @if(empty($videoAccess) || $videoAccess->status==0)
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('main/images/access-denied.jpg')}})">
        <div class="blur-bg" data-toggle="tooltip" data-placement="bottom" title="You do not have permission to access this image. Kindly request access for this image from admin by clicking on the request access button">
            <img src="{{asset('main/images/access-denied.jpg')}}" />
        </div>
    </div>
    @else
    <div class="main-image-container" >
        <div class="plyr__video-embed" id="player">
            <iframe
                @if(strpos($video->video,'vimeo') !== false)
                src="{{$video->video}}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                @else
                src="{{$video->video}}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                @endif
                allowfullscreen
                allowtransparency
                allow="autoplay"
            ></iframe>
        </div>
    </div>
    @endif
    @endif
    <hr/>
    <div class="container">
        <div class="row action-button-row">
            <div class="col-sm-12">
                <div class="info-content">
                    <h5>{{$video->title}}</h5>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="info-content">
                    <p><span id="view_count">{{$video->views}} views</span> <span id="favourite_count">{{$video->favourites}} favourites</span></p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 action-button-wrapper">
                <a href="{{route('content_video_makeFavourite',$video->uuid)}}" class="action-btn make-favourite-button">
                    @if($videoFav)
                    @if($videoFav->status == 1)
                    <i class="far fa-heart"></i> Make Unfavourite
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                </a>
                <button class="action-btn report-button" data-toggle="modal" data-target="#reportModal"><i class="far fa-flag"></i> Report</button>
                @if($video->restricted==1)
                @if(empty($videoAccess) || $videoAccess->status==0)
                <button class="action-btn access-button"  data-toggle="modal" data-target="#requestAccessModal" ><i class="far fa-question-circle"></i> Request Access</button>
                @endif
                @endif
            </div>
        </div>
    </div>
    <hr/>
    <div class="container info-container">
    <p>ID : <b>{{$video->uuid}}</b></p>
    <p>Language : <b>{{$video->LanguageModel->name}}</b></p>
    <p>Visibility : <b>{{$video->restricted==0 ? 'Public' : 'Private'}}</b></p>
    <p>Uploaded By : <b>{{$video->User->name}}</b></p>
    <p>Uploaded At : <b>{{$video->time_elapsed()}}</b></p>
    </div>
    @if($video->description_unformatted)
    <hr/>
    <div class="container info-container info-major-content">
        <h6>Description</h6>
        {!!$video->description!!}
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
                            <label for="reasonForAccess">Describe briefly about the issue with the current video.</label>
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
<script src="{{ asset('main/js/plugins/plyr.js') }}"></script>

@if(empty($videoAccess) || $videoAccess->status==0)
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
@endif

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
        const response = await axios.post('{{route('content_video_requestAccess', $video->uuid)}}', formData)
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
        const response = await axios.post('{{route('content_video_report', $video->uuid)}}', formData)
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

@if(($video->restricted==0) || (!empty($videoAccess) && $videoAccess->status==1))
<script>
const controls = [
    'play-large', // The large play button in the center
    'restart', // Restart playback
    'rewind', // Rewind by the seek time (default 10 seconds)
    'play', // Play/pause playback
    'fast-forward', // Fast forward by the seek time (default 10 seconds)
    'progress', // The progress bar and scrubber for playback and buffering
    'current-time', // The current time of playback
    'duration', // The full duration of the media
    'mute', // Toggle mute
    'volume', // Volume control
    'captions', // Toggle captions
    'settings', // Settings menu
    'pip', 
    'airplay', 
    'fullscreen'
];

const player = new Plyr('#player', {
    controls,
});
</script>
@endif

@stop