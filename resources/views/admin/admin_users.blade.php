<?php
/**
 * Created by PhpStorm.
 * User: Sohel Rana
 * Date: 3/9/2019
 * Time: 8:45 AM
 */
?>

@extends('layouts.admin')

@push('css')
<style>

</style>
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User List
            </h1>

        </section>


        <section class="maincontent">

            <div class="col-md-12" style="margin-top:2rem;">


                @if(isset($success))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{$success}}
                </div>
                @endif

                <div class="box box-danger">

                    <div class="box-body table-responsive">
                        <table id="table" class="table table-bordered">
                            <a href="{{route('addNewUser')}}" class="btn btn-primary">Add New</a>
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>

                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admin_users as $v_admin_user)
                                <tr>
                                    <td>{{$v_admin_user->id}}</td>
                                    <td>{{$v_admin_user->name}}</td>
                                    <td>{{$v_admin_user->job_title}}</td>
                                    <td>{{$v_admin_user->email}}</td>

                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="{{route('editUser',$v_admin_user->id)}}"><i class="fa fa-edit"
                                                                                                      style="font-size:30px;color:green"></i></a>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="{{route('deleteUser',$v_admin_user->id)}}" onclick="return confirm('are you sure')"><i class="fa fa-remove"
                                                                                                 style="font-size:30px;color:red"></i></a>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>

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
            'info': true,
            'autoWidth': false,

        })
    })
</script>
@endpush

