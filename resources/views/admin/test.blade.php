<?php
/**
 * Created by PhpStorm.
 * User: Sohel Rana
 * Date: 4/22/2019
 * Time: 10:57 PM
 */
?>






    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add New Video
            </h1>
        </section>

        <section class="maincontent">

            <div class="col-md-12" style="margin-top:2rem;">
                <div class="box box-primary">
                    <div class="box-body" style="margin-top:2rem;">
                        <form action="{{route('searchByTags')}}" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-sm-2">
                                    <label for="vendor_name" class="control-label">Video Url: <span
                                                style="color:red;">*</span> </label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter Youtube Video Url"
                                           name="tags" required>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-success pull-right" type="submit">Get Video Info</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


        <!-- /.content -->
    </div>





