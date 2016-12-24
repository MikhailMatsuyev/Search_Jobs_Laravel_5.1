@extends('layouts.master')

@section('extra_css')

    <title >
       
            {{$jobs->title}}
       
    </title>
<!--<h2 class="title"> -->
     




    <meta name="description" content="{{\Illuminate\Support\Str::limit(trim(strip_tags($jobs->description)),300)}}">



@stop


@section('extra_js')
    @if(!empty(Session::get('error_msg')) || !empty(Session::get('success_msg')))
        <script>
            $(function() {
                $('#modal-apply').modal('show');
            });
        </script>
        @endif
        @stop


@section('content')


    <!-- link top -->
    <div class="bg-color2 block-section-xs line-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 hidden-xs">
                    <div>Job details :</div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right"><a href="#">&laquo; Go back to job listings</a></div>
                </div>
            </div>
        </div>
    </div><!-- end link top -->

    <div class="bg-color2">
        <div class="container">
            <div class="row">
                <div class="col-md-9">

                    @foreach($ads as $ad)

                    @if($ad->position=='above_page')
                    {!! $ad->code !!}
                    @endif

                    @endforeach

                    <!-- box item details -->
                    @if($jobs->lang =='ar')
                    <div class="block-section box-item-details" style="direction: rtl;">
                    @else
                    <div class="block-section box-item-details" >

                    @endif
                        <div class="row">
                            <div class="col-md-8">
                                @if(strlen($jobs->featured_image)>0)
                               <img src="{{$jobs->featured_image}}" alt="">
                                    @else
                                    <img src="/assets/theme/images/company-logo/1.jpg" alt="">
                                    @endif
                            </div>

                        </div>
                        @if($jobs->lang =='ar')    
                        <h2 class="title" style="direction: rtl;">
                        
                        @else 
                        <h2 class="title">  
                        

                        
                        @endif 
                        <a href="#">{{$jobs->title}}</a>    
                        </h2>
                        
                        <div class="job-meta">
                            <ul class="list-inline">
                                <li><i class="fa fa-map-marker"></i> {{$jobs->state}}  {{$jobs->country}}</li>
                                <li><i class="fa fa-money"></i> {{$jobs->salary}}</li>
                            </ul>
                        </div>

                                                
                            <span style="font-size: 20px; ">   
                        
                            {!!$jobs->description !!}
                            
                        </span>    
                        
                    </div><!-- end box item details -->

                    @foreach($ads as $ad)

                        @if($ad->position=='below_page')
                            {!! $ad->code !!}
                        @endif

                    @endforeach
                    <div style="margin-top: 10px;">
                         @foreach($tags as $tag)
                            <span class="tagbox"><a class="taglink" href="/jobs?q={{ $tag }}&country={{ $_COOKIE['country'] }}">{{ $tag }}</a><span class="tagcount"></span></span>
                    @endforeach
                    </div>
                    <div>
                   @foreach($commentsData as $commentValue)
                   <img src="{!! $commentValue['author_avatar'] !!}" height="70" width="70" style="float: left; margin: 10px;">
                    {!! $commentValue['message'] !!}
                    <h4>{!! $commentValue['author_name'] !!}</h4>
                    <hr>
                   @endforeach
                   </div>
                   
                    <!-- <div id="disqus_thread">
                        
                    </div>
                            <script>


                            /**
                            *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                            *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                            /*
                            var disqus_config = function () {
                            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                            };
                            */
                            (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');
                            s.src = '//http-localhost-9.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                            })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript> -->
                                
                </div>
                <div class="col-md-3">

                    <!-- box affix right -->
                    <div class="block-section " id="affix-box" >
                        <div class="text-center" style="padding-bottom: 10px" 
                        @if(!Auth::check())
                        
                        id="Apply_for_job"
                        style="font-size: 20px !important; " 
                        
                        @else

                        @endif >
                            @if(strlen($jobs->link)>0)
                                <p><a href="{{$jobs->link}}"  data-toggle="modal" class="btn btn-theme btn-t-primary btn-block-xs">Apply This Job</a></p>
                                <!--<a href="https://www.facebook.com/sharer/sharer.php?u={{ $jobs->link }}"><button class="btn btn-t-primary">Share on Facebook</button></a>-->
                            @else
                            <p><a href="#modal-apply"  data-toggle="modal" class="btn btn-theme btn-t-primary btn-block-xs" >Apply This Job</a></p>
                            @endif
                            @if(!Auth::check())
                                    <p><a href="/login" class="btn btn-theme btn-t-primary btn-block-xs">Login and Apply</a></p>
                            @endif

                        </div><hr>
<div style="border-color: #20354a; border-style: solid ;border-radius: 5px;padding: 10px;" >
                            
                            <link href="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/css/embedded.css" rel="stylesheet" type="text/css">
<style>
    .subscribe-embedded-form
    {
        color: #333
    }
    .subscribe-embedded-form label{
        color: #555
    }
</style>
<div class="subscribe-embedded-form" style="">
    <h5>Subscribe to our mailing list</h4>
    <p class="text-sm text-right" >
        <span class="text-danger">*</span> indicates required
    </p>
    <form action="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/lists/58505af6a9b2a/embedded-form-subscribe-captcha" method="POST" class="form-validate-jqueryz">
        <div class="form-group">
            <label> Email <span class="text-danger">*</span>
            </label>
            <input id="EMAIL" placeholder="" value="" type="text" name="EMAIL" class="form-control equired email ">
        </div>
        <div class="form-group">
            <label>First name</label>
            <input id="FIRST_NAME" 
                placeholder="" 
                value="" 
                type="text" 
                name="FIRST_NAME" 
                class="form-control 
            ">
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input id="LAST_NAME" placeholder="" value="" type="text" name="LAST_NAME" class="form-control ">
        </div>
        <div class="form-button text-center">
            <button class="btn btn-primary ">Subscribe</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/assets/js/core/libraries/jquery.min.js">
</script>
<script type="text/javascript" src="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/assets/js/plugins/forms/validation/validate.min.js">
</script>
<script>
    $.noConflict();
    jQuery( document ).ready(function( $ ) 
    {
        $(".subscribe-embedded-form form").validate();
    });
</script>
</div>
<hr>
                        <!-- SHOW  RELETED JOBS -->
                        @foreach($relatedJobs as $reletedJobs)

                        @if($reletedJobs->lang =='ar')
                            <div style="direction: rtl">
                        @else   
                            </div>

                        @endif         
                                <a href="{{$reletedJobs->slug}}">
                                    <h5>
                                        {{ $reletedJobs->title }}
                                    </h5>
                                    
                                </a>


                                
                                
                                
                                
                                
                                @if($reletedJobs->lang =='ar')
                                <p style="direction: rtl">
                                @else
                                <p>
                                @endif
                                {{ str_limit($reletedJobs->description,50) }}
                                </p>
                                


                            </div>
                            <hr>
                        @endforeach

                        @if(strlen($jobs->company)>0&&strlen($jobs->salary)&&strlen($jobs->experience)&&strlen($jobs->state)&&strlen($jobs->country))
                        <div class="text-center" >
                        <h3>Company Details</h3>
                        <p>Company:{{$jobs->company}}</p>
                        <p>Salary:{{$jobs->salary}}</p>
                        <p>Experience:{{$jobs->experience}}</p>
                        <p>State:{{$jobs->state}}</p>
                        <p>Country:{{$jobs->country}}</p>
                            </div>
                            @endif



                        @foreach($ads as $ad)

                            @if($ad->position=='sidebar')
                                {!! $ad->code !!}
                            @endif

                        @endforeach
                        <!-------------------------------------------- -
    
                        <div >
                            
                            <link href="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/css/embedded.css" rel="stylesheet" type="text/css">
<style>
    .subscribe-embedded-form
    {
        color: #333
    }
    .subscribe-embedded-form label{
        color: #555
    }
</style>
<div class="subscribe-embedded-form" style="width: 200px;height: 320px">
    <h4>Subscribe to our mailing list</h4>
    <p class="text-sm text-right">
        <span class="text-danger">*</span> indicates required
    </p>
    <form action="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/lists/58505af6a9b2a/embedded-form-subscribe-captcha" method="POST" class="form-validate-jqueryz">
        <div class="form-group">
            <label> Email <span class="text-danger">*</span>
            </label>
            <input id="EMAIL" placeholder="" value="" type="text" name="EMAIL" class="form-control equired email ">
        </div>
        <div class="form-group">
            <label>First name</label>
            <input id="FIRST_NAME" 
                placeholder="" 
                value="" 
                type="text" 
                name="FIRST_NAME" 
                class="form-control 
            ">
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input id="LAST_NAME" placeholder="" value="" type="text" name="LAST_NAME" class="form-control ">
        </div>
        <div class="form-button">
            <button class="btn btn-primary">Subscribe</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/assets/js/core/libraries/jquery.min.js">
</script>
<script type="text/javascript" src="http://localhost/acelle-204/codecanyon-17796082-acelle-email-marketing-web-application/acelle-2.0.4/public/assets/js/plugins/forms/validation/validate.min.js">
</script>
<script>
    $.noConflict();
    jQuery( document ).ready(function( $ ) 
    {
        $(".subscribe-embedded-form form").validate();
    });
</script>
                            
                        <!--@include('emails.newsletter')-->

                        

                    </div><!-- box affix right -->

                </div>
            </div>
        </div>
    </div>

    <!-- block map -->





    <!-- modal apply -->
    <div class="modal fade" id="modal-apply">
        <div class="modal-dialog ">
            <div class="modal-content">
                @include('admin.layouts.notify')
                @if(Auth::check())

                    <form action="/job_apply/{{$jobs->author_id}}" method="post" enctype="multipart/form-data">
                        <div class="modal-header ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" >Apply</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full name</label>
                                <input type="text" class="form-control " name="name" placeholder="Enter Name" value="{{Auth::user()->name}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="title" value="{{$jobs->title}}"/>

                            </div>
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control " name="email"  placeholder="Enter Email" value="{{Auth::user()->email}}">
                            </div>
                            <div class="form-group">
                                <label>Tell us why you better?</label>
                                <textarea class="form-control" rows="6" name="comment" placeholder="Something Comment">{{old('comment')}}</textarea>
                            </div>
                            @if(strlen(Auth::user()->resume)==0)
                            <div class="form-group">
                                <label>Your Resume</label>
                                <div class="input-group">
                      <span class="input-group-btn">
                        <span class="btn btn-default btn-theme btn-file">
                          File  <input type="file" name="file" >
                        </span>
                      </span>
                                    <input type="text" class="form-control form-flat" readonly>
                                </div>

                                <small>Upload your CV/resume. Max. file size: 24 MB.</small>
                            </div>
                            @else
                            <p> <a target="_blank" href="{{Auth::user()->resume}}">Resume:{{Auth::user()->resume}}</a> </p>
                                @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-theme" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-theme">Send Application</button>
                        </div>
                    </form>

                @else
                <form action="/job_apply/{{$jobs->author_id}}" method="post" enctype="multipart/form-data">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" >Apply</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full name</label>
                            <input type="text" class="form-control " name="name" placeholder="Enter Name" value="{{old('name')}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="hidden" name="title" value="{{$jobs->title}}"/>



                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control " name="email"  placeholder="Enter Email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label>Tell us why you better?</label>
                            <textarea class="form-control" rows="6" name="comment" placeholder="Something Comment">{{old('comment')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Your Resume</label>
                            <div class="input-group">
                      <span class="input-group-btn">
                        <span class="btn btn-default btn-theme btn-file">
                          File  <input type="file" name="file" value="{{old('file')}}">
                        </span>
                      </span>
                                <input type="text" class="form-control form-flat" readonly>
                            </div>
                            <small>Upload your CV/resume. Max. file size: 24 MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-theme" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-theme">Send Application</button>
                    </div>
                </form>
                    @endif
            </div>
        </div>
    </div><!-- end modal  apply -->

@endsection