@extends('layouts.admin.dashboard')


@section('css')
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

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Document</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{route('document_display', $country->DocumentModel->id)}}" type="button" class="btn btn-success add-btn" id="create-btn"><i class="ri-arrow-go-back-line"></i> Go To Document</a>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <form action="{{route('document_toggle_report', $country->id)}}" method="get" style="margin-right:10px;">
                                        <select class="form-control mr-2" name="status" onchange="this.form.submit()">
                                            <option value="0" {{ $country->status==0 ? 'selected':''}}>Pending</option>
                                            <option value="1" {{ $country->status==1 ? 'selected':''}}>In progress</option>
                                            <option value="2" {{ $country->status==2 ? 'selected':''}}>Completed</option>
                                        </select>
                                    </form>
                                    <button onclick="deleteHandler('{{route('document_delete_report', $country->id)}}')" type="button" class="btn btn-danger add-btn" id="create-btn"><i class="ri-delete-bin-line align-bottom me-1"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-muted">
                            <div class="pt-3 pb-3 border-top border-top-dashed border-bottom border-bottom-dashed mt-4">
                                <div class="row">
                                    
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Document Title :</p>
                                            <h5 class="fs-15 mb-0">{{$country->DocumentModel->title}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Document UUID :</p>
                                            <h5 class="fs-15 mb-0">{{$country->DocumentModel->uuid}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">User Name :</p>
                                            <h5 class="fs-15 mb-0">{{$country->User->name}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">User Email :</p>
                                            <h5 class="fs-15 mb-0">{{$country->User->email}}</h5>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <div class="row">
                                    
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Requested Date :</p>
                                            <h5 class="fs-15 mb-0">{{$country->created_at}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Status :</p>
                                            @if($country->status == 2)
                                            <div class="badge bg-success fs-12">Completed</div>
                                            @elseif($country->status == 1)
                                            <div class="badge bg-info fs-12">In Progress</div>
                                            @else
                                            <div class="badge bg-danger fs-12">Pending</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($country->message)
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <h6 class="fw-semibold text-uppercase">Message From {{$country->User->name}}</h6>
                                <p>{!!$country->message!!}</p>
                            </div>
                            @endif

                            <div id="image-container">
                                @if($country->DocumentModel->document)
                                <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                    <h6 class="fw-semibold text-uppercase">Document</h6>

                                    <div id="my_pdf_viewer" oncontextmenu="return false">
                                        <div id="pdf_controllers">

                                            <div id="navigation_controls">
                                                <button id="go_previous" title="previous page"><i class="bx bx-skip-previous"></i></button>
                                                <label>
                                                    <input id="current_page" value="1" type="text"/>
                                                    /<span id="totalPageCount">0</span>
                                                </label>
                                                <button id="go_next" title="next page"><i class="bx bx-skip-next"></i></button>
                                            </div>
                                    
                                            <div id="zoom_controls">  
                                                <button id="zoom_in" title="zoom in"><i class="ri-zoom-in-line"></i></button>
                                                <button id="zoom_out" title="zoom out"><i class="ri-zoom-out-line"></i></button>
                                            </div> 
                                        </div>

                                        <div id="canvas_container">
                                            <canvas id="pdf_renderer"></canvas>
                                        </div>
                                
                                        
                                    </div>

                                </div>
                                @endif
                            </div>

                            
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>


    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop          

@section('javascript')
<script src="http://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<script>
    function deleteHandler(url){
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
                ['<button><b>YES</b></button>', function (instance, toast) {

                    window.location.replace(url);
                    // instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }, true],
                ['<button>NO</button>', function (instance, toast) {
        
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }],
            ],
            onClosing: function(instance, toast, closedBy){
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    }
</script>
<script>

    
    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 1
    }
    
    pdfjsLib.getDocument('{{asset('storage/upload/documents/'.$country->DocumentModel->document)}}').then((pdf) => {
    
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
@stop