@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>الدورات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">الدورات</li>
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
                            @can('course-create')
                                <div class="card-header">
                                    <a href="{{ route('admin.courses.create', ['type' => request()->type]) }}"
                                        class="btn btn-success btn-sm ">
                                        <i class="fa fa-plus"></i>
                                        دورة جديدة
                                    </a>
                                </div>
                            @endcan

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-crud" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العنوان</th>
                                            <th>القسم</th>
                                            @if (request()->type == 'paid')
                                                <th>السعر</th>
                                                <th>التصنيف</th>
                                            @endif
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
                ajax: "{{ route('admin.courses.index', ['type' => request()->type]) }}",
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
                        name: 'name',
                        render: function(data, type, full, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    @if (request()->type == 'paid')
                        {
                        data: 'price',
                        name: 'price'
                        },
                        {
                        data: 'level',
                        name: 'level'
                        },
                    @endif {
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
