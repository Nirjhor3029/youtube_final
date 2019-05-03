@extends('layouts.admin')
@push('css')

@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
        </section>

        <section class="maincontent row container-fluid">
            <div class="col-lg-3 col-xs-6">
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
            <div class="col-lg-3 col-xs-6">
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
            <div class="col-lg-3 col-xs-6">
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
            <div class="col-lg-3 col-xs-6">
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

            <section class="col-lg-12">
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
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="table" class="table no-margin">
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
                    </div>

                </div>
            </section>



        </section>



    </div>
@endsection
@push('scripts')


<script>
    $(function () {
        $('#table').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'order': [[ 2, "desc" ]],
            'info': true,
            'autoWidth': false

        })
    })
</script>
@endpush
