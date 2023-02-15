<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Banner;

class BannerController extends Controller{
    //

    public function list(){
        echo "hello world";
        return view('banner/list');
    }

    public function register(){
        return view('banner/register');
    }

    public function save(Request $request){

        $show_errors = [];

        $this->language_id = config('app.language_id');

        $banner_image_url = $request->input('banner_image_url');

        $banner_url = $request->input('banner_url');

        $banner_date_avaiable = $request->input('banner_date_avaiable');

        $banner_description = $request->input('banner_description');

        $fileName = time().'.'.$request->banner_image_url->extension();  

        $path = 'public/uploads/'.$fileName;
     
        $request->banner_image_url->move(public_path('uploads'), $fileName);

        $dbBanner = new Banner();

        $dbBanner->banner_url = $banner_url;

        $dbBanner->banner_image_url = $path;

        $dbBanner->banner_description = $banner_description;

        $dbBanner->banner_date_avaiable = $banner_date_avaiable;

        $dbBanner->banner_date_added = date("Y-m-d");

        $dbBanner->save();


        var_dump($banner_image_url);

    }
}
