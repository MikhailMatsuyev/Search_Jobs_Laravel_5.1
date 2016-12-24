@extends('layouts.master')


@section('extra_css')
    <title>{{$settings_general->site_title}}</title>

    <meta name="keywords" content="{{$settings_seo->seo_keywords}}">
    <meta name="description" content="{{$settings_seo->seo_description}}">



@stop

@section('content')

    <div class="bg-color2">
        <div class="container">
            <div class="row">
                <div class="col-md-9">

                    @foreach($ads as $ad)

                    @if($ad->position==\App\Ads::TYPE_INDEX_HEADER)
                    {!! $ad->code !!}
                    @endif

                    @endforeach
                            <!-- box listing -->
                    <div class="block-section-sm box-list-area">
                   
                        <!-- desc top -->
                        @if(sizeof($featured_jobs)>0 || sizeof($featured_jobs_admin)>0)

                        <div class="row hidden-xs">
                            <div class="col-sm-6  ">
                                <h2><strong class="color-black">Featured Jobs</strong></h2>
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
                                                <div class="img-item"><img src="{{$featured_job->featured_image}}" alt="">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-1 hidden-sm hidden-xs">
                                                <div class="img-item"><img
                                                            src="./assets/theme/images/company-logo/1.jpg" alt=""></div>
                                            </div>
                                        @endif
                                        <div class="col-md-11">

                                            <h3 class="no-margin-top"><a href="{{$featured_job->slug}}"
                                                                         class="">{{$featured_job->title}} <i
                                                            class="fa fa-link color-white-mute font-1x"></i></a></h3>

                                            @if(strlen($featured_job->company)>0&&strlen($featured_job->state)>0&&strlen($featured_job->city)>0&&strlen($featured_job->experience)>0)
                                                <h5>
                                                    <span class="color-black">Company:
                                                            <a href="/company/{{\Illuminate\Support\Str::slug($featured_job->company)}}">
                                                                
                                                                    {{$featured_job->company}}
                                                                
                                                            </a>
                                                    </span>
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
                                                <span class="color-white-mute">{{$featured_job->created_at}}</span> -
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
                                                                src="./assets/theme/images/company-logo/1.jpg" alt=""></div>
                                                </div>
                                            @endif
                                            <div class="col-md-11">


                                            @if($featured_job->lang =='ar')    
                                                <h3 class="no-margin-top" style="direction: rtl">
                                                                    
                                                                @else 
                                                                    <h3 class="no-margin-top">
                                                                @endif  
                                                


                                                <a href="{{$featured_job->slug}}"
                                                                             class="">

                                                    
                                                                    {{$featured_job->title}}
                                                                                                       

                                                     <i
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
                                                    <div >
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
                                <h2><strong class="color-black">Recent Jobs</strong></h2>
                            </div>

                        </div>
                        <!-- end desc top -->

                        <!-- item list -->
                        <div class="box-list">
                            @foreach($recent_jobs as $recent_job)
                                <div class="item">
                                    <div class="row">
                                        @if(strlen($recent_job->featured_image)>0)
                                            <div class="col-md-1 hidden-sm hidden-xs">
                                                <div class="img-item"><img src="{{$recent_job->featured_image}}" alt="">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-1 hidden-sm hidden-xs">
                                                <div class="img-item"><img
                                                            src="./assets/theme/images/company-logo/1.jpg" alt=""></div>
                                            </div>
                                        @endif
                                        <div class="col-md-11">

                                            <h3 class="no-margin-top"><a href="/{{$recent_job->slug}}"
                                                                         class="">{{$recent_job->title}} <i
                                                            class="fa fa-link color-white-mute font-1x"></i></a></h3>

                                            @if(strlen($recent_job->company)>0&&strlen($recent_job->state)>0&&strlen($recent_job->city)>0&&strlen($recent_job->experience)>0)
                                                <h5><span class="color-black">Company:<a
                                                                href="/company/{{\Illuminate\Support\Str::slug($recent_job->company)}}">{{$recent_job->company}}</a></span>
                                                    - <span class="color-Black">State:<a
                                                                href="/state/{{\Illuminate\Support\Str::slug($recent_job->state)}}">{{$recent_job->state}}</a></span>
                                                    - <span class="color-Black">City:<a
                                                                href="/city/{{\Illuminate\Support\Str::slug($recent_job->city)}}">{{$recent_job->city}}</a></span>
                                                </h5>
                                                <p class="text-truncate ">Experience:{{$recent_job->experience}}
                                                    Years</p>
                                            @endif
                                            <div>
                                                {{\Illuminate\Support\Str::limit(strip_tags($recent_job->description),265)}}
                                                <br>
                                                <span class="color-white-mute">{{$recent_job->created_at}}</span> -
                                                <a href="/{{$recent_job->slug}}"
                                                   class="btn btn-theme btn-xs btn-default">more ...</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end item list -->
                            @endforeach

                        </div>

                        @foreach($ads as $ad)

                        @if($ad->position=='index_footer')
                        {!! $ad->code !!}
                        @endif

                        @endforeach


                                <!-- pagination -->
                        <nav>
                            <ul class="pagination pagination-theme  no-margin pull-right">
                                {!! $recent_jobs->render() !!}
                            </ul>
                        </nav>
                        <!-- pagination -->

                    </div>
                    <!-- end box listing -->



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
    <section id="categories">
        <div class="container">
            <div class="row">
                <div class="page-header text-center col-sm-12 col-lg-12">
                    <h2><i class="fa fa-th-large"></i> Categories</h2>

                    <p>Search multiple job sites at once. One search to find all job postings at Jobs Aggregator.</p>
                </div>
            </div>
            <div class="row multi-columns-row">
                @foreach($categories as $category)
                    <div class="col-xs-6 col-sm-4 col-lg-3">

                        <ul class="list-group" data-toggle="collapse" data-target="#main_cat_{{$category->id}}">
                            <li class="list-group-item"><i class="fa fa-caret-down"></i><a
                                        href="/category/{{$category->slug}}"> {{$category->title}}</a>
                                @if(sizeof($category->subcategory)>0)
                                    <ul style="position: absolute;width: 100%;margin-left: -15px;background:#F5F3F3;z-index: 1000;border:1px solid #cecece"
                                        id="main_cat_{{$category->id}}" class="collapse out">
                                        @foreach($category->subcategory as $subcategory)
                                            <li>
                                                <a href="/subcategory/{{$subcategory->slug}}"> {{$subcategory->title}} </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif


                            </li>

                        </ul>

                    </div>
                @endforeach


            </div>

        </div>
        <!-- / CONTAINER-->
    </section>

    <section id="locations">
        <div class="container">
            <div class="row">
                <div class="page-header text-center col-sm-12 col-lg-12">
                    <h2><i class="fa fa-map-marker"></i> Locations</h2>

                    <p>Remember to "think local" when you want to find a job in a specific location. Your job search
                        should focus on local job search resources</p>
                </div>
            </div>

            <div class="row multi-columns-row">
                @foreach($countries as $country)
                    <div class="col-xs-6 col-sm-4 col-lg-3">

                        <ul class="list-group" data-toggle="collapse" data-target="#main_cat_{{$country->id}}">
                            <li class="list-group-item"><a
                                        href="/country/{{\Illuminate\Support\Str::slug($country->name)}}"> {{$country->name}}</a>

                            </li>

                        </ul>

                    </div>
                @endforeach

            </div>


        </div>
    </section>

@endsection