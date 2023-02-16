<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Banner;

class BannerController extends Controller{
    //

    public function list(){
        $this->language_id = config('app.language_id');

        $banners = DB::table('banner')
        ->orderBy('banner.banner_id')
        ->get();


        return view('banner/list',['banners'=>$banners]);
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


        $request->validate([
            'banner_date_avaiable' => ['date']
        ]);

        

        $fileName = time().'.'.$request->banner_image_url->extension();  

        $path = 'uploads/'.$fileName;
     
        $request->banner_image_url->move(public_path('uploads'), $fileName);

        $dbBanner = new Banner();

        $dbBanner->banner_url = $banner_url;

        $dbBanner->banner_image_url = $path;

        $dbBanner->banner_description = $banner_description;

        $dbBanner->banner_date_avaiable = $banner_date_avaiable;

        $dbBanner->banner_date_added = date("Y-m-d");

        $dbBanner->save();


        return redirect()->action(
            [BannerController::class, 'list']
        );

    }

    public function delete(Request $request){
        $banner_id = $request->banner_id;

        $banner = DB::table('banner')
        ->where('banner.banner_id',$banner_id)
        ->first();


        $filepath = $banner->banner_image_url;
        ## Check file exists
        if (File::exists($filepath)) {

            ## Delete file
            File::delete($filepath);
        }

        Banner::where('banner_id',$banner_id)->delete();       

        return redirect()->action(
            [BannerController::class, 'list']
        );
    }
}
