<form class="modal-content ajax-form" action="{{ route('admin.packages.update', ['package' => $package->id]) }}"
    method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الباقة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row text-center">
            {{-- <img src="{{ get_image($package->image, 'packages') }}" width="100"> --}}
            <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $package->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                width="100">
        </div>
        <div class="row">
            <div class="form-group  col-sm-12">
                <label>إرفق الصورة </label>
                <input type="file" class="jfilestyle" name="image" />
                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                    يجب ان تكون : 200 * 200</div>
            </div>
            <div class="form-group col-sm-12">
                <label>إسم الباقة</label>
                <input type="text" class="form-control" name="name" value="{{ $package->translate('ar')->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>سعر الباقة</label>
                <input type="number" class="form-control" name="price" value="{{ $package->price }}">
            </div>
            <div class="form-group col-sm-12">
                <label>نوع الباقة</label>
                <select class="form-control" name="type">
                    <option value="0">إختر</option>
                    <option value="monthly" {{ $package->type == 'monthly' ? 'selected' : '' }}>شهرية</option>
                    <option value="annual" {{ $package->type == 'annual' ? 'selected' : '' }}>سنوية</option>
                </select>
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
