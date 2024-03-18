<form class="modal-content ajax-form" action="{{ route('admin.coupones.update', ['coupone' => $coupone->id]) }}"
    method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الكوبون</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>الكوبون</label>
                <input type="text" class="form-control" name="coupone" value="{{ $coupone->coupone }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الخصم</label>
                <input type="text" class="form-control required" name="discount" value="{{ $coupone->discount }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">غلق</button>
        <button type="submit" class="btn btn-primary ">
            حفظ
        </button>
    </div>
</form><!-- /.modal-content -->
