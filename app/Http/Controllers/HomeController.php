<?php namespace App\Http\Controllers;

use App;
use App\Ads;
use App\Categories;
use App\GalleryImage;
use App\Groups;
use App\Libraries\Utils;
use App\Pages;
use App\PostLikes;
use App\PostRatings;
use App\Posts;
use App\PostTags;
use App\SubCategories;
use App\Tags;
use App\Users;
use App\Countries;
use App\UsersGroups;
use Carbon\Carbon;
use DB;

use Feed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Input;
use Session;
use URL;
use Illuminate\Http\Request;
use GeoIP ;


class HomeController extends BaseController
{


    public function __construct()
    {



        parent::__construct();




    }

    public function install()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('migrate');

        Session::flash('success_msg', 'Successfully migrated new database columns , Login below to continue ');

        return redirect()->to('/login');
    }

    public function index(Request $request)
    {

        
        
        if(isset($_COOKIE['country']))
        {
            $countryName = $_COOKIE['country'];

            $recent_jobs = Posts::where('status', 1)->where('country',$countryName)->orderBy('id', 'desc')->paginate(10);
        }
        else
        {
            $recent_jobs = Posts::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        }
        
       
        

        $categories = Categories::get();

        $countries = Countries::get();

        $companies = Posts::groupby(['company'])->limit(20)->get();

        $states = Posts::groupby(['state'])->limit(20)->get();



        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();
        //$this->seoShuffle();
        //$keywords=shuffle($keywords);
        //dump($keywords);
        //$string="whateverwhateverwhatever";
        //dump($keywords);
        //$this->seoShuffle($keywords,$string);
        //dump($keywords);


        foreach ($categories as $category) {
            $subcategories = SubCategories::where('parent_id', $category->id)->get();

            $category->subcategory = $subcategories;
        }

       
       
        $this->data['recent_jobs'] = $recent_jobs;
        $this->data['categories'] = $categories;
        $this->data['countries'] = $countries;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;
        //dd($this->data['keywords']);
        $this->data['states'] = $states;

        /* Added from GEOIP*/
        $location=GeoIP::getLocation($request->ip());                             
        $this->data['country_geo'] = $location["country"];
        $this->data['state_geo'] = $location["state_name"];
        $this->data['city_geo'] = $location["city"];
        
        setcookie('country', $location["country"]);
        

        
        return view('index', $this->data);

    }

    function seoShuffle(&$items,$string) {
    //mt_srand(strlen($string));
    for ($i = count($items) - 1; $i > 0; $i--){
        $j = @mt_rand(0, $i);
        $tmp = $items[$i];
        $items[$i] = $items[$j];
        $items[$j] = $tmp;
    }
}

//$items = array('one','two','three','four','five','six');
//$string = 'whatever'; 


    public function jobDetails(Request $request, $id)
    {
        $Lat = 0;
        $Lon = 0;

        $location=GeoIP::getLocation($request->input('ip'));
        $this->data['country']=$location['country'];
        

     
        $jobs = Posts::where('slug', $id)->first();

        if (empty($jobs)) {
            return $this->throw404();
        }
        
        //count of views by users
        Posts::where('slug', $id)->update(['views' => $jobs->views + 1]);


        if(sizeof($jobs)>0) {

            // return related job of single job

               $relatedJobs = DB::table('posts')
                    ->where('country',$jobs->country)
                    ->orWhere('category_id',$jobs->category_id)
                    ->limit(3)->get();

        $this->data['jobs'] = $jobs;
        $this->data['relatedJobs'] = $relatedJobs;


        //dd($jobs->lang);
        $stopwords = file('stopword.txt');

        $this->data['tags'] = $this->stopWords($jobs->description,$stopwords);
        

        //for remove duplicate keywords in job 
        $this->data['tags']=array_unique($this->data['tags']);
         //dd($this->data['tags']);
        
        foreach ($this->data['tags'] as $ttag) {
            $checkTagsTable = DB::table('tags')->where('title',$ttag)->get();

            $checkKeywords = DB::table('keywords')->where('keyword',$ttag)->get();//!!!
            //dump( $checkKeywords);
            //dump($ttag);

            if($checkTagsTable==0)
            {
                $lastId = DB::table('tags')->insertGetId(array('title'=>$ttag,'slug'=>str_replace(' ','_',$ttag)));
                DB::table('post_tags')->insert(array('post_id'=>$jobs->id,'tag_id'=>$lastId));
            }

            if( empty($checkKeywords))
            {
                DB::table('keywords')->insert(array('keyword'=>$ttag));
                dump($ttag);
            }
          
          
        }



       // $disqus = new \Disqus('0fQcn8EFVrVL2CJeAFJTfBnM98nU9dk0jOrh7rdLdSa234oXbnWFJMVM7dq5SFBU');
        //---$secret_key = '0fQcn8EFVrVL2CJeAFJTfBnM98nU9dk0jOrh7rdLdSa234oXbnWFJMVM7dq5SFBU';

        // create new instance of Disqus API
        //---$disqus = new \Disqus($secret_key);

        // uncomment if you have trouble with secure connections
        //$disqus->setSecure(false);

        // NOTE: if you don't have posts in the table, you need to set $since to dummy date
        // else you need to fix the time format
       // $since = str_replace(' ', 'T', DB::table('comments')->max('date')); 

        $params = array(
           'forum'=>'newsviews',
           'limit'=>51,
           'order'=>'asc',
           'include'=>'approved',
           'related'=>'thread'
        );

        // get a list with all disqus comments since last comment in your local db
        /*$comments = $disqus->posts->list($params);
        $commentData = array();

        for($commentVar = 0; $commentVar < count($comments); $commentVar++)
        {
            $commentData[$commentVar]['message'] =  $comments[$commentVar]->message;
            $commentData[$commentVar]['author_username'] = $comments[$commentVar]->author->username;
            $commentData[$commentVar]['author_name'] = $comments[$commentVar]->author->name;
            $commentData[$commentVar]['author_avatar'] = $comments[$commentVar]->author->avatar->small->permalink;

        }

        $this->data['commentsData'] = $commentData;    */
                       
        Posts::where('id',$id)->increment('views',1);

//dd($this->data);
    return view('job_details', $this->data);
}
        else{
            return view('errors.404',$this->data);
        }
    }


    public function jobApply($id)
    {
        if (Auth::check()) {
            if (strlen(Auth::user()->resume) > 0) {

                $v = \Validator::make(['email' => Input::get('email'),
                    'name' => Input::get('name'),
                    'comment' => Input::get('comment'),
                    'file' => Auth::user()->resume],
                    ['name' => 'required', 'email' => 'required', 'comment' => 'required', 'file' => 'required']);

            } else {
                $v = \Validator::make(['email' => Input::get('email'),
                    'name' => Input::get('name'),
                    'comment' => Input::get('comment'),
                    'file' => Input::file('file')],
                    ['name' => 'required', 'email' => 'required', 'comment' => 'required', 'file' => 'required|mimes:doc,docx,pdf']);
            }
        } else {

            $v = \Validator::make(['email' => Input::get('email'),
                'name' => Input::get('name'),
                'comment' => Input::get('comment'),
                'file' => Input::file('file')],
                ['name' => 'required', 'email' => 'required', 'comment' => 'required', 'file' => 'required|mimes:doc,docx,pdf']);


        }


        if ($v->passes()) {

            $name = Input::get('name');
            $email = Input::get('email');
            $comment = Input::get('comment');
            $title = Input::get('title');

            if (Auth::check()) {
                if (strlen(Auth::user()->resume) > 0) {
                    $attachment_path = Auth::user()->resume;
                    $author_email = Users::where('id', $id)->first();

                    \Mail::send('apply', ['name' => $name, 'email' => $email, 'comment' => $comment], function ($message) use ($author_email, $attachment_path) {
                        $message->to($author_email->email)->attach($attachment_path)
                            ->subject('A new candidate applied for your job posting ');
                    });

                    DB::table('applicants')->insert(['title' => $title, 'name' => $name, 'email' => $email, 'resume' => $attachment_path,'author_id' => $id]);

                } else {
                    $file = Input::file('file');
                    $attachment_path = Utils::imageUpload($file, 'attachments');
                    $author_email = Users::where('id', $id)->first();
                    \Mail::send('apply', ['name' => $name, 'email' => $email, 'comment' => $comment, 'file' => $file], function ($message) use ($author_email, $attachment_path) {
                        $message->to($author_email->email)->attach($attachment_path)
                            ->subject('A new candidate applied for your job posting ');
                    });
                    DB::table('applicants')->insert(['title' => $title, 'name' => $name, 'email' => $email, 'resume' => $attachment_path,'author_id' => $id]);


                }
            } else {
                $file = Input::file('file');
                $attachment_path = Utils::imageUpload($file, 'attachments');
                $author_email = Users::where('id', $id)->first();
                \Mail::send('apply', ['name' => $name, 'email' => $email, 'comment' => $comment, 'file' => $file], function ($message) use ($author_email, $attachment_path) {
                    $message->to($author_email->email)->attach($attachment_path)
                        ->subject('A new candidate applied for your job posting ');
                });
                DB::table('applicants')->insert(['title' => $title, 'name' => $name, 'email' => $email, 'resume' => $attachment_path,'author_id' => $id]);

            }


            \Session::flash('success_msg', 'Successfully Applied.');
            return redirect()->back();
        } else {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back()->withInput();
        }

    }

    public function uploadResume($id)
    {

        $v = \Validator::make([
            'file' => Input::file('file')],
            ['file' => 'required|mimes:doc,docx,pdf']);


        if ($v->passes()) {
            $file = Input::file('file');

            $attachment_path = Utils::imageUpload($file, 'attachments');


            Users::where('id', $id)->update(['resume' => $attachment_path]);


            \Session::flash('success_msg', 'Successfully Uploaded.');
            return redirect()->back();
        } else {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back()->withInput();
        }

    }


    public function registerCustomer()
    {

        $v = \Validator::make(['email' => Input::get('email'),
            'name' => Input::get('name'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation')],
            ['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|confirmed|min:6']);

        if ($v->passes()) {

            $customer_group = DB::table('groups')->where('name', 'customer')->first();

            $hash = md5(strtolower(trim(Input::get('email'))));

            $confirmation_code = str_random(30);

            $user = new Users();
            $user->name = Input::get('name');
            $user->slug = Str::slug(Input::get('name'));
            $user->email = Input::get('email');
            $user->password = \Hash::make(Input::get('password'));
            $user->activation_code = $confirmation_code;
            $user->avatar = "http://www.gravatar.com/avatar/$hash";
            $user->save();
            $user_group = new UsersGroups();
            $user_group->user_id = $user->id;
            $user_group->group_id = $customer_group->id;
            $user_group->save();

            \Mail::send('verify', ['confirmation_code' => $confirmation_code], function ($message) {
                $message->to(Input::get('email'))
                    ->subject('Verify your email address');
            });

            \Session::flash('success_msg', 'Thanks for signing up! Please check your email.');
            return redirect()->back();
        } else {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back();
        }
    }

    public function confirm($confirmation_code)
    {
        if (!$confirmation_code) {
            throw new \Exception('invalid confirmation code');
        }

        $user = Users::where('activation_code', $confirmation_code)->first();

        if (!$user) {
            throw new \Exception('invalid confirmation code');
        }

        $user->activated = 1;
        $user->activation_code = null;
        $user->save();

        \Session::flash('success_msg', 'Successfully Registered');

        return redirect('/login');
    }

    public function jobList(Request $request)
    {

//dd(Input::get('title'));
$days=Input::get('days',0);


        if($days==0)
        {

            $jobs = Posts::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        }

        if($days==1)
        {

            $jobs = Posts::where('status', 1)->where('created_at','<',Carbon::now())->where('created_at','>',Carbon::now()->subDay() )->orderBy('created_at', 'desc')->paginate(10);

        }

        if($days==3)
        {

            $jobs = Posts::where('status', 1)->where('created_at','<',Carbon::now())->where('created_at','>',Carbon::now()->subDay(3) )->orderBy('created_at', 'desc')->paginate(10);

        }

        if($days==7)
        {

            $jobs = Posts::where('status', 1)->where('created_at','<',Carbon::now())->where('created_at','>',Carbon::now()->subDay(7) )->orderBy('created_at', 'desc')->paginate(10);

        }

        if($days==30)
        {

            $jobs = Posts::where('status', 1)->where('created_at','<',Carbon::now())->where('created_at','>',Carbon::now()->subDay(30) )->orderBy('id', 'desc')->paginate(10);

        }

  
        $country=Input::get('country');

        $q=Input::get('q');
        if(isset($country) and isset($q)){

            $jobs = Posts::where('status', 1)
                ->where('country', 'LIKE', '%' . $country . '%')
                ->where(function($query) use ($q)
                {
                    $query->where('title', 'LIKE', '%' . $q . '%')
                    ->orWhere('description', 'LIKE', '%' . $q . '%');
                })
           
                ->orderBy('id', 'desc')
                ->paginate(10);       
        }    

        if(!isset($country) and isset($q)){
            //dd($country);
            $jobs = Posts::where('status', 1)
                ->where(function($query) use ($q)
                {
                    $query->where('title', 'LIKE', '%' . $q . '%')
                    ->orWhere('description', 'LIKE', '%' . $q . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(10);       
        }    
//dd($jobs);
/*
        $jobs = Posts::where('status', 1)
            ->where(function($query1) use ($country)
            {
                $query1->where('country', 'LIKE', '%' . $country . '%')
                
            })
            ->where(function($query2) use ($q)
            {
                $query2->where('title', 'LIKE', '%' . $q . '%')
                ->orWhere('description', 'LIKE', '%' . $q . '%');
            })
           
            ->orderBy('id', 'desc')
            ->paginate(10);
            dd($jobs);
/*
DB::table('users')
    ->where('name', '=', 'John')
    ->orWhere(function($query)
    {
        $query->where('votes', '>', 100)
              ->where('title', '<>', 'Admin');
    })
    ->get();
*/


        $categories = Categories::get();

        $countries = Countries::get();

        $companies = Posts::groupby('company')->limit(20)->get();

        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();
        //dd(Input::get('days',0));
        foreach ($categories as $category) {
            $subcategories = SubCategories::where('parent_id', $category->id)->get();

            $category->subcategory = $subcategories;
        }
        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['countries'] = $countries;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;

        $location=GeoIP::getLocation($request->ip());                             
        $this->data['country_geo'] = $location["country"];
        $this->data['state_geo'] = $location["state_name"];
        $this->data['city_geo'] = $location["city"];

        return view('jobs', $this->data);

    }

    public function categoryFilter($id)
    {

     $cat_id=Categories::where('slug',$id)->first();

        $ids = SubCategories::where('parent_id', $cat_id->id)->lists('id');

        if (sizeof($ids) > 0)
            $jobs = Posts::whereIn('category_id', $ids)->where('status', 1)->orderBy('id', 'desc')->paginate(10);
        else
            $jobs = [];

        $categories = Categories::where('slug', $id)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();
        $companies = Posts::groupby('company')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['keywords'] = $keywords;
        $this->data['companies'] = $companies;

        $replaced=str_replace("-",' ',$id);


        return view('jobs', $this->data,['keyword'=>$replaced]);
    }

    public function companyFilter($id)
    {
        

        $company=str_replace("-",' ',$id);



        $jobs = Posts::where('company', $company)->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        //dd($jobs);

        $categories = Categories::where('id', $id)->get();

        $companies = Posts::groupby('company')->limit(20)->get();

        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;

        return view('jobs', $this->data ,['keyword'=>$company]);
    }

    public function keywordFilter($id)
    {
        $replaced=str_replace("-",' ',$id);
        //dd($id);

        $keyword = DB::table('keywords')->where('keyword', $replaced)->first();
        //dd($keyword);
        if(sizeof($keyword)==0)
        {
            return redirect()->to('404');

        }
        $jobs = Posts::where('title', 'LIKE', '%' . $keyword->keyword . '%')
        
        ->orWhere('description', 'LIKE', '%' . $keyword->keyword . '%')
        ->where('status', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        //dd($jobs);
        $categories = Categories::where('id', $id)->get();

        $companies = Posts::groupby('company')->limit(20)->get();

        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        //dd($jobs);
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;




        return view('jobs', $this->data ,['keyword'=>$replaced]);
    }

    public function subcategoryFilter($id)
    {
        $cat_id=SubCategories::where('slug',$id)->first();


        $jobs = Posts::where('category_id', $cat_id->id)->where('status', 1)->orderBy('id', 'desc')->paginate(10);

        $categories = Categories::where('id', $id)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();
        $companies = Posts::groupby('company')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;

        $replaced=str_replace("-",' ',$id);



        return view('jobs', $this->data,['keyword'=>$replaced]);
    }

    public function countryFilter($country_name)
    {

        $country=str_replace("-",' ',$country_name);


        $jobs = Posts::where('country', $country)->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        $categories = Categories::get();

        $companies = Posts::groupby('company')->limit(20)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;


        return view('jobs', $this->data ,['keyword'=>$country]);

    }

    public function stateFilter($id)
    {

        $state=str_replace("-",' ',$id);


        $jobs = Posts::where('state', $state)->where('status', 1)->orderBy('id', 'desc')->paginate(10);

        $categories = Categories::get();


        $companies = Posts::groupby('company')->limit(20)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;


        return view('jobs', $this->data,['keyword'=>$state]);
    }

    public function cityFilter($id)
    {
        $city=str_replace("-",' ',$id);


        $jobs = Posts::where('city', $city)->where('status', 1)->orderBy('id', 'desc')->paginate(10);

        $categories = Categories::get();


        $companies = Posts::groupby('company')->limit(20)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;


        return view('jobs', $this->data ,['keyword'=>$city]);
    }

    public function priceFilter($id)
    {
        if ($id == 1) {
            $jobs = Posts::whereBetween('salary', [0, 1000])->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        }
        if ($id == 2) {
            $jobs = Posts::whereBetween('salary', [1000, 5000])->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        }
        if ($id == 3) {
            $jobs = Posts::whereBetween('salary', [5000, 10000])->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        }
        if ($id == 4) {
            $jobs = Posts::whereBetween('salary', [10000, 20000])->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        }
        if ($id == 5) {
            $jobs = Posts::where('salary', '>', 20000)->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        }

        $categories = Categories::get();
        $companies = Posts::groupby('company')->limit(20)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();

        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;

        return view('jobs', $this->data ,['keyword'=>'Filter By Price']);
    }

    public function searchJobList()
    {

        $title = Input::get('title');
        $country = Input::get('country');
        $state = Input::get('state');
        $city = Input::get('city');
        $category = Input::get('category');

        



        $result = DB::table('keywords')->where('keyword', $title)->get();
        if (strlen($title) > 0) {
            if (sizeof($result) == 0) {
                DB::table('keywords')->insert(['keyword' => $title, 'count' => 1]);
            } else {
                $row = DB::table('keywords')->where('keyword', $title)->first();

                DB::table('keywords')->where('keyword', $title)->update(['count' => $row->count + 1]);
            }
        }

        $categories = Categories::get();


        $jobs = DB::table('posts')->orderBy('created_at', 'desc');

        if (strlen($title) > 0) {
            $jobs = $jobs->where('status', 1)->where('title', 'LIKE', '%' . $title . '%');
        }
        if (strlen($country) > 0 && $country != -1) {

            $jobs = $jobs->where('status', 1)->where('country', 'LIKE', '%' . $country . '%');
        }

        if (strlen($state) > 0 && $state != -1) {
            $jobs = $jobs->where('status', 1)->where('state', 'LIKE', '%' . $state . '%');
        }

        if (strlen($city) > 0 && $city != -1) {
            $jobs = $jobs->where('status', 1)->where('city', 'LIKE', '%' . $city . '%');
        }

        if (strlen($category) > 0 && $category != -1) {
            $jobs = $jobs->where('status', 1)->where('category', 'LIKE', '%' . $category . '%');
        }

        $jobs = $jobs->paginate(10);


        $companies = Posts::groupby('company')->limit(20)->get();
        $keywords = DB::table('keywords')->orderBy('count', 'desc')->limit(20)->get();
        $this->data['jobs'] = $jobs;
        $this->data['categories'] = $categories;
        $this->data['companies'] = $companies;
        $this->data['keywords'] = $keywords;
        $this->data['title'] = $title;
        $this->data['country'] = $country;
        $this->data['state'] = $state;
        $this->data['city'] = $city;
        $this->data['category'] = $category;





        return view('jobs', $this->data);
    }

    public function contact(request $request)
    {
        $v = \Validator::make(['email' => Input::get('email'),
            'name' => Input::get('name'),
            'subject' => Input::get('subject'),
            'message' => Input::get('message')],
            ['name' => 'required', 'email' => 'required|email', 'subject' => 'required', 'message' => 'required']);

        if ($v->passes()) {
            $email = Input::get('email');
            $subject = Input::get('subject');


            \Mail::send('emails.contact',
                array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'subject' => $request->get('subject'),
                    'user_message' => $request->get('message')
                ), function ($message)
                use ($email, $subject) {
                    $message->to(env('MAIL_FROM'))->subject($subject);
                });

            \Session::flash('success_msg', 'Thanks For Contacting us');
            return Redirect()->back();
        } else {
            Session::flash('error_msg', Utils::messages($v));
            return redirect()->back();
        }


    }

    public function getContact()
    {

        return view('contact', $this->data);


    }

    public function page($page_slug)
    {
        $page = Pages::where('slug', $page_slug)->first();

        if (empty($page)) {
            return $this->throw404();
        }

        $page->next = Pages::where("id", ">", $page->id)->first();
        $page->prev = Pages::where("id", "<", $page->id)->orderBy('created_at', 'desc')->first();
        $page->author = Users::where('id', $page->author_id)->first();

        $related_pages = Pages::where('id', '!=', $page->id)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->where('description', 'LIKE', '%' . $page->description . '%')->limit(6)->get();

        foreach ($related_pages as $p) {
            $p->author = Users::where('id', $p->author_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_ABOVE_PAGE] = Ads::where('position', Ads::TYPE_ABOVE_PAGE)->orderByRaw("RAND()")->first();
        $this->data['ads'][Ads::TYPE_BELOW_PAGE] = Ads::where('position', Ads::TYPE_BELOW_PAGE)->orderByRaw("RAND()")->first();
        $this->data['page'] = $page;
        $this->data['related_pages'] = $related_pages;

        return view('page', $this->data);
    }

    public function byAuthor($author_slug)
    {

        $author = Users::where('slug', $author_slug)->first();

        if (empty($author)) {
            return $this->throw404();
        }

        $group_id = UsersGroups::where('user_id', $author->id)->pluck('group_id');

        $author->group = Groups::where('id', $group_id)->first();

        $posts = Posts::where('author_id', $author->id)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->paginate(15);;

        foreach ($posts as $post) {
            $post->sub_category = SubCategories::where('id', $post->category_id)->first();
            $post->category = Categories::where('id', $post->sub_category->parent_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_BETWEEN_AUTHOR_INDEX] = Ads::where('position', Ads::TYPE_BETWEEN_AUTHOR_INDEX)->orderByRaw("RAND()")->first();
        $this->data['author'] = $author;
        $this->data['posts'] = $posts;

        return view('author', $this->data);
    }

    public function byCategory($category_slug)
    {


        $category = Categories::where('slug', $category_slug)->first();

        if (empty($category)) {
            return $this->throw404();
        }

        $sub_cat_ids = SubCategories::where('parent_id', $category->id)->lists('id');

        if (sizeof($sub_cat_ids) > 0) {
            $posts = Posts::whereIn('category_id', $sub_cat_ids)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->paginate(15);
        } else {
            $posts = [];
        }

        foreach ($posts as $post) {
            $post->sub_category = SubCategories::where('id', $post->category_id)->first();
            $post->category = Categories::where('id', $post->sub_category->parent_id)->first();
            $post->author = Users::where('id', $post->author_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_BETWEEN_CATEGORY_INDEX] = Ads::where('position', Ads::TYPE_BETWEEN_CATEGORY_INDEX)->orderByRaw("RAND()")->first();
        $this->data['posts'] = $posts;
        $this->data['category'] = $category;

        return view('category', $this->data);
    }

    public function bySearch()
    {

        $search_term = Input::get('search');

        $posts = Posts::where('title', 'LIKE', '%' . $search_term . '%')->where('description', 'LIKE', '%' . $search_term . '%')->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->orderBy('id', 'desc')->paginate(15);

        foreach ($posts as $post) {
            $post->sub_category = SubCategories::where('id', $post->category_id)->first();
            $post->category = Categories::where('id', $post->sub_category->parent_id)->first();
            $post->author = Users::where('id', $post->author_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_BETWEEN_SEARCH_INDEX] = Ads::where('position', Ads::TYPE_BETWEEN_SEARCH_INDEX)->orderByRaw("RAND()")->first();
        $this->data['posts'] = $posts;
        $this->data['search_term'] = $search_term;

        return view('search', $this->data);
    }

    public function byTag($tag_slug)
    {

        $tag = Tags::where('slug', $tag_slug)->first();

        if (empty($tag)) {
            return $this->throw404();
        }

        $post_ids = PostTags::where('tag_id', $tag->id)->lists('post_id');

        if (sizeof($post_ids) > 0) {
            $posts = Posts::whereIn('id', $post_ids)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->paginate(15);
        } else {
            $posts = [];
        }

        foreach ($posts as $post) {
            $post->sub_category = SubCategories::where('id', $post->category_id)->first();
            $post->category = Categories::where('id', $post->sub_category->parent_id)->first();
            $post->author = Users::where('id', $post->author_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_BETWEEN_TAG_INDEX] = Ads::where('position', Ads::TYPE_BETWEEN_TAG_INDEX)->orderByRaw("RAND()")->first();
        $this->data['posts'] = $posts;
        $this->data['tag'] = $tag;

        return view('tag', $this->data);
    }

    public function bySubCategory($category_slug, $sub_category_slug)
    {

        $sub_category = SubCategories::where('slug', $sub_category_slug)->first();

        if (empty($sub_category)) {
            return $this->throw404();
        }

        $category = Categories::where('id', $sub_category->parent_id)->first();

        if (empty($category)) {
            return $this->throw404();
        }

        $posts = Posts::where('category_id', $sub_category->id)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->paginate(15);

        foreach ($posts as $post) {
            $post->author = Users::where('id', $post->author_id)->first();
        }

        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();
        $this->data['ads'][Ads::TYPE_BETWEEN_SUBCATEGORY_INDEX] = Ads::where('position', Ads::TYPE_BETWEEN_SUBCATEGORY_INDEX)->orderByRaw("RAND()")->first();
        $this->data['posts'] = $posts;
        $this->data['category'] = $category;
        $this->data['sub_category'] = $sub_category;

        return view('sub_category', $this->data);
    }

    public function submitLike()
    {
        $post_id = Input::get('id');
        $type = Input::get('type');

        if ($post_id < 0) {
            Session::flash('error_msg', trans('messages.internal_server_error'));
            return redirect()->back();
        } else {

            $post_rating = PostLikes::where('email', Input::get('email'))->where('post_id', $post_id)->first();

            if ($type == 1 || $type == 0) {

                if (!empty($post_rating)) {
                    $post_rating->rating = $type;
                    $post_rating->approved = 1;
                    $post_rating->save();
                } else {
                    $post_rating = new PostLikes();
                    $post_rating->post_id = $post_id;
                    $post_rating->name = Input::get('name');
                    $post_rating->email = Input::get('email');
                    $post_rating->rating = $type;
                    $post_rating->approved = 1;
                    $post_rating->save();
                }

                Session::flash('success_msg', trans('messages.thanks_for_rating'));
                return redirect()->back();
            }
        }
    }

    public function submitRating()
    {
        $post_id = Input::get('id');

        if (!Input::has('star') || !Input::has('name') || !Input::has('email') || !Input::has('id')) {
            Session::flash('error_msg', trans('messages.all_field_required_to_submit_rating'));
            return redirect()->back();
        } else {

            $post_rating = PostRatings::where('email', Input::get('email'))->where('post_id', $post_id)->first();

            if (!empty($post_rating)) {
                $post_rating->rating = Input::get('star');
                $post_rating->approved = 1;
                $post_rating->save();
            } else {
                $post_rating = new PostRatings();
                $post_rating->post_id = $post_id;
                $post_rating->name = Input::get('name');
                $post_rating->email = Input::get('email');
                $post_rating->rating = Input::get('star');
                $post_rating->approved = 1;
                $post_rating->save();
            }

            Session::flash('success_msg', trans('messages.thanks_for_rating'));
            return redirect()->back();
        }
    }

    public function article($slug)
    {
        $this->data['ads'][Ads::TYPE_ABOVE_POST] = Ads::where('position', Ads::TYPE_ABOVE_POST)->orderByRaw("RAND()")->first();
        $this->data['ads'][Ads::TYPE_BELOW_POST] = Ads::where('position', Ads::TYPE_BELOW_POST)->orderByRaw("RAND()")->first();
        $this->data['ads'][Ads::TYPE_SIDEBAR] = Ads::where('position', Ads::TYPE_SIDEBAR)->get();

        $post = Posts::where('slug', $slug)->first();

        if (empty($post)) {
            return $this->throw404();
        }

        Posts::where('slug', $slug)->update(['views' => $post->views + 1]);

        $post->author = Users::where('id', $post->author_id)->first();
        $post->sub_category = SubCategories::where('id', $post->category_id)->first();
        $post->category = Categories::where('id', $post->sub_category->parent_id)->first();

        if ($post->rating_box == 1) {
            $all_ratings = PostRatings::orderBy('created_at', 'desc')->where('post_id', $post->id)->where('approved', 1)->lists('rating');

            if (sizeof($all_ratings) > 0) {

                $total = 0;

                foreach ($all_ratings as $rating) {
                    $total = $total + $rating;
                }

                $post->average_rating = (float)($total / sizeof($all_ratings));
                $post->rating_count = sizeof($all_ratings);

            } else {
                $post->average_rating = 0;
                $post->rating_count = 0;
            }
        }

        if ($post->rating_box == 2) {
            $ups = PostLikes::where('post_id', $post->id)->where('rating', 1)->count();
            $downs = PostLikes::where('post_id', $post->id)->where('rating', 0)->count();


            $post->ups = $ups;
            $post->downs = $downs;

        }

        if ($post->render_type == Posts::RENDER_TYPE_GALLERY) {
            $post->gallery = GalleryImage::where('post_id', $post->id)->get();
        }

        $tag_ids = PostTags::where('post_id', $post->id)->get();

        if (sizeof($tag_ids->lists('tag_id')) > 0)
            $post->tags = Tags::whereIn('id', $tag_ids->lists('tag_id'))->get();
        else
            $post->tags = [];

        foreach ($tag_ids as $tag) {
            PostTags::where('post_id', $post->id)->where('tag_id', $tag->id)->update(['views' => $tag->views + 1]);
        }

        foreach ($post->tags as $tag) {
            Tags::where('id', $tag->id)->update(['views' => $tag->views + 1]);
        }

        $post->next = Posts::where("id", ">", $post->id)->first();
        $post->prev = Posts::where("id", "<", $post->id)->orderBy('created_at', 'desc')->first();

        $related_posts = Posts::where('id', '!=', $post->id)->orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->where('description', 'LIKE', '%' . $post->description . '%')->whereIn('render_type', [Posts::RENDER_TYPE_IMAGE, Posts::RENDER_TYPE_VIDEO])->limit(6)->get();

        foreach ($related_posts as $p) {
            $p->author = Users::where('id', $p->author_id)->first();
            $p->sub_category = SubCategories::where('id', $p->category_id)->first();
            $p->category = Categories::where('id', $p->sub_category->parent_id)->first();
        }

        $this->data['post'] = $post;

        if ($post->type == Posts::TYPE_SOURCE)
            $this->data['source'] = App\Sources::where('id', $post->source_id)->first();

        $this->data['related_posts'] = $related_posts;

        return view('article', $this->data);
    }

    public function rss()
    {

        $settings_general = Utils::getSettings("general");
        $settings_seo = Utils::getSettings("seo");

        if ($settings_general->generate_rss_feeds != 1) {
            return $this->throw404();
        }

        $feed = Feed::feed('2.0', 'UTF-8');

        $feed->channel(array('title' => $settings_general->site_title, 'description' => $settings_seo->seo_description, 'link' => $settings_general->site_url));

        $posts = Posts::orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->get();

        foreach ($posts as $post) {
            $author = Users::where('id', $post->author_id)->first();

            if ($post->type == Posts::TYPE_SOURCE) {
                if ($settings_general->include_sources == 1) {
                    $feed->item(['title' => $post->title,
                            'description|cdata' => $post->description,
                            'link' => URL::to($post->slug),
                            'guid' => $post->id,
                            'author' => $author->name,
                            'media:content | cdata' => $post->featured_image,
                            'media:text' => $post->title
                        ]
                    );
                }
            } else {
                $feed->item(['title' => $post->title,
                        'description|cdata' => $post->description,
                        'link' => URL::to($post->slug),
                        'guid' => $post->id,
                        'author' => $author->name,
                        'media:content | cdata' => $post->featured_image,
                        'media:text' => $post->title
                    ]
                );
            }


        }

        return response($feed, 200, array('Content-Type' => 'text/xml'));
    }

    public function categoryRss($slug)
    {
        $settings_general = Utils::getSettings("general");
        $settings_seo = Utils::getSettings("seo");

        if ($settings_general->generate_rss_feeds != 1) {
            return $this->throw404();
        }

        $feed = Feed::feed('2.0', 'UTF-8');

        $feed->channel(array('title' => $settings_general->site_title, 'description' => $settings_seo->seo_description, 'link' => $settings_general->site_url));

        $category = Categories::where('slug', $slug)->first();

        $sub_ids = SubCategories::where('parent_id', $category->id)->lists('id');

        if (sizeof($sub_ids) > 0) {
            $posts = Posts::orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->whereIn('category_id', $sub_ids->toArray())->get();
        } else {
            $posts = [];
        }

        foreach ($posts as $post) {
            $author = Users::where('id', $post->author_id)->first();

            if ($post->type == Posts::TYPE_SOURCE) {
                if ($settings_general->include_sources == 1) {
                    $feed->item(['title' => $post->title,
                            'description|cdata' => $post->description,
                            'link' => URL::to($post->slug),
                            'guid' => $post->id,
                            'author' => $author->name,
                            'media:content | cdata' => $post->featured_image,
                            'media:text' => $post->title
                        ]
                    );
                }
            } else {
                $feed->item(['title' => $post->title,
                        'description|cdata' => $post->description,
                        'link' => URL::to($post->slug),
                        'guid' => $post->id,
                        'author' => $author->name,
                        'media:content | cdata' => $post->featured_image,
                        'media:text' => $post->title
                    ]
                );
            }


        }

        return response($feed, 200, array('Content-Type' => 'text/xml'));
    }

    public function subCategoryRss($category_slug, $subcategory_slug)
    {
        $settings_general = Utils::getSettings("general");
        $settings_seo = Utils::getSettings("seo");

        if ($settings_general->generate_rss_feeds != 1) {
            return $this->throw404();
        }

        $feed = Feed::feed('2.0', 'UTF-8');

        $feed->channel(array('title' => $settings_general->site_title, 'description' => $settings_seo->seo_description, 'link' => $settings_general->site_url));

        $subcategory = SubCategories::where('slug', $subcategory_slug)->first();

        if (!empty($subcategory)) {
            $posts = Posts::orderBy('created_at', 'desc')->where('status', Posts::STATUS_PUBLISHED)->where('category_id', $subcategory->id)->get();
        } else {
            $posts = [];
        }

        foreach ($posts as $post) {
            $author = Users::where('id', $post->author_id)->first();

            if ($post->type == Posts::TYPE_SOURCE) {
                if ($settings_general->include_sources == 1) {
                    $feed->item(['title' => $post->title,
                            'description|cdata' => $post->description,
                            'link' => URL::to($post->slug),
                            'guid' => $post->id,
                            'author' => $author->name,
                            'media:content | cdata' => $post->featured_image,
                            'media:text' => $post->title
                        ]
                    );
                }
            } else {
                $feed->item(['title' => $post->title,
                        'description|cdata' => $post->description,
                        'link' => URL::to($post->slug),
                        'guid' => $post->id,
                        'author' => $author->name,
                        'media:content | cdata' => $post->featured_image,
                        'media:text' => $post->title
                    ]
                );
            }


        }

        return response($feed, 200, array('Content-Type' => 'text/xml'));
    }

    public function sitemap()
    {
        $settings_general = Utils::getSettings("general");

        if ($settings_general->generate_sitemap == 1) {

            // create new sitemap object
            $sitemap = App::make("sitemap");

            // get all posts from db
            $posts = DB::table('posts')->orderBy('created_at', 'desc')->get();

            // add every post to the sitemap
            foreach ($posts as $post) {
                $sitemap->add(URL::to('/') . "/" . $post->slug, $post->updated_at, '1', 'weekly', null, $post->title);
            }

            $pages = DB::table('pages')->orderBy('created_at', 'desc')->get();

            $categories = DB::table('categories')->orderBy('created_at', 'desc')->get();

            // add every category to the sitemap
            foreach ($categories as $category) {

                $sub_categories = SubCategories::where('parent_id', $category->id)->get();

                $sitemap->add(URL::to('/') . "/category/" . $category->slug, $category->updated_at, '1', 'weekly', null, $category->title);

                foreach ($sub_categories as $sub_category) {
                    $sitemap->add(URL::to('/') . "/category/" . $category->slug . "/" . $sub_category->slug, $category->updated_at, '1', 'weekly', null, $category->title);
                }
            }

            return $sitemap->render('xml');
        }
    }


    // funcction for get keywords / tags
    function stopWords($text, $stopwords) {

            $keywords=array();
          // Remove line breaks and spaces from stopwords
            $stopwords = array_map(function($x){return trim(strtolower($x));}, $stopwords);


          // Replace all non-word chars with comma
            
          $pattern = '/[0-9\W]/u';
            //$pattern = '/[0-9^\p{L}]/';

          $text = preg_replace($pattern, ',', $text);

          // Create an array from $text
          $text_array = explode(",",$text);
          //dd($text_array);

          $text_array = array_map(function($x){return trim(strtolower($x));}, $text_array);
          
          foreach ($text_array as $term) {
           
            if (!in_array($term, $stopwords)) {
                $keywords[] = $term;
            }
          };          

          return array_filter($keywords);

        }

}
