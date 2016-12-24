<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use App\Countries;
use App\GalleryImage;
use App\Http\Controllers\Controller;
use App\Libraries\Utils;
use App\Posts;
use App\PostTags;
use App\Sources;
use App\SubCategories;
use App\Tags;
use App\Users;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Input;
use Session;

class PostsController extends Controller
{

    function __construct()
    {
        $this->middleware('has_permission:posts.add', ['only' => ['create', 'store']]);
        $this->middleware('has_permission:posts.edit', ['only' => ['edit', 'update']]);
        $this->middleware('has_permission:posts.view', ['only' => ['all']]);
        $this->middleware('has_permission:posts.delete', ['only' => ['delete']]);
    }

    public function create()
    {
        $admins = Utils::getUsersInGroup(Users::TYPE_ADMIN);

        return view('admin.posts.create', ['categories' => Categories::all(), 'admins' => $admins]);
    }

    public function jobPost()
    {
        $admins = Utils::getUsersInGroup(Users::TYPE_ADMIN);

        return view('job_post', ['categories' => Categories::all(), 'admins' => $admins]);
    }

    public function store()
    {

        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        $v = \Validator::make(['title' => Input::get('title'),
            'description' => Input::get('description'),
            'company' => Input::get('company'),
            'country' => Input::get('country'),
            'state' => Input::get('state'),
            'city' => Input::get('city'),
            'category_id' => Input::get('category_id'),
            'category' => Input::get('category'),
            'sub_category' => Input::get('sub_category'),
            'salary' => Input::get('salary'),
            'file' => Input::file('featured_image'),
            'experience' => Input::get('experience'),
            'status' => Input::get('status'),

        ], ['title' => 'required', 'description' => 'required','file' => 'required|image','company' => 'required','country' => 'required','state' => 'required','city' => 'required', 'category_id' => 'required','category' => 'required','sub_category' => 'required','salary' => 'required','experience' => 'required','status' => 'required']);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back()->withInput(Input::all());
        }

        $post_item = new Posts();
        $post_item->title = Input::get('title');
        $post_item->description = Input::get('description');
        $post_item->author_id = \Auth::id();
        $post_item->company = Input::get('company');
        $post_item->slug = Str::slug(Input::get('title'))."-".Carbon::now()->timestamp;
        $post_item->country = Input::get('country');
        $post_item->state = Input::get('state');
        $post_item->city = Input::get('city');
        $post_item->category_id = Input::get('sub_category');
        $post_item->category = Str::slug(Input::get('category'));
        $post_item->subcategory = Str::slug(Input::get('sub_category'));
        $post_item->salary = Str::slug(Input::get('salary'));
        $post_item->experience = Str::slug(Input::get('experience'));
        $post_item->views = 0;
        $post_item->featured = Input::get('featured');
        $post_item->status = Input::get('status');
        $post_item->featured_image = Utils::imageUpload(Input::file('featured_image'), 'images');
        $post_item->save();



        Session::flash('success_msg', trans('messages.post_created_success'));
        return redirect()->back();

    }

    public function edit($id)
    {

        if (!is_null($id) && sizeof(Posts::where('id', $id)->get()) > 0) {

            $post = Posts::where('id', $id)->first();

            $post->category = SubCategories::where('id', $post->category_id)->first();
            $post->parent_category = Categories::where('id', $post->category->parent_id)->first();

            $countries=Countries::all();


            $post->gallery = GalleryImage::where('post_id', $post->id)->get();

            $post_tags = PostTags::where('post_id', $post->id)->lists('tag_id');

            if (sizeof($post_tags) > 0) {
                $post->tags = Tags::whereIn('id', $post_tags)->lists('title')->toArray();
            } else {
                $post->tags = [];
            }

            if ($post->type == Posts::TYPE_SOURCE)
                $post->source = Sources::where('id', $post->source_id)->first();

            $admins = Utils::getUsersInGroup(Users::TYPE_ADMIN);

            return view('admin.posts.edit', ['post' => $post, 'categories' => Categories::all(),'countries' => $countries, 'sub_categories' => SubCategories::where('parent_id', $post->parent_category->id)->get(), 'admins' => $admins]);

        } else {
            Session::flash('error_msg', trans('messages.post_not_found'));
            return redirect()->to('/admin/posts/all');
        }

    }

    public function update()
    {

        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        if (Input::has('id') && sizeof(Posts::where('id', Input::get('id'))->get()) > 0) {


            $v = \Validator::make(['title' => Input::get('title'),
                'description' => Input::get('description'),
                'company' => Input::get('company'),
                'country' => Input::get('country'),
                'state' => Input::get('state'),
                'city' => Input::get('city'),
                'category' => Input::get('category'),
                'sub_category' => Input::get('sub_category'),
                'salary' => Input::get('salary'),
                'file' => Input::file('featured_image'),
                'experience' => Input::get('experience'),
                'status' => Input::get('status'),

            ], ['title' => 'required', 'description' => 'required', 'file' => 'required|image','company' => 'required', 'country' => 'required', 'state' => 'required','city' => 'required', 'category' => 'required', 'sub_category' => 'required', 'salary' => 'required', 'experience' => 'required', 'status' => 'required']);

            if ($v->fails()) {
                Session::flash('error_msg', Utils::messages($v));
                return redirect()->back()->withInput(Input::all());
            }


            $post_item = Posts::where('id', Input::get('id'))->first();
            $post_item->title = Input::get('title');
            $post_item->description = Input::get('description');
            $post_item->company = Input::get('company');
            $post_item->slug = Str::slug(Input::get('title'));
            $post_item->country = Input::get('country');
            $post_item->state = Input::get('state');
            $post_item->city = Input::get('city');
            $post_item->category_id = Input::get('sub_category');
            $post_item->category = Str::slug(Input::get('category'));
            $post_item->subcategory = Str::slug(Input::get('sub_category'));
            $post_item->salary = Str::slug(Input::get('salary'));
            $post_item->experience = Str::slug(Input::get('experience'));
            $post_item->views = 0;
            $post_item->featured = Input::get('featured');
            $post_item->status = Input::get('status');
            if (Input::hasFile('featured_image')){
                $post_item->featured_image = Utils::imageUpload(Input::file('featured_image'), 'images');
        }
            $post_item->save();
            

            Session::flash('success_msg', trans('messages.post_updated_success'));
            return redirect()->to('/admin/posts/all');

        } else {
            Session::flash('error_msg', trans('messages.post_not_found'));
            return redirect()->to('/admin/posts/all');
        }

    }

    public function all()
    {

        $posts = Posts::all();

        foreach ($posts as $post) {

            $post->category = SubCategories::where('id', $post->category_id)->first();

            if ($post->type == Posts::TYPE_SOURCE) {
                $post->source = Sources::where('id', $post->source_id)->first();
            }
        }

        return view('admin.posts.all', ['posts' => $posts]);
    }

    public function delete($id)
    {
        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        if (!is_null($id) && sizeof(Posts::where('id', $id)->get()) > 0) {

            Posts::where('id', $id)->delete();

            Session::flash('success_msg', trans('messages.post_deleted_success'));
            return redirect()->to('/admin/posts/all');

        } else {
            Session::flash('error_msg', trans('messages.post_not_found'));
            return redirect()->to('/admin/posts/all');
        }
    }

}