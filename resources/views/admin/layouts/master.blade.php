<!DOCTYPE html>
<html lang="en" dir="rtl">
@include('admin.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('admin.layouts.header')
        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        {{-- <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer> --}}
        <div class="modal fade " id="delete">
            <div class="modal-dialog">
                <form class="modal-content" id="delete-form" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h4 class="modal-title">هل أنت متاكد ؟</h4>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                            غلق</button>
                        <button type="submit" class="btn btn-danger ">
                            <i class="fa fa-trash"></i> حذف
                        </button>
                    </div>
                </form><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade " id="restore">
            <div class="modal-dialog">
                <form class="modal-content" id="restore-form" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h4 class="modal-title">هل أنت متاكد ؟</h4>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times"></i> غلق</button>
                        <button type="submit" class="btn btn-success ">
                            <i class="fa fa-save"></i> تأكيد
                        </button>
                    </div>
                </form><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        @stack('models')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('admin.layouts.scripts')
</body>

</html>
