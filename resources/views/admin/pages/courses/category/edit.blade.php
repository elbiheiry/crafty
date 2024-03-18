<form class="modal-content ajax-form"
    action="{{ route('admin.courses.category.update', ['category' => $category->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات القسم</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row col-sm-12">
            {{-- <img src="{{ get_image($category->image, 'courses') }}" style="width:100px;"> --}}
            <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $category->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                width="100">
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>إرفق الصورة </label>
                <input type="file" class="jfilestyle" name="image" />
                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                    يجب ان تكون : 36 * 38</div>
            </div>
            <div class="form-group col-sm-12">
                <label>الإسم</label>
                <input type="text" class="form-control" name="name" value="{{ $category->translate('ar')->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الإسم</label>
                <input type="text" class="form-control" name="slug" value="{{ $category->slug }}">
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
