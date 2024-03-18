<form class="modal-content ajax-form" action="{{ route('admin.team.update', ['team' => $team->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الرابط</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row text-center">
            {{-- <img src="{{ get_image($team->image, 'team') }}" width="100"> --}}
            <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $team->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                width="100">
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>إرفق الصورة </label>
                <input type="file" class="jfilestyle" name="image" />
                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                    يجب ان تكون : 170 * 170</div>
            </div>
            <div class="form-group col-sm-12">
                <label>إسم العضو</label>
                <input type="text" class="form-control" name="name" value="{{ $team->translate('ar')->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>وظيفة العضو</label>
                <input type="text" class="form-control" name="position"
                    value="{{ $team->translate('ar')->position }}">
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
