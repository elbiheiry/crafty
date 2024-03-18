@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>المدربين</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">المدربين</li>
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
                                    <b>رقم الطلب #{{ $trainer->id }}</b><br>
                                    <b> الإسم : </b>{{ $trainer->name }}<br>
                                    <b>البريد الإلكتروني:</b> {{ $trainer->email }}<br>
                                    <b>رقم الهاتف:</b> {{ $trainer->phone }}<br>
                                    <b>السن:</b> {{ $trainer->age }}<br>
                                    <b>المحافظة:</b> {{ $trainer->government }}<br>
                                    <b>المدينة أو المركز:</b> {{ $trainer->city }}<br>
                                    <b>القرية أو المنطقة:</b> {{ $trainer->state }}<br>
                                    <b>هل سبق لك تنفيذ دورات تدريبية:</b> {{ $trainer->previous_experience }}<br>
                                    @if ($trainer->experience)
                                        <b>اذكر الدورات وأماكن التدريب:</b> {{ $trainer->experience }}<br>
                                    @endif
                                    @if ($trainer->content)
                                        <b>المحتوى الذى تود تقديم دورات تدريبية فيه:</b> {{ $trainer->content }}<br>
                                    @endif
                                    @if ($trainer->experience)
                                        <b>اذكر الدورات وأماكن التدريب:</b> {{ $trainer->experience }}<br>
                                    @endif
                                    @if ($trainer->facebook)
                                        <b>رابط الفيسبوك:</b> {{ $trainer->facebook }}<br>
                                    @endif
                                    @if ($trainer->youtube)
                                        <b>رابط اليوتيوب:</b> {{ $trainer->youtube }}<br>
                                    @endif
                                    @if ($trainer->instagram)
                                        <b>رابط الإنستجرام:</b> {{ $trainer->instagram }}<br>
                                    @endif
                                    <b>أنشئ في : </b> {{ $trainer->created_at->format('d-m-Y') }}<br>

                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{ get_image($trainer->cv, 'trainers') }}" rel="noopener" target="_blank"
                                        class="btn btn-default download" download><i class="fas fa-download"></i> تحميل
                                        السيرة الذاتية</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection
