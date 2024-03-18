<form class="modal-content ajax-form" action="{{ route('admin.roles.update', ['role' => $role->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات الدور</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>الأسم</label>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الأذونات</label>
                <table class="table table-striped">
                    <thead>
                        <th><input type="checkbox" name="permissions"></th>
                        <th>الاسم</th>
                    </thead>

                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" name="permission[{{ $permission->name }}]"
                                    value="{{ $permission->name }}" class='permission1'
                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            </td>
                            <td>{{ $permission->name }}</td>
                        </tr>
                    @endforeach
                </table>

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
<script>
    $(document).ready(function() {
        $('[name="permissions"]').on('click', function() {

            if ($(this).is(':checked')) {
                $.each($('.permission1'), function() {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($('.permission1'), function() {
                    $(this).prop('checked', false);
                });
            }

        });
    });
</script>
