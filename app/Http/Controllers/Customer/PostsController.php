<?php

namespace App\Http\Controllers\Customer;

use App\Categories;
use App\Http\Controllers\Controller;
use App\Libraries\Utils;
use App\Posts;
use App\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Input;
use Session;
use Hash;
use DB;
class PostsController extends Controller
{

    public function jobPost()
    {
        $admins = Utils::getUsersInGroup(Users::TYPE_ADMIN);

        return view('job_post', ['categories' => Categories::all(), 'admins' => $admins],$this->data);
    }

    public function listJobs(){
        $jobs = Posts::where('author_id', \Auth::id())->paginate(4);
        $this->data['jobs'] = $jobs;
        return view('account', $this->data);
    }

    public function changePassword()
    {
        return view('change_password', $this->data);
    }

    public function getApplicants()
    {

        $applicants=DB::table('applicants')->where('author_id',Auth::User()->id)->paginate(10);

        $this->data['applicants']=$applicants;
        return view('applicants', $this->data);
    }

    public function updatePassword()
    {
        $v = \Validator::make(['password' => Input::get('password'),
            'old_password' => Input::get('old_password'),
            'password_confirmation' => Input::get('password_confirmation'),


        ], ['password' => 'required|min:6|confirmed', 'old_password' => 'required', 'password_confirmation' => 'required']);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back()->withInput(Input::all());
        }


        $old_password = Input::get('old_password');

        if (\Auth::validate(['password'=>$old_password,'email'=>\Auth::user()->email]))
        {
           Users::where('id', \Auth::id())->update(['password'=>\Hash::make(Input::get('password'))]);
            Session::flash('success_msg', trans('passwords.reset'));
            return redirect()->back();


        }
        else
        {
            Session::flash('error_msg', trans('passwords.password_old'));
return redirect()->back();
        }
    }

    public function stripe($id , Users $user)
    {
       $token=Input::get('stripeToken');
        $days=Input::get('days');

        $start=Carbon::now();
        $end=Carbon::now()->addDay($days);

        Posts::where('id',$id)->update(['featured_starts_at'=>$start,'featured_ends_at'=>$end]);

        $user->charge((env('PER_DAY_CHARGE'))*$days, [
            'source' => $token
        ]);

        return redirect()->back();


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

        ], ['title' => 'required', 'description' => 'required','file' => 'required|image', 'company' => 'required', 'country' => 'required', 'state' => 'required','city' => 'required', 'category_id' => 'required', 'category' => 'required', 'sub_category' => 'required', 'salary' => 'required', 'experience' => 'required', 'status' => 'required']);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back()->withInput(Input::all());
        }

        $post_item = new Posts();
        $post_item->title = Input::get('title');
        $post_item->author_id = \Auth::id();
        $post_item->description = Input::get('description');
        $post_item->company = Input::get('company');
        $post_item->slug = Str::slug(Input::get('title'))."-".Carbon::now()->timestamp;
        $post_item->country = Str::slug(Input::get('country'));
        $post_item->state = Str::slug(Input::get('state'));
        $post_item->city = Str::slug(Input::get('city'));
        $post_item->category_id = Input::get('sub_category');
        $post_item->category = Str::slug(Input::get('category'));
        $post_item->subcategory = Str::slug(Input::get('sub_category'));
        $post_item->salary = Str::slug(Input::get('salary'));
        $post_item->experience = Str::slug(Input::get('experience'));
        $post_item->views = 0;
        $post_item->status = Input::get('status');
        $post_item->featured_image = Utils::imageUpload(Input::file('featured_image'), 'images');
        $post_item->save();


        Session::flash('success_msg', trans('messages.post_created_success'));
        return redirect()->back();

    }
}