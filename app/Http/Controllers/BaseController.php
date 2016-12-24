<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Pages;
use App\PostRatings;
use App\Posts;
use App\PostTags;
use App\SubCategories;
use App\Tags;
use App\Users;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as VendorBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Libraries\Utils;
use App\Ads;
use Carbon\Carbon;

class BaseController extends VendorBaseController
{

    use DispatchesJobs, ValidatesRequests;

    public $data = [];
    protected $ads;

    public function __construct(){

        $this->ads = Ads::get();
        \View::share('ads', $this->ads);

        $states = Posts::groupby(['state'])->limit(20)->get();

        $featured_jobs=Posts::where('featured_starts_at','<',Carbon::now())->where('featured_ends_at','>',Carbon::now())->limit(5)->orderByRaw("RAND()")->get();
        $featured_jobs_admin=Posts::where('featured',1)->limit(10)->orderByRaw("RAND()")->get();

        $this->data['states']=$states;
        $this->data['settings_custom_css'] = Utils::getSettings("custom_css");
        $this->data['settings_custom_js'] = Utils::getSettings("custom_js");
        $this->data['settings_social'] = Utils::getSettings("social");
        $this->data['settings_comments'] = Utils::getSettings("comments");
        $this->data['settings_seo'] = Utils::getSettings("seo");
        $this->data['settings_general'] = Utils::getSettings("general");
        $this->data['global_cats'] = Categories::all();
        $this->data['featured_jobs'] = $featured_jobs;
        $this->data['featured_jobs_admin'] = $featured_jobs_admin;
        $this->data['global_pages'] = Pages::where('status',Posts::STATUS_PUBLISHED)->get();

        foreach($this->data['global_pages'] as $page){
            $page->author = Users::where('id',$page->author_id)->first();
        }

        foreach($this->data['global_cats'] as $cat){
            $cat->sub_categories = SubCategories::where('parent_id',$cat->id)->get();

            $cat->post_count = Posts::whereIn('category_id',$cat->sub_categories->lists('id')->toArray())->count();

            if(sizeof($cat->sub_categories) > 0){
                foreach($cat->sub_categories as $sub_cat){
                    $sub_cat->mega_menu_posts = Posts::where('show_in_mega_menu',1)->where('render_type','!=',Posts::RENDER_TYPE_TEXT)->where('category_id',$sub_cat->id)->limit(4)->get();

                    if(sizeof($sub_cat->mega_menu_posts) > 0){
                        foreach($sub_cat->mega_menu_posts as $post){
                            if($post->rating_box == 1){
                                $all_ratings = PostRatings::orderBy('created_at','desc')->where('post_id',$post->id)->where('approved',1)->lists('rating');

                                if (sizeof($all_ratings) > 0) {

                                    $total = 0;

                                    foreach ($all_ratings as $rating) {
                                        $total = $total + $rating;
                                    }

                                    $post->average_rating = (float)($total / sizeof($all_ratings));

                                } else {
                                    $post->average_rating = 0;
                                }
                            }
                        }
                    }

                }
            }

        }

        $tag_ids = PostTags::orderBy('views', 'desc')->limit(10)->lists('tag_id');

        if (sizeof($tag_ids) > 0) {
            $this->data['popular_tags'] = Tags::whereIn('id', $tag_ids)->orderBy('views', 'desc')->get();
        } else {
            $this->data['popular_tags'] = [];
        }

        $this->data['review_posts'] = Posts::orderBy('created_at', 'desc')->orderBy('views', 'desc')->where('render_type','!=',Posts::RENDER_TYPE_TEXT)->where('rating_box', 1)->where('status', Posts::STATUS_PUBLISHED)->limit(20)->get();

        foreach ($this->data['review_posts'] as $post) {

            $post->author = Users::where('id', $post->author_id)->first();
            $post->sub_category = SubCategories::where('id', $post->category_id)->first();
            $post->category = Categories::where('id', $post->sub_category->parent_id)->first();

            $all_ratings = PostRatings::orderBy('created_at', 'desc')->where('post_id', $post->id)->where('approved', 1)->lists('rating');

            if (sizeof($all_ratings) > 0) {

                $total = 0;

                foreach ($all_ratings as $rating) {
                    $total = $total + $rating;
                }

                $post->average_rating = (float)($total / sizeof($all_ratings));

            } else {
                $post->average_rating = 0;
            }

        }

    }

    public function throw404(){
        return redirect()->to('404');
    }

    public function show403(){
        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        return response(view('errors.403',$this->data));
    }

    public function show404(){
        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        return response(view('errors.404',$this->data),404);
    }

    public function show500(){
        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        return response(view('errors.500',$this->data),500);
    }

    public function show503(){
        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        return response(view('errors.503',$this->data),503);
    }
}
