<form class="modal-content" action="{{ route('admin.courses.lectures.videos.update', ['video' => $video->id]) }}"
    method="post" id="courseform2">
    @csrf
    @method('post')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الرابط</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>الإسم</label>
                <input type="text" class="form-control" name="name" value="{{ $video->translate('ar')->name }}">
            </div>

            @if ($type == 'free')
                <div class="form-group col-sm-12">
                    <label>إرفق الفيديو </label>
                    <input type="file" class="jfilestyle" name="link" />
                </div>
            @else
                <div class="form-group col-sm-12">
                    <label>الرابط</label>
                    <input type="text" class="form-control" name="link" value="{{ $video->link }}">
                </div>
            @endif
            <div class="form-group col-12">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script>
    $(function() {
        $(document).ready(function() {
            $('#courseform2').ajaxForm({
                beforeSend: function() {
                    var percentage = '0';
                    $('#courseform2').find(":submit").attr('disabled', true).html(
                        'برجاء الإنتظار');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%',
                        function() {
                            return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                },
                success: function(response) {
                    notification("success", response, "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, textStatus, errorThrown) {
                    var response = $.parseJSON(xhr.responseText);
                    notification("danger", response, "fas fa-times");
                    $('#courseform2').find(":submit").attr('disabled', false).html('حفظ');
                },
                complete: function(xhr) {
                    console.log('File has uploaded');
                }
            });
        });
    });
</script>
