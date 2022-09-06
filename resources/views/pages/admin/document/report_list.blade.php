@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Reports</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
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
                        <h4 class="card-title mb-0">Documents</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                
                                <div class="col-sm row mt-4" style="justify-content: flex-end">
                                    <form  method="get" action="{{route('document_view_report')}}" class="col-sm-auto" onsubmit="return callSearchHandler()">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <select name="filter" id="filter" class="form-control" onchange="return callSearchHandler()">
                                                    <option value="all" @if((app('request')->has('filter')) && (app('request')->input('filter')=='all')) selected @endif>All</option>
                                                    <option value="0" @if(app('request')->has('filter') && (app('request')->input('filter')=='0')) selected @endif>Pending</option>
                                                    <option value="1" @if(app('request')->has('filter') && (app('request')->input('filter')=='1')) selected @endif>In Progress</option>
                                                    <option value="2" @if(app('request')->has('filter') && (app('request')->input('filter')=='2')) selected @endif>Completed</option>
                                                </select>
                                                <i class="ri-arrow-up-down-line search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                    <form  method="get" class="col-sm-auto" action="{{route('document_view_report')}}" onsubmit="return callSearchHandler()">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" id="search" name="search" class="form-control search" placeholder="Search..." value="@if(app('request')->has('search')) {{app('request')->input('search')}} @endif">
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
                                            <th class="sort" data-sort="customer_name">Document Title</th>
                                            <th class="sort" data-sort="customer_name">Document UUID</th>
                                            <th class="sort" data-sort="customer_name">User Name</th>
                                            <th class="sort" data-sort="customer_name">User Email</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="date">Requested Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">

                                        @foreach ($country->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->DocumentModel->title}}</td>
                                            <td class="customer_name">{{$item->DocumentModel->uuid}}</td>
                                            <td class="customer_name">{{$item->User->name}}</td>
                                            <td class="customer_name">{{$item->User->email}}</td>
                                            @if($item->status == 2)
                                            <td class="status"><span class="badge badge-soft-success text-uppercase">Completed</span></td>
                                            @elseif($item->status == 1)
                                            <td class="status"><span class="badge badge-soft-info text-uppercase">In Progress</span></td>
                                            @else
                                            <td class="status"><span class="badge badge-soft-danger text-uppercase">Pending</span></td>
                                            @endif
                                            <td class="date">{{$item->created_at}}</td>
                                            <td>
                                                <div class="d-flex gap-2" style="align-items:center">
                                                    <div class="search-box edit">
                                                        <form action="{{route('document_toggle_report', $item->id)}}" method="get">
                                                            <select class="form-control" name="status" onchange="this.form.submit()" style="min-width: 100px;">
                                                                <option value="0" {{ $item->status==0 ? 'selected':''}}>Pending</option>
                                                                <option value="1" {{ $item->status==1 ? 'selected':''}}>In progress</option>
                                                                <option value="2" {{ $item->status==2 ? 'selected':''}}>Completed</option>
                                                            </select>
                                                        </form>
                                                        <i class="ri-arrow-up-down-line search-icon"></i>
                                                    </div>
                                                    <div class="edit">
                                                        <a href="{{route('document_display_report', $item->id)}}" class="btn btn-sm btn-info edit-item-btn">View</a>
                                                    </div>
                                                    <div class="edit">
                                                        <a href="{{route('document_display', $item->DocumentModel->id)}}" class="btn btn-sm btn-warning edit-item-btn">Go To Document</a>
                                                    </div>
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteHandler('{{route('document_delete_report', $item->id)}}')">Delete</button>
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

    </div>
</div>

@stop

@section('javascript')

{{-- <script src="{ asset('admin/libs/list.js/list.min.js') }}"></script> --}}
{{-- <script src="{ asset('admin/libs/list.pagination.js/list.pagination.min.js') }}"></script> --}}

<!-- listjs init -->
{{-- <script src="{ asset('admin/js/pages/listjs.init.js') }}"></script> --}}

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
    function callSearchHandler(){
        var str= "";
        var arr = [];
        if(document.getElementById('search').value){
            arr.push("search="+document.getElementById('search').value)
        }
        if(document.getElementById('filter').value){
            arr.push("filter="+document.getElementById('filter').value)
        }
        str = arr.join('&');
        window.location.replace('{{route('document_view_report')}}?'+str)
        return false;
    }
</script>

@stop