@extends('layouts.admin.dashboard')


@section('css')
<link rel="stylesheet" href="{{ asset('main/css/plugins/plyr.css')}}" type="text/css" />

@stop


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Audio</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Audio</a></li>
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
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                <button onclick="deleteHandler('{{route('audio_restore_trash', $country->id)}}')" type="button" class="btn btn-info add-btn me-2" id="create-btn"><i class="ri-save-line align-bottom me-1"></i> Restore</button>
                                    <button onclick="deleteHandler('{{route('audio_delete_trash', $country->id)}}')"
                                        type="button" class="btn btn-danger add-btn" id="create-btn"><i
                                            class="ri-delete-bin-line align-bottom me-1"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-muted">
                            <div class="pt-3 pb-3 border-top border-top-dashed border-bottom border-bottom-dashed mt-4">
                                <div class="row">

                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Title :</p>
                                            <h5 class="fs-15 mb-0">{{$country->title}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Year :</p>
                                            <h5 class="fs-15 mb-0">{{$country->year}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Language :</p>
                                            <h5 class="fs-15 mb-0">{{$country->LanguageModel->name}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Deity :</p>
                                            <h5 class="fs-15 mb-0">{{$country->deity}}</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <div class="row">

                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Version :</p>
                                            <h5 class="fs-15 mb-0">{{$country->version}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Uploaded By :</p>
                                            <h5 class="fs-15 mb-0">{{$country->user->name}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Status :</p>
                                            @if($country->status == 1)
                                            <div class="badge bg-success fs-12">Active</div>
                                            @else
                                            <div class="badge bg-danger fs-12">Inactive</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Restricted :</p>
                                            @if($country->restricted == 1)
                                            <div class="badge bg-success fs-12">Yes</div>
                                            @else
                                            <div class="badge bg-danger fs-12">No</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <div class="row">
                                    @if($country->tags)
                                    <div class="col-lg-3 col-sm-6">
                                        @php $tags = explode(",",$country->tags); @endphp
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Tags :</p>
                                            @foreach($tags as $tag)
                                            <div class="badge bg-success fs-12">{{$tag}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Total Favourites :</p>
                                            <h5 class="fs-15 mb-0">{{$country->favourites}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Total Views :</p>
                                            <h5 class="fs-15 mb-0">{{$country->views}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Create Date :</p>
                                            <h5 class="fs-15 mb-0">{{$country->created_at}}</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @if($country->description_unformatted)
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <h6 class="fw-semibold text-uppercase">Description</h6>
                                <p>{!!$country->description!!}</p>
                            </div>
                            @endif

                            <div id="image-container">
                                @if($country->audio)
                                <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                    <h6 class="fw-semibold text-uppercase">Audio</h6>
                                    <audio id="player" controls>
                                        <source src="{{asset('storage/upload/audios/'.$country->audio)}}" type="audio/mp3" />
                                    </audio>
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
<script src="{{ asset('main/js/plugins/plyr.js') }}"></script>
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
];

const player = new Plyr('#player', {
    controls,
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

@stop