@extends('admin.layouts.master')
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-crud" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الإسم</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>العنوان</th>
                                            <th>الحاله</th>
                                            <th>أنشئ في</th>
                                            <th>الحالات</th>
                                        </tr>

                                        @php
                                            $x = 1;
                                        @endphp
                                        @foreach ($subscribers as $index => $subscriber)
                                            <tr>
                                                <td>{{ $x }}</td>
                                                <td>{{ $subscriber->user->name }}</td>
                                                <td>{{ $subscriber->user->email }}</td>
                                                <td>{{ $subscriber->user->phone }}</td>
                                                <td>{{ $subscriber->user->country }} ,{{ $subscriber->user->city }}
                                                    ,{{ $subscriber->user->address }}</td>
                                                <td>
                                                    {{ $subscriber->order->status == 'pending' ? 'غير مفعل' : 'مفعل' }}
                                                </td>
                                                <td>{{ $subscriber->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a class="custom-btn btn btn-danger"
                                                        href="{{ route('admin.packages.members.delete', ['id' => $subscriber->id]) }}">إالغاء
                                                        الإشتراك </a>
                                                </td>
                                            </tr>
                                            @php
                                                $x++;
                                            @endphp
                                        @endforeach
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
