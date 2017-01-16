@extends('admin.layouts.master')

@section('extra_css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/assets/plugins/redactor/redactor.css"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/plugins/redactor/plugins/imagemanager.js" data-cfasync='false'></script>
    <script src="/assets/plugins/redactor/redactor.js"></script>
    <script type= "text/javascript" src = "/assets/js/countries.js"></script>

    <script type="text/javascript">
   (function($){
        $(document).ready(function () {

            $('#tags').tagsinput();

            $('#description').redactor({
                imageUpload: '/redactor',
                imageManagerJson: '/admin/redactor/images.json',
                plugins: ['imagemanager'],
                replaceDivs: false,
                convertDivs: false,
                uploadImageFields: {
                    _token: "{{csrf_token()}}"
                }
            });

            var category_el = $('#category');
            var render_type_el = $('#render_type');
            var state_el = $('#state');

            category_el.on('change', function () {
                $.ajax({
                    url: "/api/get_sub_categories_by_category/" + $('#category').val(),
                    success: function (sub_categories) {

                        var $sub_category_select = $('#sub_category');
                        $sub_category_select.find('option').remove();

                        $.each(sub_categories, function (key, value) {
                            $sub_category_select.append('<option value=' + value['id'] + '>' + value['title'] + '</option>');
                        });
                    },
                    error: function (response) {
                    }
                });
            });

            state_el.on('change', function () {
                $.ajax({
                    url: "/api/get_cities/" + $('#state').val(),
                    success: function (cities) {


                        var $city_select = $('#city');
                        $city_select.find('option').remove();

                        $.each(cities, function (key, value) {

                            $city_select.append($("<option></option>")
                                    .val(value['name'])
                                    .text(value['name']));
                        });
                    },
                    error: function (response) {
                    }
                });
            });

            render_type_el.on('change', function (ev) {
                var val = $(this).find('option:selected').val();

                console.log(val);

                if (val == "{{\App\Posts::RENDER_TYPE_TEXT}}") {
                    $('#featured_image_div').hide();
                    $('#image_parallax_div').hide();

                    $('#gallery_image_div').hide();
                    $('#video_div').hide();
                    $('#video_parallax_div').hide();
                }

                if (val == "{{\App\Posts::RENDER_TYPE_IMAGE}}") {
                    $('#featured_image_div').show();
                    $('#image_parallax_div').show();

                    $('#gallery_image_div').hide();
                    $('#video_div').hide();
                    $('#video_parallax_div').hide();
                }

                if (val == "{{\App\Posts::RENDER_TYPE_GALLERY}}") {
                    $('#gallery_image_div').show();

                    $('#featured_image_div').hide();
                    $('#image_parallax_div').hide();
                    $('#video_div').hide();
                    $('#video_parallax_div').hide();
                }

                if (val == "{{\App\Posts::RENDER_TYPE_VIDEO}}") {
                    $('#video_div').show();
                    $('#video_parallax_div').show();
                    $('#featured_image_div').show();

                    $('#gallery_image_div').hide();
                    //$('#featured_image_div').hide();
                    $('#image_parallax_div').hide();
                }

            });

            category_el.trigger('change');
            render_type_el.trigger('change');

            populateCountries("country", "state");

        });
            })(jQuery);
    </script>
@stop

@section('content')

    <h3 class="page-title">
        {{trans('messages.posts')}}
        <small>{{trans('messages.manage_posts')}}</small>
    </h3>

    <div class="page-bar">
        <ul class="page-breadcrumb">

            <li>
                <a href="/admin">{{trans('messages.home')}}</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="/admin/posts">{{trans('messages.posts')}}</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="/admin/posts/create"> {{trans('messages.create_new_post')}} </a>
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
                        <i class="icon-docs"></i>{{trans('messages.create_new_post')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">


                    <form action="/admin/posts/create" id="form-username" method="post"
                          class="form-horizontal form-bordered" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>

                            <div class="col-sm-4">
                                @include('admin.layouts.notify')
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">{{trans('messages.company')}}</label>

                            <div class="col-sm-8">
                                <input id="company " class="form-control" type="text" name="company"
                                       placeholder="{{trans('messages.enter_post_company')}}" value="{{old('company')}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">{{trans('messages.title')}}</label>

                            <div class="col-sm-8">
                                <input id="title" class="form-control" type="text" name="title"
                                       placeholder="{{trans('messages.enter_post_title')}}" value="{{old('title')}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description"
                                   class="col-sm-3 control-label">{{trans('messages.description')}}</label>

                            <div class="col-sm-8">
                                <textarea id="description" class="form-control" name="description"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="country" class="col-sm-3 control-label">{{trans('messages.countries')}}</label>
                            <div class="col-sm-8">
                                <select id="country" name="country" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state" class="col-sm-3 control-label">{{trans('messages.states')}}</label>
                            <div class="col-sm-8">
                                <select id="state" name="state" class="form-control">
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-8">
                                <select id="city" name="city" class="form-control">
                                </select>
                            </div>
                        </div>

                        @foreach($categories as $category)
                        <input type="hidden" name="category_id" value="{{$category->id}}"/>
                        @endforeach

                        <div class="form-group">
                            <label for="category" class="col-sm-3 control-label">{{trans('messages.category')}}</label>

                            <div class="col-sm-8">
                                <select id="category" name="category" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{$category->title}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="sub_category"
                                   class="col-sm-3 control-label">{{trans('messages.sub_category')}}</label>
                            <div class="col-sm-8">
                                <select id="sub_category" name="sub_category" class="form-control">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="salary" class="col-sm-3 control-label">{{trans('messages.salary')}}</label>

                            <div class="col-sm-8">
                                <input id="salary " class="form-control" type="text" name="salary"
                                       placeholder="{{trans('messages.salary')}}" value="{{old('salary')}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="experience" class="col-sm-3 control-label">{{trans('messages.experience')}}</label>

                            <div class="col-sm-8">
                                <input id="experience " class="form-control" type="number" name="experience"
                                       placeholder="{{trans('messages.experience')}}" value="{{old('experience')}}"/>
                            </div>
                        </div>

                        <div class="form-group" id="featured_image_div">
                            <label for="featured_image"
                                   class="col-sm-3 control-label">{{trans('messages.company_logo')}}</label>

                            <div class="col-sm-8">
                                <input id="featured_image" class="form-control" type="file" name="featured_image"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Featured</label>

                            <div class="col-sm-8">
                                <select id="status" class="form-control" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">{{trans('messages.status')}}</label>

                            <div class="col-sm-8">
                                <select id="status" class="form-control" name="status">
                                    <option value="{{\App\Posts::STATUS_PUBLISHED}}">{{trans('messages.published')}}</option>
                                    <option value="{{\App\Posts::STATUS_HIDDEN}}">{{trans('messages.hidden')}}</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn purple"><i
                                                class="fa fa-check"></i> {{trans('messages.save')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@stop