@extends('layouts.master')

@section('extra_css')




    @if(strlen(Input::get('q'))>0)
    <title>{{Input::get('q')}} Jobs </title>

    <meta name="keywords" content="{{Input::get('q')}}">
    <meta name="description" content="{{Input::get('q')}} Jobs Available ">
    @endif

    @if(strlen(Input::get('country'))>0)
        <title> Jobs In {{Input::get('country')}} </title>

        <meta name="keywords" content="{{Input::get('country')}}">
        <meta name="description" content="{{Input::get('country')}} Jobs Available ">
    @endif

    @if(strlen(Input::get('state'))>0)
        <title> Jobs In {{Input::get('state')}} </title>
        <meta name="keywords" content="{{Input::get('state')}}">
        <meta name="description" content="{{Input::get('state')}} Jobs Available ">
    @endif

    @if(strlen(Input::get('city'))>0)
        <title> Jobs In {{Input::get('city')}} </title>
        <meta name="keywords" content="{{Input::get('city')}}">
        <meta name="description" content="{{Input::get('city')}} Jobs Available ">
    @endif

    @if((Input::get('days'))>0 )
        <title>Filter By Date </title>
        <meta name="keywords" content="days , hours">
        <meta name="description" content="Filter Jobs By Days">

    @endif

    @if(isset($keyword))
    @if(strlen($keyword)>0)
        <title> {{$keyword}} Jobs </title>

        <meta name="keywords" content="{{$keyword}}">
        <meta name="description" content="{{$keyword}} Jobs Available">

    @endif
    @endif

    @if(strlen(Input::get('q'))==0&&strlen(Input::get('country'))==0&&strlen(Input::get('state'))==0&&strlen(Input::get('city'))==0&&!isset($keyword))

        <title> All Jobs </title>
        <meta name="keywords" content="{{$settings_seo->seo_keywords}}">
        <meta name="description" content="{{$settings_seo->seo_description}}">

    @endif






@stop




@section('content')


    <div class="bg-color2">
        <div class="container">

            <!-- form search area-->
            <div class="container">
                <div class="row">


                    <div class="col-md-8" style="margin-top:30px">
                        @foreach($ads as $ad)

                        @if($ad->position=='above_page')
                        {!! $ad->code !!}
                        @endif

                        @endforeach
                                <!-- form search -->
                        @include('search_form')
                    </div>


                </div>


            </div><!-- end form search area-->
            <div class="row">
                <div class="col-md-9">


                    @if(strlen(Input::get('q'))>0)
                        <h1>{{Input::get('q')}} Jobs  Available</h1>

                    @endif

                    @if(strlen(Input::get('country'))>0)
                        <h1> Jobs In {{Input::get('country')}} Available  </h1>

                    @endif

                    @if(strlen(Input::get('state'))>0)
                        <h1> Jobs In {{Input::get('state')}} Available </h1>

                    @endif

                    @if(strlen(Input::get('city'))>0)
                        <h1> Jobs In {{Input::get('city')}} Available </h1>

                    @endif

                    @if((Input::get('days'))>0 )
                        <h1>Filter By Date Available  </h1>

                    @endif

                    @if(isset($keyword))
                        @if(strlen($keyword)>0)
                            <h1> {{$keyword}} Jobs Available</h1>


                        @endif
                    @endif

                    @if(strlen(Input::get('q'))==0&&strlen(Input::get('country'))==0&&strlen(Input::get('state'))==0&&strlen(Input::get('city'))==0&&!isset($keyword))

                        <h1> All Jobs Available </h1>

                        @endif

                    <!-- box listing -->
                    <div class="block-section-sm box-list-area">
                        <!-- desc top -->
                        @if(sizeof($featured_jobs)>0 || sizeof($featured_jobs_admin)>0)

                            <div class="row hidden-xs">
                                <div class="col-sm-6  ">
                                    <p><strong class="color-black">Featured Jobs</strong></p>
                                </div>

                            </div>

                            @endif

                                    <!-- end desc top -->
                            <div class="box-list">
                                @foreach($featured_jobs as $featured_job)
                                    <div class="item">
                                        <div class="row">
                                            @if(strlen($featured_job->featured_image)>0)
                                                <div class="col-md-1 hidden-sm hidden-xs">
                                                    <div class="img-item"><img src="{{$featured_job->featured_image}}"
                                                                               alt="">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-1 hidden-sm hidden-xs">
                                                    <div class="img-item"><img
                                                                src="/assets/theme/images/company-logo/1.jpg" alt="">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-11">

                                                <h3 class="no-margin-top"><a href="/{{$featured_job->slug}}"
                                                                             class="">{{$featured_job->title}} <i
                                                                class="fa fa-link color-white-mute font-1x"></i></a>
                                                </h3>

                                                @if(strlen($featured_job->company)>0&&strlen($featured_job->state)>0&&strlen($featured_job->city)>0&&strlen($featured_job->experience)>0)
                                                    <h5><span class="color-black">Company:<a
                                                                    href="/company/{{\Illuminate\Support\Str::slug($featured_job->company)}}">{{$featured_job->company}}</a></span>
                                                        - <span class="color-Black">State:<a
                                                                    href="/state/{{\Illuminate\Support\Str::slug($featured_job->state)}}">{{$featured_job->state}}</a></span>
                                                        - <span class="color-Black">City:<a
                                                                    href="/city/{{\Illuminate\Support\Str::slug($featured_job->city)}}">{{$featured_job->city}}</a></span>
                                                    </h5>
                                                    <p class="text-truncate ">Experience:{{$featured_job->experience}}
                                                        Years</p>
                                                @endif
                                                <div>
                                                    {{\Illuminate\Support\Str::limit(strip_tags($featured_job->description),265)}}
                                                    <br>
                                                    <span class="color-white-mute">{{$featured_job->created_at}}</span>
                                                    -
                                                    <a href="/{{$featured_job->slug}}"
                                                       class="btn btn-theme btn-xs btn-default">more ...</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end item list -->
                                @endforeach

                                    @foreach($featured_jobs_admin as $featured_job)
                                        <div class="item">
                                            <div class="row">
                                                @if(strlen($featured_job->featured_image)>0)
                                                    <div class="col-md-1 hidden-sm hidden-xs">
                                                        <div class="img-item"><img src="{{$featured_job->featured_image}}" alt="">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-1 hidden-sm hidden-xs">
                                                        <div class="img-item"><img
                                                                    src="/assets/theme/images/company-logo/1.jpg" alt=""></div>
                                                    </div>
                                                @endif
                                                <div class="col-md-11" >
                                                @if($featured_job->lang =='ar')  
                                                    <h3 class="no-margin-top" style="direction: rtl">
                                                @else    
                                                    <h3 class="no-margin-top">
                                                @endif    

                                                    <a href="/{{$featured_job->slug}}"

                                                                                 class="">{{$featured_job->title}} <i
                                                                    class="fa fa-link color-white-mute font-1x"></i></a></h3>

                                                    @if(strlen($featured_job->company)>0&&strlen($featured_job->state)>0&&strlen($featured_job->city)>0&&strlen($featured_job->experience)>0)
                                                        <h5><span class="color-black">Company:<a
                                                                        href="/company/{{\Illuminate\Support\Str::slug($featured_job->company)}}">{{$featured_job->company}}</a></span>
                                                            - <span class="color-Black">State:<a
                                                                        href="/state/{{\Illuminate\Support\Str::slug($featured_job->state)}}">{{$featured_job->state}}</a></span>
                                                            - <span class="color-Black">City:<a
                                                                        href="/city/{{\Illuminate\Support\Str::slug($featured_job->city)}}">{{$featured_job->city}}</a></span>
                                                        </h5>
                                                        <p class="text-truncate ">Experience:{{$featured_job->experience}}
                                                            Years</p>
                                                    @endif
                                                    @if($featured_job->lang =='ar')
                                                    <div style="direction: rtl">
                                                    @else
                                                    <div>
                                                    @endif
                                                        {{\Illuminate\Support\Str::limit(strip_tags($featured_job->description),265)}}
                                                        <br>
                                                        <span class="color-white-mute">{{$featured_job->created_at}}</span> -
                                                        <a href="/{{$featured_job->slug}}"
                                                           class="btn btn-theme btn-xs btn-default">more ...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end item list -->
                                    @endforeach

                            </div>


                            <!-- desc top -->
                            <div class="row hidden-xs">
                                <div class="col-sm-6  ">
                                    @if(Input::has('title')||Input::has('country')||Input::has('state')||Input::has('category'))
                                        <p><strong class="color-black">{{Input::get('title')}} @if(Input::has('state'))
                                                    jobs in {{Input::get('state')}} @endif</strong></p>
                                    @else
                                        <p><strong class="color-black">All jobs around the globe</strong></p>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-right">
                                        @if(sizeof($jobs)>0)
                                            Results found
                                        @else
                                            No Results found
                                        @endif
                                    </p>
                                </div>
                            </div><!-- end desc top -->


                            <!-- item list -->
                            <!-- item list -->
                            <div class="box-list">
                                @if(sizeof($jobs)==0)
                                    <h1>No results found</h1>

                                @else
                                    @foreach($jobs as $job)
                                        <div class="item">
                                            <div class="row">
                                                @if(strlen($job->featured_image)>0)
                                                    <div class="col-md-1 hidden-sm hidden-xs">
                                                        <div class="img-item"><img src="{{$job->featured_image}}"
                                                                                   alt=""></div>
                                                    </div>
                                                @else
                                                    <div class="col-md-1 hidden-sm hidden-xs">
                                                        <div class="img-item"><img
                                                                    src="/assets/theme/images/company-logo/1.jpg"
                                                                    alt=""></div>
                                                    </div>
                                                @endif
                                                <div class="col-md-11">



                                                    @if($job->lang =='ar')  
                                                    <h3 class="no-margin-top" style="direction: rtl">
                                                @else    
                                                    <h3 class="no-margin-top">
                                                @endif




                                                    <a href="/{{$job->slug}}"
                                                                                 class="">{{$job->title}} <i
                                                                    class="fa fa-link color-white-mute font-1x"></i></a>
                                                    </h3>

                                                    @if(strlen($job->company)>0&&strlen($job->state)>0&&strlen($job->city)>0&&strlen($job->experience)>0)
                                                        <h5><span class="color-black">Company:<a
                                                                        href="/company/{{\Illuminate\Support\Str::slug($job->company)}}">{{$job->company}}</a></span>
                                                            - <span class="color-Black">State:<a
                                                                        href="/state/{{\Illuminate\Support\Str::slug($job->state)}}">{{$job->state}}</a></span>
                                                            - <span class="color-Black">City:<a
                                                                        href="/city/{{\Illuminate\Support\Str::slug($job->city)}}">{{$job->city}}</a></span>
                                                        </h5>
                                                        <p class="text-truncate ">Experience:{{$job->experience}}
                                                            Years</p>
                                                    @endif
                                                    @if($job->lang =='ar')
                                                    <div style="direction: rtl">
                                                    @else
                                                    <div>
                                                    @endif







                                                        {{\Illuminate\Support\Str::limit(strip_tags($job->description),265)}}
                                                        <br>
                                                        <span class="color-white-mute">{{$job->created_at}}</span> -
                                                        <a href="/{{$job->slug}}"
                                                           class="btn btn-theme btn-xs btn-default">more ...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end item list -->
                                    @endforeach

                                @endif

                            </div>




                            <!-- pagination -->
                            <nav>
                                @if(sizeof($jobs)>0)
                                    <ul class="pagination pagination-theme  no-margin pull-right">
                                        {!! $jobs->render() !!}
                                    </ul>
                                @endif
                            </nav><!-- pagination -->

                    </div><!-- end box listing -->

                    @foreach($ads as $ad)

                        @if($ad->position=='below_page')
                            {!! $ad->code !!}
                        @endif

                    @endforeach


                </div>

                <div class="col-md-3">
                    <div class="block-section-sm side-right">
                        <div class="row">
                            <div class="col-xs-6">
                                <p><strong>Filter by: </strong></p>
                            </div>

                        </div>

                        <div class="result-filter">

                            <h5 class="font-bold  margin-b-20"><a href="#s_collapse_2" data-toggle="collapse">Filter By Date
                                    <i class="fa ic-arrow-toogle fa-angle-right pull-right"></i></a></h5>

                            <div class="collapse in" id="s_collapse_2">
                                <div class="list-area">
                                    <ul class="list-unstyled ">
                                        <li><a href="/jobs?days=1">Last 24 Hours</a></li>
                                        <li><a href="/jobs?days=3">Last 3 Days</a></li>
                                        <li><a href="/jobs?days=7">Last 7 Days</a></li>
                                        <li><a href="/jobs?days=30">Last 30 Days</a></li>


                                    </ul>

                                </div>
                            </div>

                            <h5 class="no-margin-top font-bold margin-b-20 "><a href="#s_collapse_1"
                                                                                data-toggle="collapse">Salary Estimate
                                    <i class="fa ic-arrow-toogle fa-angle-right pull-right"></i> </a></h5>

                            <div class="collapse in" id="s_collapse_1">
                                <div class="list-area">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="/price_filter/1">0$-1000$</a>({{count(\App\Posts::whereBetween('salary', [0, 1000])->get())}}
                                            )
                                        </li>
                                        <li>
                                            <a href="/price_filter/2">1000$-5000$</a>({{count(\App\Posts::whereBetween('salary', [1000, 5000])->get())}}
                                            )
                                        </li>
                                        <li>
                                            <a href="/price_filter/3">5000$-10000$</a>({{count(\App\Posts::whereBetween('salary', [5000, 10000])->get())}}
                                            )
                                        </li>
                                        <li>
                                            <a href="/price_filter/4">10000$-20000$</a>
                                            ({{count(\App\Posts::whereBetween('salary', [10000, 20000])->get())}})
                                        </li>
                                        <li>
                                            <a href="/price_filter/5">20000$ +</a>
                                            ({{count(\App\Posts::where('salary','>',20000)->get())}})
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <h5 class="font-bold  margin-b-20"><a href="#s_collapse_2" data-toggle="collapse">Keywords
                                    <i class="fa ic-arrow-toogle fa-angle-right pull-right"></i></a></h5>

                            <div class="collapse in" id="s_collapse_2">
                                <div class="list-area">
                                    <ul class="list-unstyled ">
                                        @foreach($keywords as $keyword)
                                            <li>
                                                <a href="/keyword/{{\Illuminate\Support\Str::slug($keyword->keyword)}}">{{$keyword->keyword}}</a>
                                                ({{count(\App\Posts::where('title', 'LIKE', '%' . $keyword->keyword . '%')->get())}}
                                                )
                                            </li>
                                        @endforeach

                                    </ul>

                                </div>
                            </div>


                            <h5 class="font-bold  margin-b-20"><a href="#s_collapse_3" data-toggle="collapse">Company <i
                                            class="fa ic-arrow-toogle fa-angle-right pull-right"></i></a></h5>

                            <div class="collapse in" id="s_collapse_3">
                                <div class="list-area">
                                    <ul class="list-unstyled ">
                                        @foreach($companies as $company)
                                            @if(strlen($company->company)>0)
                                                <li>
                                                    <a href="/company/{{\Illuminate\Support\Str::slug($company->company)}}">{{$company->company}}</a>
                                                    ({{count(\App\Posts::where('company',$company->company )->get())}})
                                                </li>
                                            @endif
                                        @endforeach


                                    </ul>

                                </div>
                            </div>


                            <h5 class="font-bold  margin-b-20"><a href="#s_collapse_4" data-toggle="collapse"
                                                                  class="collapsed">Location <i
                                            class="fa ic-arrow-toogle fa-angle-right pull-right"></i> </a></h5>

                            <div class="collapse in" id='s_collapse_4'>
                                <div class="list-area">
                                    <ul class="list-unstyled ">
                                        @foreach($states as $state)
                                            @if(strlen($state->state)>0)



                                                <ul class="list-group" data-toggle="collapse" data-target="#main_cat_{{$state->id}}">
                                                    <li class="list-group-item"><i class="fa fa-caret-down"></i><a href="/state/{{\Illuminate\Support\Str::slug($state->state)}}"> {{$state->state}}</a>
                                                        ({{count(\App\Posts::where('state',$state->state )->get())}})


                                                        <ul style="position: absolute;width: 100%;margin-left: -15px;background:#F5F3F3;z-index: 1000;border:1px solid #cecece"
                                                            id="main_cat_{{$state->id}}" class="collapse out">

                                                            @foreach(\App\Posts::groupby(['city'])->where('state',$state->state)->limit(20)->get() as $city)


                                                                <li>
                                                                    <a href="/city/{{\Illuminate\Support\Str::slug($city->city)}}"> {{$city->city}} </a>
                                                                    ({{count(\App\Posts::where('city',$city->city )->get())}})

                                                                </li>

                                                            @endforeach

                                                        </ul>



                                                    </li>

                                                </ul>

                                            @endif
                                        @endforeach

                                    </ul>

                                </div>
                            </div>

                            @foreach($ads as $ad)

                                @if($ad->position==\App\Ads::TYPE_SIDEBAR)
                                    {!! $ad->code !!}
                                @endif

                            @endforeach


                        </div>
                        
    
                    </div>


                </div>
            </div>
        </div>
    </div>






@endsection