<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Page Content</h5>
                <button type="button" id="myModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalAddForm" method="post" action="{{ route('storePageContent') }}" enctype="multipart/form-data">
                    @csrf
                <div class="card-body" style="padding: 0">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="heading" class="form-label">Heding</label>
                                    <input type="text" class="form-control" name="heading" id="heading"
                                        value="{{ old('heading') }}">
                                    @error('heading')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image" id="image">
                                    @error('image')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="image_position" class="form-label">Image Position</label>
                                    <select class="form-control" name="image_position" id="image_position">
                                        <option value="1">left</option>
                                        <option value="2">right</option>
                                    </select>
                                    @error('image_position')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xxl-12 col-md-12">
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <div id="description"></div>
                                    @error('description')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-12 col-md-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                    id="submitBtnModal">Add</button>
                            </div>

                            

                        </div>
                    </div>
                </div>
            </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->