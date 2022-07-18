<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Guide</h5>
                <button type="button" id="myModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="live-preview">
                    <p><code><b>Step 1:</b></code> First you need to upload an excel sheet. The excel sheet must contain atleast one row of data. Maximum 20 rows of data are allowed.<br><code>Note:</code>Download sample excel sheet. <a href="{{asset('storage/excel/audio.xlsx')}}" download type="button" class="btn btn-ghost-info btn-sm waves-effect waves-light add-btn" id="create-btn"><i class="ri-download-line align-bottom me-1"></i> Download</a></p>
                    <p><code><b>Step 2:</b></code> Second you need to upload the audios in the upload section. Maximum 20 numbers of audios are allowed at a time. Please note that the number of audios should match the number of rows of data in the excel. You can drag and drop audios as well as rearrange the audios in their order.</p>
                    <p><code><b>Step 3:</b></code> Third press the upload button.</p>
                </div>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
