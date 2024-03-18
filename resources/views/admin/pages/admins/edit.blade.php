<form class="modal-content ajax-form" action="{{ route('admin.admins.update', ['admin' => $admin->id]) }}"
    method="PUT">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h4 class="modal-title">تعديل بيانات المستخدم</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label>الأسم</label>
                <input type="text" class="form-control required" name="name" value="{{ $admin->name }}">
            </div>
            <div class="form-group col-sm-12">
                <label>البريد الإلكتروني</label>
                <input type="email" class="form-control required" name="email" value="{{ $admin->email }}">
            </div>
            <div class="form-group col-sm-12">
                <label>الرقم السري</label>
                <input type="password" class="form-control required" name="password">
            </div>
            <div class="form-group col-sm-12">
                <label for="role" class="form-label">الدور</label>
                <select class="form-control" name="role" required>
                    <option value="0">أختر الدور</option>
                    @foreach ($allroles as $role)
                        <option value="{{ $role->id }}" {{ in_array($role->name, $adminRole) ? 'selected' : '' }}>
                            {{ $role->name }}</option>
                    @endforeach
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
