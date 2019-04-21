<?php
/**
 * Created by PhpStorm.
 * User: Sohel Rana
 * Date: 3/17/2019
 * Time: 12:25 AM
 */

?>


@extends('layouts.admin')

@push('css')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css'
      integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>

    img {
        width: 50px;
        height: 60px;
    }
</style>
@endpush

@section('content')
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Videos
            </h1>
        </section>

        <section class="maincontent">

            <div class="col-md-12" style="margin-top:2rem;">

                <div class="box box-danger">

                    <div class="box-body table-responsive">

                        <div class="box-body" style="margin-top:2rem;">
                            <form action="{{route('getVideoList')}}" method="post" class="form-horizontal"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <select class="form-control" id="" name="category">
                                            <option value="">--Select Category--</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="" name="sub_category">
                                            <option value="">--Select Sub-Category--</option>
                                            @foreach($sub_categories as $sub_category)
                                                <option value="{{$sub_category->id}}">{{$sub_category->title}}
                                                    ( {{$sub_category->vdoCategory->title}} )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="" name="tag" disabled>
                                            <option value="">--Select Tag--</option>
                                            @foreach($tags as $tag)
                                                <option value="{{$tag->id}}">{{$tag->title}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="" name="user">
                                            <option value="">--Select User--</option>
                                            @foreach($admin_users as $admin_user)
                                                <option value="{{$admin_user->id}}">{{$admin_user->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div>
                                    <center>
                                        <button class="btn btn-info {{--pull-right--}}" type="submit">Get Video List
                                        </button>
                                    </center>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>


            <div class="col-md-12" style="margin-top:2rem;">

                <div class="box box-danger">

                    <div class="box-body table-responsive">
                        <a href="{{route('addVideo')}}" class="btn btn-primary">Add New Video</a>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <table class="table table-bordered">
                                    <thead>
                                    Filtered By:
                                    <tr>
                                        <th style="text-align: center">All</th>
                                        <th style="text-align: center">Category</th>
                                        <th style="text-align: center">Sub-Category</th>
                                        <th style="text-align: center">Tag</th>
                                        <th style="text-align: center">User</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="text-align: center">
                                        <td>
                                            @if(!$flt_cat and !$flt_sub_cat and !$flt_tag and !$flt_user)
                                                <span class="glyphicon" style='font-size:24px;color:green'>&#xe084;</span>
                                            @else
                                                <i class='fas fa-times-circle' style='font-size:24px;color:red'></i>
                                            @endif                                        </td>
                                        <td>
                                            @if($flt_cat)
                                                <span class="glyphicon" style='font-size:24px;color:green'>&#xe084;</span>
                                            @else
                                                <i class='fas fa-times-circle' style='font-size:24px;color:red'></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($flt_sub_cat)
                                                <span class="glyphicon" style='font-size:24px;color:green'>&#xe084;</span>
                                            @else
                                                <i class='fas fa-times-circle' style='font-size:24px;color:red'></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($flt_tag)
                                                <span class="glyphicon" style='font-size:24px;color:green'>&#xe084;</span>
                                            @else
                                                <i class='fas fa-times-circle' style='font-size:24px;color:red'></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($flt_user)
                                                <span class="glyphicon" style='font-size:24px;color:green'>&#xe084;</span>
                                            @else
                                                <i class='fas fa-times-circle' style='font-size:24px;color:red'></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td>{{"all"}}</td>
                                        <td>
                                            <?php
                                                $category = \App\VdoCategory::find($flt_cat);
                                                if(isset($category)){
                                                    $title = $category->title;
                                                }else{
                                                    $title = "N/A";
                                                }
                                            ?>
                                            {{$title}}
                                        </td>
                                        <td>
                                            <?php
                                            $category = \App\VdoSubCategory::find($flt_sub_cat);
                                            if(isset($category)){
                                                $title = $category->title."(".$category->vdoCategory->title.")";
                                                }else{
                                                $title = "N/A";
                                            }
                                            ?>
                                            {{$title}}
                                        </td>
                                        <td>
                                            <?php
                                            $category = \App\Tag::find($flt_tag);
                                            if(isset($category)){
                                                $title = $category->title;
                                                }else{
                                                $title = "N/A";
                                            }
                                            ?>
                                            {{$title}}
                                        </td>
                                        <td>
                                            <?php
                                            $category = \App\Admin::find($flt_user);
                                            if(isset($category)){
                                                $title = $category->name;
                                                }else{
                                                $title = "N/A";
                                            }
                                            ?>
                                            {{$title}}
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <center>
                            <h4>Total : {{$videos->count()}}</h4>
                            @if(isset($videos->links))
                                {{$videos->links()}}
                            @endif
                        </center>
                        <table id="table" class="table table-bordered">

                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID</th>

                                <th>Video Info</th>
                                <th>Category + Tag Info</th>
                                <th>Video Author Info</th>


                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            ?>
                            @foreach($videos as $video)
                                <?php
                                $i++;
                                ?>
                                <tr>
                                    <td>
                                        {{$i."."}}
                                    <br>
                                        Featured:
                                        <center>
                                            <input type="checkbox" name="check" class="checkbox" data-listid ="{{$video->id}}" {{ $video->feature ? 'checked' : '' }}>
                                        </center>

                                    </td>
                                    <td>{{$video->id}}</td>

                                    <td>
                                        @if(preg_match("/img/", $video->thumbnail_url) == 1)
                                            <a href="{{asset($video->thumbnail_url)}}" target="_blank"><img
                                                        src="{{asset($video->thumbnail_url)}}"
                                                        style="height: 60px;width: 80px"></a>
                                        @else
                                            <a href="{{$video->thumbnail_url}}" target="_blank"><img
                                                        src="{{$video->thumbnail_url}}"
                                                        style="height: 100px;width: 160px"></a>
                                        @endif

                                        <br>
                                        <strong>Video Title:</strong> {{$video->title}}


                                    </td>
                                    <td>
                                        <strong>Category: </strong>
                                        <?php
                                        $category = \App\VdoCategory::find($video->category_id);
                                        //return $category;
                                        if (isset($category)) {
                                            $categoryTitle = $category->title;
                                        } else {
                                            $categoryTitle = "N/A";
                                        }
                                        ?>
                                        {{$categoryTitle}}
                                        <br>
                                        <?php
                                        $tags = "";
                                        foreach ($video->tags as $tag) {
                                            $tags = $tags . "," . $tag->title;
                                        }
                                        ?>

                                        <strong>Sub-Category: </strong>
                                        <?php
                                        $sub_category = \App\VdoSubCategory::find($video->sub_category_id);
                                        //return $category;
                                        if (isset($sub_category)) {
                                            $sub_categoryTitle = $sub_category->title;
                                        } else {
                                            $sub_categoryTitle = "N/A";
                                        }
                                        ?>
                                        {{$sub_categoryTitle}}
                                        <br>
                                        <strong>Tags: </strong> {{$tags}}
                                    </td>


                                    <td>
                                        <strong>Author: </strong> <a
                                                href="{{$video->video_author_url}}">{{$video->video_author_name}}</a>

                                        <br>
                                        <strong>Video Id:</strong> <a
                                                href="{{$video->video_url}}">{{$video->video_id}}</a>

                                        <br>
                                        <strong>Video Length:</strong> {{$video->video_length}}
                                    </td>


                                    <td colspan="2">
                                        {{--<i class="material-icons" style="font-size:36px">delete</i>--}}
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <a href="{{route('deleteVideo',$video->id)}}"><i class="fa fa-remove"
                                                                                                 style="font-size:30px;color:red"></i></a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="{{route('editVideo',$video->id)}}"><i class="fa fa-edit"
                                                                                               style="font-size:30px;color:green"></i></a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    </div>

                    <center>
                        @if(isset($videos->links))
                            {{$videos->links()}}
                        @endif
                    </center>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>

        </section>
    </div>

@endsection

@push('scripts')


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.checkbox').on('change',function (){
        var taskId = $(this).attr("data-listid"); // gets task ID of clicked checkbox
        //var state = $(this).is(':checked'); // gets if checkbox is checked or not
        var state = $(this).is(':checked') ? 1 : 0;
        alert(taskId);
        $.ajax({
            data: {
                id: taskId,
                status: state,
            },
            url: 'video/checkFeature/',
            type: 'POST',
            dataType: 'json'
        });
    });
</script>
@endpush
