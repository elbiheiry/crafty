@extends('admin.layouts.master')
@push('models')
    <!-- Modal Add Employees -->
    <div class="modal fade " id="add-team">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.team.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h4 class="modal-title">إضافة عضو جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>إرفق الصورة </label>
                            <input type="file" class="jfilestyle" name="image" />
                            <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                                يجب ان تكون : 170 * 170</div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>إسم العضو</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>وظيفة العضو</label>
                            <input type="text" class="form-control" name="position">
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
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal Add Employees -->
    <div class="modal fade " id="common-modal">
        <div class="modal-dialog" id="edit-area">

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>الأعضاء</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">الأعضاء</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            @can('team-create')
                                <div class="card-header">
                                    <button type="button" class="btn btn-success btn-sm " data-toggle="modal"
                                        data-target="#add-team">
                                        <i class="fa fa-plus"></i>
                                        عضو جديد
                                    </button>
                                </div>
                            @endcan
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-crud" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الإسم</th>
                                            <th>أنشئ في</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.team.index') }}",
                language: {
                    "decimal": "",
                    "emptyTable": "لا يوجد بيانات حتي الان.",
                    "info": "عرض _START_ الي _END_ من _TOTAL_ صفوف",
                    "infoEmpty": "عرض 0 الي 0 من 0 صفوف",
                    "infoFiltered": "(تصفية من _MAX_ الكل صفوف)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "عرض _MENU_ صفوف",
                    "loadingRecords": "تحميل...",
                    "processing": "معالجة...",
                    "search": "البحث:",
                    "zeroRecords": "لا يوجد بيانات تطابق البحث.",
                    "paginate": {
                        "first": "الاول",
                        "last": "الاخير",
                        "next": "التالي",
                        "previous": "السابق"
                    },
                    "aria": {
                        "sortAscending": ": اضغط للترتيب تصاعديا",
                        "sortDescending": ": اضغط للترتيب تنازليا"
                    }
                },
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print"],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    </script>
@endpush
