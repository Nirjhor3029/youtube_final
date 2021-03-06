<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Tag;
use App\TagVideo;
use App\UserLog;
use App\VdoCategory;
use App\VdoSubCategory;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{

    public function getPath()
    {
        $pattern = "/.com/";
        $server_name = $_SERVER['SERVER_NAME'];
        //echo "Server Name:".$server_name;

        $path = public_path();

        if (preg_match($pattern, $server_name)) {

            //$path = str_replace("ayojok_base/public", "public_html", $path);
        }
        //echo "<br> $path";
        return $path;
    }

    public function saveUserLOg($user, $action)
    {
        $userLog = new UserLog();

        $userLog->user_name = $user;
        $userLog->Action = $action;

        $userLog->save();
    }

    /*Video Basic Crud*/
    public function videos()
    {
        $videos = Video::paginate(10);

        $categories = VdoCategory::all();
        $sub_categories = VdoSubCategory::all();
        $tags = Tag::all();
        $admin_users = Admin::all();

        //return $sub_categories;

        return view('admin.videos')
            ->with('videos', $videos)
            ->with('categories', $categories)
            ->with('sub_categories', $sub_categories)
            ->with('tags', $tags)
            ->with('admin_users', $admin_users)
            ->with('flt_all', 1)
            ->with('flt_cat', 0)
            ->with('flt_sub_cat', 0)
            ->with('flt_tag', 0)
            ->with('flt_user', 0);
    }


    public function addVideo()
    {

        return view('admin.add_video');
    }

    public function getVideoInfo(Request $request)
    {

        $videoUrl = $request->video_url;

        //echo $videoUrl;
        $videoId = explode('=', $videoUrl);
        $videoId = $videoId[1];
        //print_r($videoId);

        //exit;

        $check_vdo_exist = Video::where('video_id',$videoId)->count();
       if ($check_vdo_exist > 0){
           return Redirect::back()->with('msg','this video already added');
       }


        $str = file_get_contents('https://www.youtube.com/oembed?url=' . $videoUrl . '&format=json');

        //return $str;
        $videoInfo = \GuzzleHttp\json_decode($str);

        $tags = Tag::all();
        $categories = VdoCategory::all();
        $sub_categories = VdoSubCategory::all();

        return view('admin.add_video')
            ->with('videoId', $videoId)
            ->with('videoUrl', $videoUrl)
            ->with('videoInfo', $videoInfo)
            ->with('categories', $categories)
            ->with('sub_categories', $sub_categories)
            ->with('tags', $tags);

        //print_r($str) ;
        //$thumbnail_url = $str->$thumbnail_url;
        //$author_url = $str->author_url;
        //return $str->thumbnail_width;

    }


    public function getVideoList(Request $request)
    {

        $flt_all = 0;
        $flt_cat = 0;
        $flt_sub_cat = 0;
        $flt_tag = 0;
        $flt_user = 0;

        $videos = Video::all();

        $categories = VdoCategory::all();
        $sub_categories = VdoSubCategory::all();
        $tags = Tag::all();
        $admin_users = Admin::all();

        //return $sub_categories;


        if (isset($request->category)) {
            if (isset($request->sub_category)) {
                if (isset($request->tag)) {


                } elseif (isset($request->user)) {
                    /*category & sub-category & User*/

                    $flt_cat = $request->category;
                    $flt_sub_cat = $request->sub_category;
                    $flt_user = $request->user;

                    $videos = Video::where('category_id', $request->category)
                        ->where('sub_category_id', $request->sub_category)
                        ->where('user_id', $request->user)
                        ->get();
                } else {
                    /*category & sub-category*/

                    $flt_cat = $request->category;
                    $flt_sub_cat = $request->sub_category;
                    $videos = Video::where('category_id', $request->category)
                        ->where('sub_category_id', $request->sub_category)
                        ->get();
                }
            } else if (isset($request->tag)) {


            } elseif (isset($request->user)) {

                $flt_cat = $request->category;
                $flt_user = $request->user;

                $videos = Video::where('category_id', $request->category)
                    ->where('user_id', $request->user)
                    ->get();
            } else {
                /*Only Category set*/
                $flt_cat = $request->category;
                $videos = Video::where('category_id', $request->category)->get();
            }
        } else if (isset($request->sub_category)) {
            //echo "category -> not set";
            if (isset($request->tag)) {

            } elseif (isset($request->user)) {

                $flt_sub_cat = $request->sub_category;
                $flt_user = $request->user;
                $videos = Video::where('sub_category_id', $request->sub_category)
                    ->where('user_id', $request->user)
                    ->get();
            } else {
                /*Only Sub-Category set*/
                $flt_sub_cat = $request->sub_category;
                $videos = Video::where('sub_category_id', $request->sub_category)->get();
            }
        } else if (isset($request->tag)) {
            //echo "category & Sub-category -> not set";
            if (isset($request->user)) {

            } else {
                /*Only Tag set*/
                // $videos = Video::where('sub_category_id',$request->sub_category)->get();
            }
        } else if (isset($request->user)) {
            //echo "category & Sub-category & tag -> not set";
            $flt_user = $request->user;
            $videos = Video::where('user_id', $request->user)->get();

        } else {
            //$videos = Video::all();
            return Redirect::to('admin/videos');
        }

        //return $videos;


        return view('admin.videos')
            ->with('videos', $videos)
            ->with('categories', $categories)
            ->with('sub_categories', $sub_categories)
            ->with('tags', $tags)
            ->with('admin_users', $admin_users)
            ->with('flt_all', $flt_all)
            ->with('flt_cat', $flt_cat)
            ->with('flt_sub_cat', $flt_sub_cat)
            ->with('flt_tag', $flt_tag)
            ->with('flt_user', $flt_user);


    }
    public function featured_videos()
    {

        $flt_all = 0;
        $flt_cat = 0;
        $flt_sub_cat = 0;
        $flt_tag = 0;
        $flt_user = 0;

        $videos = Video::where('feature',1)->get();

        $categories = VdoCategory::all();
        $sub_categories = VdoSubCategory::all();
        $tags = Tag::all();
        $admin_users = Admin::all();

        //return $sub_categories;




        //return $videos;


        return view('admin.videos')
            ->with('videos', $videos)
            ->with('categories', $categories)
            ->with('sub_categories', $sub_categories)
            ->with('tags', $tags)
            ->with('admin_users', $admin_users)
            ->with('flt_all', $flt_all)
            ->with('flt_cat', $flt_cat)
            ->with('flt_sub_cat', $flt_sub_cat)
            ->with('flt_tag', $flt_tag)
            ->with('flt_user', $flt_user);


    }


    public function addVideoSubmit(Request $request)
    {
        if(isset($request->save_tag)){
            Session::put('tags',$request->tags);
            echo "session save";
        }else{
            Session::put('tags',null);
        }

        if(isset($request->save_tag)){
            Session::put('tags',$request->tags);
            echo "session save";
        }else{
            Session::put('tags',null);
        }


        print_r($request->tags);



        return $request->tags;

        $video = new Video();
        $video->video_id = $request->video_id;
        $video->category_id = $request->category;
        $video->sub_category_id = $request->sub_category;
        $video->video_url = $request->video_url;
        $video->video_author_url = $request->author_url;
        $video->video_author_name = $request->author_name;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->thumbnail_url = $request->thumbnail_url;
        $video->video_length = $request->video_length;

        if (isset($request->feature)) {
            $video->feature = 1;
        } else {
            $video->feature = 0;

        }

        $video->user_id = Auth::user()->id;


        /*If Thumbnail image override */
        if ($request->hasFile('profile_image')) {
            $path = $this->getPath();
            $destinationPath = $path . '/img/video_images/';
            $image = $request->file('profile_image');
            $input['imagename'] = date('d_m_y_his') . '_' . $image->getClientOriginalName(); //. $image->getClientOriginalExtension();
            //echo $input['imagename'];
            if ($image->move($destinationPath, $input['imagename'])) {
                $fileurl = 'img\video_images\\' . $input['imagename'];
                //echo $fileurl;
                //vendors::where('id', $add->id)->update(['profile_img' => $fileurl]);

                $video->thumbnail_url = 'http://youtubeapp.ovie.winexsoft.com/public/' . str_replace("\\", "/", $fileurl);
            } else {
                echo "Error";
            }
        }
        /*End If Thumbnail image override */


        $video->save();


        /*new tag Collections*/
        if(isset($request->newTags))
        {
            $newTags = $request->newTags;
            $new_tags = explode(',', $newTags);

            //print_r($new_tags) ;
            $tag_ids = array();
            $i = 0;
            foreach ($new_tags as $new_tag) {
                $tag = new Tag();
                $tag->title = $new_tag;
                $tag->save();

                $tag_ids[$i] = $tag->id;

                $i++;
            }

            //print_r($tag_ids);


            /*New Tag Add to videos*/
            foreach ($tag_ids as $tag_id) {

                $tag_video = new TagVideo();
                $tag_video->video_id = $video->id;
                $tag_video->tag_id = $tag_id;
                $tag_video->save();

            }

        }

        if(isset($request->tags)){
            foreach ($request->tags as $tag) {

                //$check = TagVideo::find($tag)->count();
                /*if($check > 0){*/
                    $tag_video = new TagVideo();
                    $tag_video->video_id = $video->id;
                    $tag_video->tag_id = $tag;
                    $tag_video->save();
                /*}*/

            }
        }


        $this->saveUserLOg(Auth::user()->name, "Add New Video || Video ID ($video->id)");


        return Redirect::to('admin/videos');

    }

    public function deleteVideo($id)
    {
        $vdo = Video::find($id);

        $tag_videos = TagVideo::where('video_id',$id)->get();
        foreach($tag_videos as $data){
            $data->delete();
        }

        //return $tag_videos;


        //return $vdo;
        //exit;

        $this->saveUserLOg(Auth::user()->name, "Delete Video || Video ID ($vdo->id)");


        $vdo->delete();
        return Redirect::to('admin/videos');
    }

    public function editVideo($id)
    {
        $vdo = Video::find($id);

        //return $vdo;
        //$vdo_category->delete();
        //return view('admin.edit_vdo')->with('$vdo', $vdo);

        $tags = Tag::all();
        $categories = VdoCategory::all();
        $sub_categories = VdoSubCategory::all();

        return view('admin.edit_vdo')
            ->with('videoId', $vdo->video_id)
            ->with('videoUrl', $vdo->video_url)
            ->with('videoInfo', $vdo)
            ->with('categories', $categories)
            ->with('sub_categories', $sub_categories)
            ->with('tags', $tags);

    }

    public function editVideoSubmit(Request $request, $id)
    {
        //return $request;




        $video = Video::find($id);

        $video->video_id = $request->video_id;
        $video->category_id = $request->category;
        $video->sub_category_id = $request->sub_category;
        $video->video_url = $request->video_url;
        $video->video_author_url = $request->author_url;
        $video->video_author_name = $request->author_name;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->thumbnail_url = $request->thumbnail_url;
        $video->video_length = $request->video_length;

        if (isset($request->feature)) {
            $video->feature = 1;
        } else {
            $video->feature = 0;

        }

        $video->user_id = Auth::user()->id;


        /*If Thumbnail image override */
        if ($request->hasFile('profile_image')) {
            $path = $this->getPath();
            $destinationPath = $path . '/img/video_images/';
            $image = $request->file('profile_image');
            $input['imagename'] = date('d_m_y_his') . '_' . $image->getClientOriginalName(); //. $image->getClientOriginalExtension();
            //echo $input['imagename'];
            if ($image->move($destinationPath, $input['imagename'])) {
                $fileurl = 'img\video_images\\' . $input['imagename'];
                //echo $fileurl;
                //vendors::where('id', $add->id)->update(['profile_img' => $fileurl]);

                $video->thumbnail_url = 'http://youtubeapp.ovie.winexsoft.com/public/' . str_replace("\\", "/", $fileurl);
            } else {
                echo "Error";
            }
        }
        /*End If Thumbnail image override */


        $video->save();


        /*new tag Collections*/
        if(isset($request->newTags)) {
            $newTags = $request->newTags;
            $new_tags = explode(',', $newTags);

            //print_r($new_tags) ;
            $tag_ids = array();
            $i = 0;

            /*Add new tag*/
            foreach ($new_tags as $new_tag) {
                $tag = new Tag();
                $tag->title = $new_tag;
                $tag->save();

                $tag_ids[$i] = $tag->id;

                $i++;
            }

            //print_r($tag_ids);

            /*New Tags Add to videos*/
            foreach ($tag_ids as $tag_id) {

                $tag_video = new TagVideo();
                $tag_video->video_id = $video->id;
                $tag_video->tag_id = $tag_id;
                $tag_video->save();

            }
        }

        if(isset($request->tags)){
            foreach ($request->tags as $tag) {
                $tag_video = TagVideo::where('video_id',$video->id)->where('tag_id',$tag)->first();

                if(isset($tag_video))
                {
                    //echo $tag_video->id;
                    $tag_video->delete();
                }

            }

            //exit;

            foreach ($request->tags as $tag) {

               /* $check = TagVideo::where('tag_id',$tag)->count();
                if($check <= 0){*/
                    $tag_video = new TagVideo();
                    $tag_video->video_id = $video->id;
                    $tag_video->tag_id = $tag;
                    $tag_video->save();
                }

            /*}*/
        }




        //echo $id;

        $this->saveUserLOg(Auth::user()->name, "Edit Video || Video ID ($video->id)");


        return Redirect::back()->with('success',"Video Information updated Successfully.");
    }

    public function checkFeature(Request $request){
        //return $request;

        echo $status = $request->status;
        $add =  Video::find($request->id)->update(['feature'=> $request->status]);
        echo "Updated";
    }




    public function selectSubCategory($id){

        $category = VdoCategory::find($id);
        $subCategories = VdoSubCategory::where('VdoCategory_id',$id)->get();

        echo "<option value=".null.">Select Any Sub Category</option>";

        foreach($subCategories as $subCategory)
        {
            echo "<option value=".$subCategory->id.">$subCategory->title ($category->title) </option>";
        }

    }




    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
