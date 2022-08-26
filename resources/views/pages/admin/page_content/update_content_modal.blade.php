<div id="myModalUpdate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Page Content</h5>
                <button type="button" id="myModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalUpdateForm" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="card-body" style="padding: 0">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="heading_update" class="form-label">Heding</label>
                                    <input type="text" class="form-control" name="heading_update" id="heading_update"
                                        value="{{ old('heading_update') }}">
                                    <input type="hidden" class="form-control" name="item_id" id="item_id">
                                    @error('heading_update')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="image_update" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image_update" id="image_update">
                                    @error('image_update')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-4 col-md-12">
                                <div>
                                    <label for="image_position_update" class="form-label">Image Position</label>
                                    <select class="form-control" name="image_position_update" id="image_position_update">
                                        <option value="1">left</option>
                                        <option value="2">right</option>
                                    </select>
                                    @error('image_position_update')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xxl-12 col-md-12">
                                <div>
                                    <label for="description_update" class="form-label">Description</label>
                                    <div id="description_update"></div>
                                    @error('description_update')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-12 col-md-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                    id="updateBtnModal">Update</button>
                            </div>

                            

                        </div>
                    </div>
                </div>
            </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

