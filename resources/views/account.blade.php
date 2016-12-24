@extends('layouts.master')

@section('extra_css')

    <title>Account</title>


    <meta name="description" content="Account">




@stop


@section('content')

    <div class="bg-color1">
        <div class="container">
            <div class="col-md-3 col-sm-3">

                <div class="block-section text-center ">
                    <img src="{{Auth::user()->avatar}}" class="img-rounded" alt="">
                    <div class="white-space-20"></div>
                    <h4>{{Auth::user()->name}}</h4>
                    <div class="white-space-20"></div>
                    <ul class="list-unstyled">
                        <li><a href="/customer"> My Account</a></li>
                        <li><a href="/customer/change_password"> Change Password</a></li>
                        <li><a href="/customer/applicants"> Applicants</a></li>

                        @include('admin.layouts.notify')

                        <form action="/upload_resume/{{Auth::user()->id}}" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Upload Resume</label>
                                    <div class="input-group">
                      <span class="input-group-btn">
                        <span class="btn btn-default btn-theme btn-file">
                          File  <input type="file" name="file" value="{{old('file')}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        </span>
                      </span>
                                        <input type="text" class="form-control form-flat" readonly>
                                    </div>
                                    <small>Upload your CV/resume. Max. file size: 24 MB.</small>
                                </div>
                            <button type="submit" class="btn  btn-line soft btn-theme btn-pill btn-block">Upload</button>

                        </form>

                    </ul>
                    <div class="white-space-20"></div>
                    <a href="/customer/job_post" class="btn  btn-line soft btn-theme btn-pill btn-block">Post a Job</a>
                </div>    </div>
        @if(sizeof($jobs)>0)
            <div class="col-md-9 col-sm-9">


                        <!-- item list -->
                <div class="box-list">
                    @foreach($jobs as $job)
                        <div class="item">
                            <div class="row">
                                @if(strlen($job->featured_image)>0)
                                    <div class="col-md-1 hidden-sm hidden-xs"><div class="img-item"><img src="{{$job->featured_image}}" alt=""></div></div>
                                @else
                                    <div class="col-md-1 hidden-sm hidden-xs"><div class="img-item"><img src="./assets/theme/images/company-logo/1.jpg" alt=""></div></div>
                                @endif
                                <div class="col-md-11">
                                    @if(strlen($job->link)>0)
                                        <h3 class="no-margin-top"><a href="{{$job->link}}" class="">{{$job->title}} <i class="fa fa-link color-white-mute font-1x"></i></a></h3>
                                    @else
                                        <h3 class="no-margin-top"><a href="/{{$job->slug}}" class="">{{$job->title}} <i class="fa fa-link color-white-mute font-1x"></i></a></h3>

                                    @endif
                                    @if(strlen($job->company)>0&&strlen($job->state)>0&&strlen($job->experience)>0)
                                        <h5><span class="color-black">Company:{{$job->company}}</span> - <span class="color-white-mute">State:{{$job->state}}</span></h5>
                                        <p class="text-truncate ">Experience:{{$job->experience}}Years</p>
                                    @endif
                                    <div>
                                        {{\Illuminate\Support\Str::limit(strip_tags($job->description),265)}}<br>
                                        <span class="color-white-mute">{{$job->created_at}}</span> -
                                        <a href="/{{$job->slug}}" class="btn btn-theme btn-xs btn-default">more ...</a>
                                        <form action="/customer/{{$job->id}}" method="POST">
                                            <p>Make it featured for:</p>
                                            <select name="days"  onchange=""  size="1">
                                                <option value="01">01 Day({{env('PER_DAY_CHARGE')/100}}$)</option>
                                                <option value="02">02 Days({{(env('PER_DAY_CHARGE')/100)*2}}$)</option>
                                                <option value="03">03 Days({{(env('PER_DAY_CHARGE')/100)*3}}$)</option>
                                                <option value="04">04 Days({{(env('PER_DAY_CHARGE')/100)*4}}$)</option>
                                                <option value="05">05 Days({{(env('PER_DAY_CHARGE')/100)*5}}$)</option>
                                                <option value="06">06 Days({{(env('PER_DAY_CHARGE')/100)*6}}$)</option>
                                                <option value="07">07 Days({{(env('PER_DAY_CHARGE')/100)*7}}$)</option>
                                                <option value="08">08 Days({{(env('PER_DAY_CHARGE')/100)*8}}$)</option>
                                                <option value="09">09 Days({{(env('PER_DAY_CHARGE')/100)*9}}$)</option>
                                                <option value="10">10 Days({{(env('PER_DAY_CHARGE')/100)*10}}$)</option>
                                                <option value="11">11 Days({{(env('PER_DAY_CHARGE')/100)*11}}$)</option>
                                                <option value="12">12 Days({{(env('PER_DAY_CHARGE')/100)*12}}$)</option>
                                                <option value="13">13 Days({{(env('PER_DAY_CHARGE')/100)*13}}$)</option>
                                                <option value="14">14 Days({{(env('PER_DAY_CHARGE')/100)*14}}$)</option>
                                                <option value="15">15 Days({{(env('PER_DAY_CHARGE')/100)*15}}$)</option>
                                                <option value="16">16 Days({{(env('PER_DAY_CHARGE')/100)*16}}$)</option>
                                                <option value="17">17 Days({{(env('PER_DAY_CHARGE')/100)*17}}$)</option>
                                                <option value="18">18 Days({{(env('PER_DAY_CHARGE')/100)*18}}$)</option>
                                                <option value="19">19 Days({{(env('PER_DAY_CHARGE')/100)*19}}$)</option>
                                                <option value="20">20 Days({{(env('PER_DAY_CHARGE')/100)*20}}$)</option>
                                                <option value="21">21 Days({{(env('PER_DAY_CHARGE')/100)*21}}$)</option>
                                                <option value="22">22 Days({{(env('PER_DAY_CHARGE')/100)*22}}$)</option>
                                                <option value="23">23 Days({{(env('PER_DAY_CHARGE')/100)*23}}$)</option>
                                                <option value="24">24 Days({{(env('PER_DAY_CHARGE')/100)*24}}$)</option>
                                                <option value="25">25 Days({{(env('PER_DAY_CHARGE')/100)*25}}$)</option>
                                                <option value="26">26 Days({{(env('PER_DAY_CHARGE')/100)*26}}$)</option>
                                                <option value="27">27 Days({{(env('PER_DAY_CHARGE')/100)*27}}$)</option>
                                                <option value="28">28 Days({{(env('PER_DAY_CHARGE')/100)*28}}$)</option>
                                                <option value="29">29 Days({{(env('PER_DAY_CHARGE')/100)*29}}$)</option>
                                                <option value="30">30 Days({{(env('PER_DAY_CHARGE')/100)*30}}$)</option>
                                                <option value="31">31 Days({{(env('PER_DAY_CHARGE')/100)*31}}$)</option>
                                            </select>
                                            <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="pk_test_FE92z9o3yzB4gQbS6agPBlfW"
                                                    data-name="Jobfeeder"
                                                    data-locale="auto">

                                            </script>


                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end item list -->
                    @endforeach
                            <!-- pagination -->
                        <nav >
                            <ul class="pagination pagination-theme  no-margin pull-right">
                                {!! $jobs->render() !!}
                            </ul>
                        </nav><!-- pagination -->

                </div>


            </div><!-- end box listing -->
                @else
                <div class="col-md-8 col-sm-8 col-md-offset-1">
                    <!-- item list -->
                    <div class="box-list">
                       <h1>No Jobs Posted Yet</h1>
                </div><!-- end box listing -->
                @endif

            </div>
        </div>
    </div>

@endsection