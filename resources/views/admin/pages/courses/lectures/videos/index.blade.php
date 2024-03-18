@extends('admin.layouts.master')
@push('models')
    <!-- Modal Add Employees -->
    <div class="modal fade " id="add-video">
        <div class="modal-dialog">
            <form class="modal-content" id="courseform"
                action="{{ route('admin.courses.lectures.videos.store', ['id' => $id]) }}" method="post">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h4 class="modal-title">إضافة رابط جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label>الأسم</label>
                            <input type="text" class="form-control required" name="name">
                        </div>
                        @if ($type == 'free')
                            <div class="form-group col-sm-12">
                                <label>إرفق الفيديو </label>
                                <input type="file" class="jfilestyle" name="link" />
                            </div>
                        @else
                            <div class="form-group col-sm-12">
                                <label>الرابط</label>
                                <input type="text" class="form-control" name="link">
                            </div>
                        @endif
                        <div class="form-group col-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 0%"></div>
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
                        <h1>الروابط</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">الروابط</li>
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
                            @can('course-lecture-video-create')
                                <div class="card-header">
                                    <button type="button" class="btn btn-success btn-sm " data-toggle="modal"
                                        data-target="#add-video">
                                        <i class="fa fa-plus"></i>
                                        رابط جديد
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
                ajax: "{{ route('admin.courses.lectures.videos.index', ['id' => $id]) }}",
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
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
        <script>
            $(function() {
                $(document).ready(function() {
                    $('#courseform').ajaxForm({
                        beforeSend: function() {
                            var percentage = '0';
                            $('#courseform').find(":submit").attr('disabled', true).html(
                                'برجاء الإنتظار');
                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentage = percentComplete;
                            $('.progress .progress-bar').css("width", percentage + '%', function() {
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
                            $('#courseform').find(":submit").attr('disabled', false).html('حفظ');
                        },
                        complete: function(xhr) {
                            console.log('File has uploaded');
                        }
                    });
                });
            });
        </script>
    @endpush
@endpush
