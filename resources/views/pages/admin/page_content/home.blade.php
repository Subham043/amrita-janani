@extends('layouts.admin.dashboard')


@section('css')
    <link href="{{ asset('admin/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/tagify.css') }}" rel="stylesheet" type="text/css" />

    <style>
        #description, #description_update {
            min-height: 200px;
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
                        <h4 class="mb-sm-0">Page</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                                <li class="breadcrumb-item active">{{$page_name}}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form id="countryForm" method="post" action="{{ route('updatePage', $page_detail->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{$page_name}} Page</h4>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="row gy-4">
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" id="title"
                                                    value="{{ $page_detail->title }}">
                                                @error('title')
                                                    <div class="invalid-message">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="page_name" class="form-label">Page Name</label>
                                                <input type="text" class="form-control" name="page_name" id="page_name" disabled readonly
                                                    value="{{ $page_detail->page_name }}">
                                                @error('page_name')
                                                    <div class="invalid-message">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="url" class="form-label">Url</label>
                                                <input type="text" class="form-control" name="url" id="url" disabled readonly
                                                    value="{{ $page_detail->url }}">
                                                @error('url')
                                                    <div class="invalid-message">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xxl-12 col-md-12">
                                            <button type="submit" class="btn btn-primary jpges-effect waves-light"
                                                id="submitBtn">Update</button>
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
                                <h4 class="card-title mb-0 flex-grow-1">{{$page_name}} Page Content</h4>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <button onclick=""
                                            type="button" class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                                class="ri-add-line align-bottom me-1"></i> Add Page Content</button>
                                    </div>
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        @if(count($page_content_detail) > 0)
                                        <table class="table align-middle table-nowrap" id="customerTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="sort" data-sort="customer_name">Heading</th>
                                                    <th class="sort" data-sort="customer_name">Image</th>
                                                    <th class="sort" data-sort="date">Created Date</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
        
                                                @foreach ($page_content_detail as $item)
                                                <tr>
                                                    <td class="customer_name">{{$item->heading}}</td>
                                                    <td class="customer_name">{{$item->image}}</td>
                                                    <td class="customer_name">{{$item->created_at}}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <div class="edit">
                                                                <button data-bs-toggle="modal" data-bs-target="#myModalUpdate" onclick="editHandlers({{$item->id}})" class="btn btn-sm btn-success edit-item-btn">Edit</button>
                                                            </div>
                                                            <div class="remove">
                                                                <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteHandler('{{route('deletePageContent', $item->id)}}')">Remove</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                        @else
                                        <div class="noresult">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                </lord-icon>
                                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        @include('pages.admin.page_content.add_content_modal')
        @include('pages.admin.page_content.update_content_modal')

    </div> <!-- container-fluid -->
    </div><!-- End Page-content -->



@stop


@section('javascript')
    <script src="{{ asset('admin/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

    <script type="text/javascript">
        var quillDescription = new Quill('#description', {
            theme: 'snow'
        });
        var quillDescriptionUpdate = new Quill('#description_update', {
            theme: 'snow'
        });
    </script>

    <script type="text/javascript">
        // initialize the validation library
        const validation = new JustValidate('#countryForm', {
            errorFieldCssClass: 'is-invalid',
        });
        // apply rules to form fields
        validation
            .addField('#title', [{
                    rule: 'required',
                    errorMessage: 'Title is required',
                },
                {
                    rule: 'customRegexp',
                    value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
                    errorMessage: 'Title is invalid',
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
                    formData.append('title', document.getElementById('title').value)
                    formData.append('page_name', document.getElementById('page_name').value)
                    formData.append('url', document.getElementById('url').value)

                    const response = await axios.post('{{ route('updatePage', $page_detail->id) }}', formData)
                    successToast(response.data.message)
                    setTimeout(function() {
                        window.location.replace(response.data.url);
                    }, 1000);
                } catch (error) {
                    console.log(error);
                    if (error?.response?.data?.form_error?.title) {
                        errorToast(error?.response?.data?.form_error?.title[0])
                    }
                    if (error?.response?.data?.form_error?.year) {
                        errorToast(error?.response?.data?.form_error?.year[0])
                    }
                    if (error?.response?.data?.form_error?.deity) {
                        errorToast(error?.response?.data?.form_error?.deity[0])
                    }
                } finally {
                    submitBtn.innerHTML = `
                Update
                `
                    submitBtn.disabled = false;
                }
            });
    </script>



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

@include('pages.admin.page_content.add_content_modal_js')
@include('pages.admin.page_content.update_content_modal_js')

@stop
