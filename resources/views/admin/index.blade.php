@extends('layouts.admin')
@push('css')

@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="maincontent">
            <!-- Small boxes (Stat box) -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">

                        <h3>{{$totalVideo}}</h3>

                        <p>Total Videos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">

                        <h3>{{$totalCategory}}</h3>

                        <p>Total Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">

                        <h3>{{$totalSubCategory}}</h3>

                        <p>Total Sub Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-person"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$totalTag}}</h3>

                        <p>Total Tags</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->


            <!-- Left col -->
            <section class="col-lg-12">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Admin-Users/Editors Log Summery</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Admin User</th>
                                    <th>job_title</th>
                                    <th>Total Added Video</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($adminUsers as $user)
                                    <tr>
                                        <td><a href="#">{{$user->name}}</a></td>
                                        <td>{{$user->job_title}}</td>
                                        <td>
                                            <?php
                                                $totalVideo_per_user = \App\Video::where('user_id',$user->id)->count();
                                            ?>
                                            {{$totalVideo_per_user}}
                                        </td>
                                        <td><span class="label label-success">Shipped</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    {{--<div class="box-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All
                            Orders</a>
                    </div>--}}
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            {{--<section class="col-lg-6">--}}

            {{--<!-- Calendar -->--}}
            {{--<div class="box box-solid">--}}
            {{--<div class="box-header">--}}
            {{--<i class="fa fa-calendar"></i>--}}

            {{--<h3 class="box-title">Calendar</h3>--}}
            {{--<!-- tools box -->--}}
            {{--<div class="pull-right box-tools">--}}
            {{--<!-- button with a dropdown -->--}}
            {{--<button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>--}}
            {{--</button>--}}
            {{--<button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>--}}
            {{--</button>--}}
            {{--</div>--}}
            {{--<!-- /. tools -->--}}
            {{--</div>--}}
            {{--<!-- /.box-header -->--}}
            {{--<div class="box-body no-padding">--}}
            {{--<!--The calendar -->--}}
            {{--<div id="calendar" style="width: 100%"></div>--}}
            {{--</div>--}}
            {{--<!-- /.box-body -->--}}
            {{--</div>--}}
            {{--<!-- /.box -->--}}

            {{--</section>--}}
            <!-- right col -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
<script src="{{asset('superadmin/dist/js/pages/dashboard.js')}}"></script>
<script type="text/javascript">
    $('#dashorder').slimScroll({
        height: '200px'
    });
</script>

@endpush
