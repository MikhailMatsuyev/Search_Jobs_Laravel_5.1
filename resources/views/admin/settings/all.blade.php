@extends('admin.layouts.master')

@section('extra_css')
    <link rel="stylesheet" href="/assets/plugins/redactor/redactor.css"/>
@stop

@section('extra_js')
    <script src="/assets/plugins/redactor/plugins/imagemanager.js" data-cfasync='false'></script>
    <script src="/assets/plugins/redactor/redactor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#description').redactor({
                imageUpload: '/admin/redactor',
                imageManagerJson: '/admin/redactor/images.json',
                plugins: ['imagemanager'],
                replaceDivs: false,
                convertDivs: false,
                uploadImageFields: {
                    _token: "{{csrf_token()}}"
                }
            });

            $('#{{\App\Posts::COMMENT_DISQUS}}_div').hide();

            $('#comment_system').on('change', function () {
                $selected = $('#comment_system option:selected').val();


                if ($selected == "{{\App\Posts::COMMENT_FACEBOOK}}") {
                    $('#{{\App\Posts::COMMENT_FACEBOOK}}_div').show();

                    $('#{{\App\Posts::COMMENT_DISQUS}}_div').hide();

                }

                if ($selected == "{{\App\Posts::COMMENT_DISQUS}}") {
                    $('#{{\App\Posts::COMMENT_DISQUS}}_div').show();

                    $('#{{\App\Posts::COMMENT_FACEBOOK}}_div').hide();

                }

            });

            $('#comment_system').trigger('change');

        });
    </script>
@stop

@section('content')

    <h3 class="page-title">
        {{trans('messages.settings')}}
        <small>{{trans('messages.manage_settings')}} <a role="button" class="btn btn-primary btn-sm"
                                                        href="/admin/update_application">{{trans('messages.update_application')}}</a>
        </small>
    </h3>

    <div class="page-bar">
        <ul class="page-breadcrumb">

            <li>
                <a href="/admin">{{trans('messages.home')}}</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="/admin/settings">{{trans('messages.settings')}}</a>
            </li>
        </ul>
    </div>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>{{trans('messages.change_settings')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>

                <div class="portlet-body">

                    @include('admin.layouts.notify')

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_general" data-toggle="tab">
                                {{trans('messages.general')}} </a>
                        </li>
                        <li>
                            <a href="#tab_seo" data-toggle="tab">
                                {{trans('messages.seo')}} </a>
                        </li>

                        <li>
                            <a href="#tab_social" data-toggle="tab">
                                {{trans('messages.social')}} </a>
                        </li>
                        <li>
                            <a href="#tab_custom_js" data-toggle="tab">
                                {{trans('messages.custom_js')}} </a>
                        </li>

                        <li>
                            <a href="#tab_custom_css" data-toggle="tab">
                                {{trans('messages.custom_css')}} </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade active in" id="tab_general">

                            <div class="row">
                                <div class="col-md-12">

                                    <form action="/admin/settings/update_general" id="form-username" method="post"
                                          class="form-horizontal form-bordered" enctype="multipart/form-data">

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            <label for="site_url"
                                                   class="col-sm-3 control-label">{{trans('messages.site_url')}}</label>

                                            <div class="col-sm-8">
                                                <input id="site_url" class="form-control" type="text" name="site_url"
                                                       placeholder="{{URL::to('/')}}"
                                                       value="{{old('site_url',$general->site_url)}}"/>
                                                <span class="help-block"> {{trans('messages.site_url_should_start_with_etc')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="site_title"
                                                   class="col-sm-3 control-label">{{trans('messages.site_title')}}</label>

                                            <div class="col-sm-8">
                                                <input id="site_title" class="form-control" type="text"
                                                       name="site_title"
                                                       placeholder="{{trans('messages.enter_site_title')}}"
                                                       value="{{old('site_title',$general->site_title)}}"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="analytics_code"
                                                   class="col-sm-3 control-label">{{trans('messages.google_analytics_code')}}</label>

                                            <div class="col-sm-8">
                                <textarea id="analytics_code" class="form-control" name="analytics_code"
                                          placeholder="{{trans('messages.enter_google_analytics_code')}}">{{old('analytics_code',$general->analytics_code)}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="mailchimp_form"
                                                   class="col-sm-3 control-label">{{trans('messages.mailchimp_signup_form')}}</label>

                                            <div class="col-sm-8">
                                <textarea id="mailchimp_form" class="form-control" name="mailchimp_form"
                                          placeholder="{{trans('messages.enter_mailchimp_signup_form_code')}} ">{{old('mailchimp_form',$general->mailchimp_form)}}</textarea>
                                                <span class="help-block"> {{trans('messages.know_more_abt_mailchimp')}}
                                                    <a
                                                            href="http://kb.mailchimp.com/lists/signup-forms/add-a-signup-form-to-your-website">{{trans('messages.here')}}</a></span>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label for="logo_120"
                                                   class="col-sm-3 control-label">{{trans('messages.logo_120_120')}}</label>

                                            <div class="col-sm-8">
                                                <input id="logo_120" class="form-control" name="logo_120" type="file"/>
                                            </div>
                                        </div>

                                        @if(strlen($general->logo_120) > 0)
                                            <div class="form-group">
                                                <label for="logo_120"
                                                       class="col-sm-3 control-label"></label>

                                                <div class="col-sm-8">
                                                    <img src="{{$general->logo_120}}"/>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="form-group">
                                            <label for="favicon"
                                                   class="col-sm-3 control-label">{{trans('messages.upload_favicon')}}</label>

                                            <div class="col-sm-8">
                                                <input type="hidden" name="favicon_value"
                                                       value="{{$general->favicon}}"/>
                                                <input id="favicon" class="form-control" name="favicon" type="file"/>
                                            </div>
                                        </div>

                                        @if(strlen($general->favicon)>0)
                                            <div class="form-group">
                                                <div class="col-md-offset-3 col-md-8">
                                                    <img src="{{$general->favicon}}"/>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-md-8">
                                                <label>
                                                    <input {{($general->generate_sitemap == 1)?'checked':''}}
                                                           name="generate_sitemap"
                                                           type="checkbox"> {{trans('messages.generate_sitemap')}}
                                                </label>
                                                <span class="help-block"> {{trans('messages.generate_sitemap_help')}} {{URL::to('/').'/sitemap.xml'}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-md-8">
                                                <label>
                                                    <input {{$general->generate_rss_feeds == 1?'checked':''}}
                                                           name="generate_rss_feeds"
                                                           type="checkbox"> {{trans('messages.generate_rss_feeds')}}
                                                </label>
                                                <span class="help-block"> {{trans('messages.generate_rss_feeds_help')}} {{URL::to('/').'/rss.xml'}}</span>
                                            </div>
                                        </div>


                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn purple"><i class="fa fa-check"></i>
                                                        {{trans('messages.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab_seo">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="/admin/settings/update_seo" id="form-username" method="post"
                                          class="form-horizontal form-bordered">

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            <label for="seo_keywords"
                                                   class="col-sm-3 control-label">{{trans('messages.seo_keywords')}}</label>

                                            <div class="col-sm-8">
                                <textarea id="seo_keywords" class="form-control" name="seo_keywords"
                                          placeholder="{{trans('messages.enter_seo_keywords')}}">{{old('seo_keywords',$seo->seo_keywords)}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="seo_description"
                                                   class="col-sm-3 control-label">{{trans('messages.seo_description')}}</label>

                                            <div class="col-sm-8">
                                <textarea id="seo_description" class="form-control" name="seo_description"
                                          placeholder="{{trans('messages.enter_seo_description')}}">{{old('seo_description',$seo->seo_description)}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="google_verify"
                                                   class="col-sm-3 control-label">{{trans('messages.google_webmaster_domain_verify')}}</label>

                                            <div class="col-sm-8">
                                                <input id="google_verify" class="form-control" type="text"
                                                       name="google_verify"
                                                       placeholder="{{trans('messages.google_webmaster_domain_verify_holder')}}"
                                                       value="{{old('google_verify',$seo->google_verify)}}"/>
                                                <span class="help-block"> {{trans('messages.google_webmaster_domain_verify_help')}}</span>
                                                <label class="label label-success">&#x3C;meta name=&#x22;google-site-verification&#x22;
                                                    content=&#x22;QsHIQMfsdaassq1kr8irG33KS7LoaJhZY8XLTdAQ7PA&#x22; /&#x3E;</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="bing_verify"
                                                   class="col-sm-3 control-label">{{trans('messages.bing_webmaster_domain_verify')}}</label>

                                            <div class="col-sm-8">
                                                <input id="bing_verify" class="form-control" type="text"
                                                       name="bing_verify"
                                                       placeholder="{{trans('messages.bing_webmaster_domain_verify_holder')}}"
                                                       value="{{old('bing_verify',$seo->bing_verify)}}"/>
                                                <span class="help-block"> {{trans('messages.bing_webmaster_domain_verify_help')}}</span>
                                                <label class="label label-success">&#x3C;meta name=&#x22;msvalidate.01&#x22;
                                                    content=&#x22;5A3A378F55B7518E3733ffS784711DC0&#x22; /&#x3E;</label>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn purple"><i class="fa fa-check"></i>
                                                        {{trans('messages.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab_social">

                            <div class="row">
                                <div class="col-md-12">

                                    <form action="/admin/settings/update_social" id="form-username" method="post"
                                          class="form-horizontal form-bordered" enctype="multipart/form-data">

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            <label for="fb_page_url"
                                                   class="col-sm-3 control-label">{{trans('messages.facebook_page_url')}}</label>

                                            <div class="col-sm-8">
                                                <input id="fb_page_url" class="form-control" type="text"
                                                       name="fb_page_url"
                                                       placeholder="{{trans('messages.enter_facebook_page_url')}}"
                                                       value="{{old('fb_page_url',$social->fb_page_url)}}"/>
                                                <span class="help-block"> {{trans('messages.url_should_start_with_etc')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="twitter_url"
                                                   class="col-sm-3 control-label">{{trans('messages.twitter_url')}}</label>

                                            <div class="col-sm-8">
                                                <input id="twitter_url" class="form-control" type="text"
                                                       name="twitter_url"
                                                       placeholder="{{trans('messages.enter_twitter_url')}}"
                                                       value="{{old('twitter_url',$social->twitter_url)}}"/>
                                                <span class="help-block"> {{trans('messages.url_should_start_with_etc')}}</span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="google_plus_page_url"
                                                   class="col-sm-3 control-label">{{trans('messages.google_page_url')}}</label>

                                            <div class="col-sm-8">
                                                <input id="google_plus_page_url" class="form-control" type="text"
                                                       name="google_plus_page_url"
                                                       placeholder="{{trans('messages.google_page_url_holder')}}"
                                                       value="{{old('google_plus_page_url',$social->google_plus_page_url)}}"/>
                                                <span class="help-block"> {{trans('messages.url_should_start_with_etc')}}</span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="youtube_channel_url"
                                                   class="col-sm-3 control-label">{{trans('messages.youtube_channel_url')}}</label>

                                            <div class="col-sm-8">
                                                <input id="youtube_channel_url" class="form-control" type="text"
                                                       name="youtube_channel_url"
                                                       placeholder="{{trans('messages.enter_youtube_channel_url')}}"
                                                       value="{{old('youtube_channel_url',$social->youtube_channel_url)}}"/>
                                                <span class="help-block"> {{trans('messages.url_should_start_with_etc')}} </span>
                                            </div>
                                        </div>


                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn purple"><i class="fa fa-check"></i>
                                                        {{trans('messages.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab_custom_js">

                            <div class="row">
                                <div class="col-md-12">

                                    <form action="/admin/settings/update_custom_js" id="form-username" method="post"
                                          class="form-horizontal form-bordered">

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            <label for="custom_js"
                                                   class="col-sm-3 control-label">{{trans('messages.custom_js_code')}}</label>

                                            <div class="col-sm-8">
                                                <textarea rows="10" cols="10" id="custom_js" class="form-control"
                                                          name="custom_js"
                                                          placeholder="{{trans('messages.custom_js_code')}}">{{$custom_js->custom_js}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn purple"><i class="fa fa-check"></i>
                                                        {{trans('messages.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab_custom_css">

                            <div class="row">
                                <div class="col-md-12">

                                    <form action="/admin/settings/update_custom_css" id="form-username" method="post"
                                          class="form-horizontal form-bordered">

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            <label for="custom_css"
                                                   class="col-sm-3 control-label">{{trans('messages.custom_css_code')}}</label>

                                            <div class="col-sm-8">
                                                <textarea rows="10" cols="10" id="custom_css" class="form-control"
                                                          name="custom_css"
                                                          placeholder="{{trans('messages.custom_css_code')}}">{{$custom_css->custom_css}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn purple"><i class="fa fa-check"></i>
                                                        {{trans('messages.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@stop