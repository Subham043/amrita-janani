@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
<style>
    #canvas_container {
        width: 100%;
        height: 550px;
        overflow: auto;
        position: relative;
    }

    #canvas_container {
    background: #333;
    text-align: center;
    border: solid 3px;
    }

    #pdf_controllers{
        width: 100%;
        background: #222;
        display:flex;
        justify-content: space-between;
        align-items: center;
        padding:10px 15px;
    }

    #pdf_controllers button{
        display:grid;
        place-items: center;
        outline: none;
        border: none;
        background:#96171c;
        color:white;
        border-radius:5px;
        padding:5px 10px;
    }

    #navigation_controls, #zoom_controls{
        display:flex;
        align-items:center;
    }
    #navigation_controls button, #zoom_controls button{
        margin:0 10px;
        min-width:30px;
        height:35px;
    }
    #navigation_controls input{
        max-width:30px;
        height:100%;
        margin:0;
        padding:0;
        text-align:center;
        outline:none;
        border:none;
        width: 30px;
        cursor: pointer;
    }
    #navigation_controls label{
        display:flex;
        align-items:center;
        margin:0;
        padding:0;
        height: 40px;
        width: 80px;
        background-color:white;
        outline:none;
        border:1px solid #eee;
        padding:5px;
        position:relative;
        text-align: center;
        color:black;
        border-radius: 5px;
    }
    #totalPageCount{
        /* color:white; */
        margin-left:10px
    }
</style>

@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    @if($document->restricted==0)
    <div class="main-image-container" id="image-container"
        style="background-image:url({{asset('storage/upload/documents/'.$document->image)}})">

        <div id="my_pdf_viewer" oncontextmenu="return false">
            <div id="pdf_controllers">

                <div id="navigation_controls">
                    <button id="go_previous" title="previous page"><i class="fas fa-angle-double-left"></i></button>
                    <label>
                        <input id="current_page" value="1" type="text" />
                        /<span id="totalPageCount">0</span>
                    </label>
                    <button id="go_next" title="next page"><i class="fas fa-angle-double-right"></i></button>
                </div>

                <div id="zoom_controls">
                    <button id="zoom_in" title="zoom in"><i class="fas fa-search-plus"></i></button>
                    <button id="zoom_out" title="zoom out"><i class="fas fa-search-minus"></i></button>
                </div>
            </div>

            <div id="canvas_container">
                <canvas id="pdf_renderer"></canvas>
            </div>


        </div>

    </div>
    @else
    @if(empty($documentAccess) || $documentAccess->status==0)
    <div class="main-image-container" id="image-container"
        style="background-image:url({{asset('main/images/access-denied.jpg')}})">
        <div class="blur-bg" data-toggle="tooltip" data-placement="bottom"
            title="You do not have permission to access this image. Kindly request access for this image from admin by clicking on the request access button">
            <img src="{{asset('main/images/access-denied.jpg')}}" />
        </div>
    </div>
    @else
    <div class="main-image-container" id="image-container" >
        <div id="my_pdf_viewer" oncontextmenu="return false">
            <div id="pdf_controllers">

                <div id="navigation_controls">
                    <button id="go_previous" title="previous page"><i class="fas fa-angle-double-left"></i></button>
                    <label>
                        <input id="current_page" value="1" type="text" />
                        /<span id="totalPageCount">0</span>
                    </label>
                    <button id="go_next" title="next page"><i class="fas fa-angle-double-right"></i></button>
                </div>

                <div id="zoom_controls">
                    <button id="zoom_in" title="zoom in"><i class="fas fa-search-plus"></i></button>
                    <button id="zoom_out" title="zoom out"><i class="fas fa-search-minus"></i></button>
                </div>
            </div>

            <div id="canvas_container">
                <canvas id="pdf_renderer"></canvas>
            </div>


        </div>
    </div>
    @endif
    @endif
    <hr />
    <div class="container">
        <div class="row action-button-row">
            <div class="col-sm-12">
                <div class="info-content">
                    <h5>{{$document->title}}</h5>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="info-content">
                    <p><span id="view_count">{{$document->views}} views</span> <span
                            id="favourite_count">{{$document->favourites}} favourites</span></p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 action-button-wrapper">
                <a href="{{route('content_document_makeFavourite',$document->uuid)}}"
                    class="action-btn make-favourite-button">
                    @if($documentFav)
                    @if($documentFav->status == 1)
                    <i class="far fa-heart"></i> Make Unfavourite
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                </a>
                <button class="action-btn report-button" data-toggle="modal" data-target="#reportModal"><i
                        class="far fa-flag"></i> Report</button>
                @if($document->restricted==1)
                @if(empty($documentAccess) || $documentAccess->status==0)
                <button class="action-btn access-button" data-toggle="modal" data-target="#requestAccessModal"><i
                        class="far fa-question-circle"></i> Request Access</button>
                @endif
                @endif
            </div>
        </div>
    </div>
    <hr />
    <div class="container info-container">
        <p>ID : <b>{{$document->uuid}}</b></p>
        <p>Format : <b>{{$document->file_format()}}</b></p>
        <p>Language : <b>{{$document->LanguageModel->name}}</b></p>
        <p>Number of Pages : <b>{{$document->page_number}}</b></p>
        <p>Visibility : <b>{{$document->restricted==0 ? 'Public' : 'Private'}}</b></p>
        <p>Uploaded By : <b>{{$document->User->name}}</b></p>
        <p>Uploaded At : <b>{{$document->time_elapsed()}}</b></p>
    </div>
    @if($document->description_unformatted)
    <hr />
    <div class="container info-container info-major-content">
        <h6>Description</h6>
        {!!$document->description!!}
    </div>
    @endif

    <!-- Request Access Modal -->
    <div class="modal fade" id="requestAccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                                <span class="btn-captcha" onclick="reload_captcha('captcha_container1')"
                                    style="margin-left:10px;cursor:pointer;" title="reload captcha"><i
                                        class="fas fa-redo"></i></span>
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
                            <label for="reasonForAccess">Describe briefly about the issue with the current
                                document.</label>
                            <textarea class="form-control" id="reportMessage" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reasonForAccess">Captcha</label>
                            <div class="d-flex" style="align-items:center;">
                                <p id="captcha_container2">{!!captcha_img()!!} </p>
                                <span class="btn-captcha" onclick="reload_captcha('captcha_container2')"
                                    style="margin-left:10px;cursor:pointer;" title="reload captcha"><i
                                        class="fas fa-redo"></i></span>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<script src="{{ asset('main/js/plugins/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
<script>
const myViewer = new ImgPreviewer('#image-container', {
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
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script type="text/javascript">
const validationModal = new JustValidate('#requestAccessForm', {
    errorFieldCssClass: 'is-invalid',
});

validationModal
    .addField('#reasonForAccess', [{
            rule: 'required',
            errorMessage: 'Reason is required',
        },
        {
            rule: 'customRegexp',
            value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
            errorMessage: 'Reason is containing invalid characters',
        },
    ])
    .addField('#captcha1', [{
        rule: 'required',
        errorMessage: 'Captcha is required',
    }])
    .onSuccess(async (event) => {
        event.target.preventDefault;
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
            formData.append('message', document.getElementById('reasonForAccess').value)
            formData.append('captcha', document.getElementById('captcha1').value)
            const response = await axios.post('{{route('content_document_requestAccess', $document->uuid)}}', formData)
            successToast(response.data.message)
            event.target.reset()
            setTimeout(() => {
                location.reload()
            }, 1000)
        } catch (error) {
            if (error?.response?.data?.form_error?.message) {
                errorToast(error?.response?.data?.form_error?.message[0])
            }
            if (error?.response?.data?.form_error?.captcha) {
                errorToast(error?.response?.data?.form_error?.captcha[0])
            }
            if (error?.response?.data?.error) {
                errorToast(error?.response?.data?.error)
            }
        } finally {
            submitBtn.innerHTML = `
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
    .addField('#reportMessage', [{
            rule: 'required',
            errorMessage: 'Message is required',
        },
        {
            rule: 'customRegexp',
            value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
            errorMessage: 'Message is containing invalid characters',
        },
    ])
    .addField('#captcha2', [{
        rule: 'required',
        errorMessage: 'Captcha is required',
    }])
    .onSuccess(async (event) => {
        event.target.preventDefault;
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
            formData.append('message', document.getElementById('reportMessage').value)
            formData.append('captcha', document.getElementById('captcha2').value)
            const response = await axios.post('{{route('content_document_report', $document->uuid)}}', formData)
            successToast(response.data.message)
            event.target.reset()
            setTimeout(() => {
                location.reload()
            }, 1000)
        } catch (error) {
            if (error?.response?.data?.form_error?.message) {
                errorToast(error?.response?.data?.form_error?.message[0])
            }
            if (error?.response?.data?.form_error?.captcha) {
                errorToast(error?.response?.data?.form_error?.captcha[0])
            }
            if (error?.response?.data?.error) {
                errorToast(error?.response?.data?.error)
            }
        } finally {
            submitBtn.innerHTML = `
            Report
            `
            submitBtn.disabled = false;
        }
    })
</script>

<script type="text/javascript">
async function reload_captcha(id) {
    try {
        const response = await axios.get('{{route('captcha_ajax')}}')
        document.getElementById(id).innerHTML = response.data.captcha
    } catch (error) {
        if (error?.response?.data?.error) {
            errorToast(error?.response?.data?.error)
        }
    } finally {}
}
</script>

@if(($document->restricted==0) || (!empty($documentAccess) && $documentAccess->status==1))
<script>

    
    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 1
    }
    
    pdfjsLib.getDocument('{{asset('storage/upload/documents/'.$document->document)}}').then((pdf) => {
    
        myState.pdf = pdf;
        document.getElementById("totalPageCount").innerHTML = myState.pdf._pdfInfo.numPages;
        render();

    });

    function render() {
        myState.pdf.getPage(myState.currentPage).then((page) => {
        
            var canvas = document.getElementById("pdf_renderer");
            var ctx = canvas.getContext('2d');
    
            var viewport = page.getViewport(myState.zoom);

            canvas.width = viewport.width;
            canvas.height = viewport.height;
        
            page.render({
                canvasContext: ctx,
                viewport: viewport
            });
        });
    }

    

    document.getElementById('go_previous').addEventListener('click', (e) => {
        if(myState.pdf == null || myState.currentPage == 1) return false;
        myState.currentPage -= 1;
        document.getElementById("current_page").value = myState.currentPage;
        render();
    });

    document.getElementById('go_next').addEventListener('click', (e) => {
        if(myState.pdf == null || myState.currentPage >= myState.pdf._pdfInfo.numPages) return false;
        myState.currentPage += 1;
        document.getElementById("current_page").value = myState.currentPage;
        render();
    });

    document.getElementById('current_page').addEventListener('keypress', (e) => {
        if(myState.pdf == null) return;
        
        // Get key code
        var code = (e.keyCode ? e.keyCode : e.which);
        
        // If key code matches that of the Enter key
        if(code == 13) {
            var desiredPage = 
            document.getElementById('current_page').valueAsNumber;
                                
            if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                myState.currentPage = desiredPage;
                document.getElementById("current_page").value = desiredPage;
                render();
            }
        }
    });

    document.getElementById('zoom_in').addEventListener('click', (e) => {
        if(myState.pdf == null) return;
        myState.zoom += 0.1;
        render();
    });

    document.getElementById('zoom_out').addEventListener('click', (e) => {
        if(myState.pdf == null) return;
        myState.zoom -= 0.1;
        render();
    });

</script>

@endif

<script>
    function callSearchHandler(){
        var str= "";
        var arr = [];

        if(document.getElementById('search').value){
            arr.push("search="+document.getElementById('search').value)
        }


        str = arr.join('&');
        window.location.replace('{{route('content_dashboard')}}?'+str)
        return false;
    }
</script>

@stop