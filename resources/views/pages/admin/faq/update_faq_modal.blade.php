<div id="myModalUpdate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">FAQ</h5>
                <button type="button" id="myModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalUpdateForm" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="card-body" style="padding: 0">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12">
                                <div>
                                    <label for="question_update" class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question_update" id="question_update"
                                        value="{{ old('question_update') }}">
                                    <input type="hidden" class="form-control" name="item_id" id="item_id">
                                    @error('question_update')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xxl-12 col-md-12">
                                <div>
                                    <label for="answer_update" class="form-label">Answer</label>
                                    <textarea name="answer_update" class="form-control" id="answer_update" cols="30" rows="10"></textarea>
                                    @error('answer_update')
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

