<form class="modal-content ajax-form" action="{{ route('admin.faqs.update', ['faq' => $faq->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات السؤال</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>القسم</label>
                <select class="form-control" name="faq_category_id">
                    <option value="0">إختر القسم</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $faq->faq_category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->translate('ar')->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12">
                <label>الترتيب</label>
                <input type="number" class="form-control" name="order" value="{{ $faq->order }}">
            </div>
            <div class="form-group col-sm-12">
                <label>السؤال</label>
                <input type="text" class="form-control" name="question" value="{{ $faq->question }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الإجابه</label>
                <textarea class="form-control required" name="answer" rows="7">{{ $faq->answer }}</textarea>
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
