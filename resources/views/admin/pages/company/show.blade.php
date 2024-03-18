@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>الشركات والمؤسسات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">الشركات والمؤسسات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <b>رقم الطلب #{{ $company->id }}</b><br>
                                    <b> الإسم : </b>{{ $company->name }}<br>
                                    <b>البريد الإلكتروني:</b> {{ $company->email }}<br>
                                    <b>رقم الهاتف:</b> {{ $company->phone }}<br>
                                    <b>إسم الشركه:</b> {{ $company->company_name }}<br>
                                    <b>عدد الموظفين:</b> {{ $company->no_of_employees }}<br>
                                    <b>أنشئ في : </b> {{ $company->created_at->format('d-m-Y') }}<br>
                                    <b>أخبرنا عن شركتك أو مؤسستك:</b> {{ $company->description }}<br>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection
