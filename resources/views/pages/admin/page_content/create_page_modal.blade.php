<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create Page</h5>
                <button type="button" id="myModalClose" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm" method="post" action="{{ route('storePage') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                            >
                                            @error('title')
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="page_name" class="form-label">Page Name</label>
                                            <input type="text" class="form-control" name="page_name" id="page_name"
                                            >
                                            @error('page_name')
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="url" class="form-label">Url</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                            >
                                            @error('url')
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary jpges-effect waves-light"
                                            id="submitBtn">Create</button>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>

                    </div>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
