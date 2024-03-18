@extends('admin.layouts.master')
@push('models')
    <!-- Modal Add Employees -->
    <div class="modal fade " id="add-faqs">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.membership.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h4 class="modal-title">إضافة ميزة جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>العنوان</label>
                            <input type="text" class="form-control required" name="title">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>الوصف</label>
                            <textarea class="form-control required" name="description" rows="7"></textarea>
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
                        <h1>مزايا العضوية</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">مزايا العضوية</li>
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
                            @can('membership-benefit-create')
                                <div class="card-header">
                                    <button type="button" class="btn btn-success btn-sm " data-toggle="modal"
                                        data-target="#add-faqs">
                                        <i class="fa fa-plus"></i>
                                        ميزة جديد
                                    </button>
                                </div>
                            @endcan
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-crud" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العنوان</th>
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
                ajax: "{{ route('admin.membership.index') }}",
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
                        data: 'title',
                        name: 'title'
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
