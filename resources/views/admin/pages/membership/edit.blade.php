<form class="modal-content ajax-form"
    action="{{ route('admin.membership.update', ['membership' => $membership->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الميزة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>العنوان</label>
                <input type="text" class="form-control" name="title" value="{{ $membership->title }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الوصف</label>
                <textarea class="form-control required" name="description" rows="7">{{ $membership->description }}</textarea>
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
