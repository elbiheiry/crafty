<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">عرض الرسالة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>محتوي الرسالة</label>
                <textarea class="form-control" readonly rows="7">{{ $message->message }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">غلق</button>
    </div>
</div><!-- /.modal-content -->
