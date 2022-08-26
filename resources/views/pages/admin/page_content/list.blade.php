@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dynamic Web Pages</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dynamic Web Pages</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Dynamic Web Pages</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <button  data-bs-toggle="modal" data-bs-target="#myModal" type="button" class="btn btn-success add-btn" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create</button>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <form  method="get" action="{{route('dynamic_page_list')}}">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" name="search" class="form-control search" placeholder="Search..." value="@if(app('request')->has('search')){{app('request')->input('search')}}@endif">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($country->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Title</th>
                                            <th class="sort" data-sort="customer_name">Page Name</th>
                                            <th class="sort" data-sort="customer_name">Url</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="status">Restricted</th>
                                            <th class="sort" data-sort="date">Created Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">

                                        @foreach ($country->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->title}}</td>
                                            <td class="customer_name">{{$item->page_name}}</td>
                                            <td class="customer_name">{{$item->url}}</td>
                                            @if($item->status == 1)
                                            <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                            @else
                                            <td class="status"><span class="badge badge-soft-danger text-uppercase">Inactive</span></td>
                                            @endif
                                            @if($item->restricted == 1)
                                            <td class="status"><span class="badge badge-soft-success text-uppercase">Yes</span></td>
                                            @else
                                            <td class="status"><span class="badge badge-soft-danger text-uppercase">No</span></td>
                                            @endif
                                            <td class="date">{{$item->created_at}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{route('edit_dynamic_page', $item->id)}}" class="btn btn-sm btn-success edit-item-btn">Edit</a>
                                                    </div>
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteHandler('{{route('deletePage', $item->id)}}')">Remove</button>
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
                            
                            @if($country->total() > 0)
                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev {{ $country->currentPage() > 1 ? '' : 'disabled' }} " href="{{ $country->currentPage() > 1 ? $country->previousPageUrl() : '#' }}">
                                        Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0">
                                        @for ($i = 1; $i <= $country->lastPage(); $i++)
                                        <li class=" {{ $country->currentPage() == $i ? 'active' : '' }}"><a class="page" href="{{$country->url($i)}}">{{ $i }}</a></li>
                                        @endfor
                                    </ul>
                                    <a class="page-item pagination-next {{ $country->currentPage() == $country->lastPage() ? 'disabled' : '' }}" href="{{ $country->currentPage() == $country->lastPage() ? '#' : $country->nextPageUrl() }}">
                                        Next
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        @include('pages.admin.page_content.create_page_modal')

    </div>
</div>

@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

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
        .addField('#page_name', [{
                rule: 'required',
                errorMessage: 'Page Name is required',
            },
            {
                rule: 'customRegexp',
                value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
                errorMessage: 'Page Name is invalid',
            },
        ])
        .addField('#url', [{
                rule: 'required',
                errorMessage: 'URL is required',
            },
            {
                rule: 'customRegexp',
                value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
                errorMessage: 'URL is invalid',
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

                const response = await axios.post('{{ route('storePage') }}', formData)
                successToast(response.data.message)
                setTimeout(function() {
                    window.location.replace(response.data.url);
                }, 1000);
            } catch (error) {
                console.log(error);
                if (error?.response?.data?.form_error?.title) {
                    errorToast(error?.response?.data?.form_error?.title[0])
                }
                if (error?.response?.data?.form_error?.page_name) {
                    errorToast(error?.response?.data?.form_error?.page_name[0])
                }
                if (error?.response?.data?.form_error?.url) {
                    errorToast(error?.response?.data?.form_error?.url[0])
                }
            } finally {
                submitBtn.innerHTML = `
            Update
            `
                submitBtn.disabled = false;
            }
        });
</script>

@stop