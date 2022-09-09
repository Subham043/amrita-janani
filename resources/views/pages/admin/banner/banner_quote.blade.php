@extends('layouts.admin.dashboard')


@section('css')

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
                            <li class="breadcrumb-item active">Banner Quotes</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{ route('banner_quote_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Banner Quote</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <div>
                                            <label for="quote" class="form-label">Quote</label>
                                            <input type="text" class="form-control" name="quote" id="quote" value="{{old('quote')}}">
                                            @error('quote') 
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
                        <h4 class="card-title mb-0 flex-grow-1">Banner Quotes</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                                <div class="live-preview">
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        @if(count($quotes) > 0)
                                        <table class="table align-middle table-nowrap" id="customerTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="sort" data-sort="customer_name">Quote</th>
                                                    <th class="sort" data-sort="date">Created Date</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
        
                                                @foreach ($quotes as $item)
                                                <tr>
                                                    <td class="customer_name">{{$item->quote}}</td>
                                                    <td class="customer_name">{{$item->created_at}}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <div class="remove">
                                                                <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteHandler('{{route('banner_quote_delete', $item->id)}}')">Remove</button>
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


</div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop


@section('javascript')
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>


<script type="text/javascript">
// initialize the validation library
const validation = new JustValidate('#countryForm', {
    errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#quote', [
    {
      rule: 'required',
      errorMessage: 'Quote is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Quote is invalid',
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
            formData.append('quote',document.getElementById('quote').value)

            const response = await axios.post('{{ route('banner_quote_store') }}', formData)
            successToast(response.data.message)
            setTimeout(function() {
                window.location.replace(response.data.url);
            }, 1000);
        } catch (error) {
            console.log(error);
            if(error?.response?.data?.form_error?.quote){
                errorToast(error?.response?.data?.form_error?.quote[0])
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


@stop