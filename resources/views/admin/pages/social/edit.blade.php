<form class="modal-content ajax-form" action="{{ route('admin.social.update', ['link' => $link->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الرابط</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>الأسم</label>
                <input type="text" class="form-control" name="name" value="{{ $link->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الرابط</label>
                <input type="text" class="form-control" name="link" value="{{ $link->link }}">
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
