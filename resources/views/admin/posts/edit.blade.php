@extends('admin.layouts.master')

@section('extra_css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/assets/plugins/redactor/redactor.css"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/plugins/redactor/plugins/imagemanager.js" data-cfasync='false'></script>
    <script src="/assets/plugins/redactor/redactor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#tags').tagsinput();

            $('#description').redactor({
                        imageUpload: '/admin/redactor',
                        imageManagerJson: '/admin/redactor/images.json',
                        plugins: ['imagemanager'],
                        replaceDivs: false,
                        convertDivs: false,
                        uploadImageFields: {
                            _token: "{{csrf_token()}}"
                        }
                    }
            );

            var category_el = $('#category');
            var render_type_el = $('#render_type');
            var state_el = $('#state');
            var country_el = $('#country');


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

                        jQuery.isEmptyObject( cities )
                        {
                            $('#city')
                                    .find('option')
                                    .remove()
                                    .end()
                                    .append('<option value=""></option>')
                                    .val('')
                            ;
                        }

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

            country_el.on('change', function () {
                $.ajax({
                    url: "/api/get_states/" + $('#country').val(),
                    success: function (states) {

                        var $state_select = $('#state');

                        jQuery.isEmptyObject( states )
                        {
                            $('#city')
                                    .find('option')
                                    .remove()
                                    .end()
                                    .append('<option value=""></option>')
                                    .val('')
                            ;
                        }

                        $state_select.find('option').remove();

                        $.each(states, function (key, value) {

                            $state_select.append($("<option></option>")
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

                if (val == "{{\App\Posts::RENDER_TYPE_TEXT}}") {
                    $('#featured_image_div').hide();
                    $('#image_parallax_div').hide();

                    $('#gallery_image_div').hide();
                    $('#featured_preview_div').hide();
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
                    $('#featured_preview_div').hide();
                    $('#image_parallax_div').hide();
                    $('#video_div').hide();
                    $('#video_parallax_div').hide();
                }

                if (val == "{{\App\Posts::RENDER_TYPE_VIDEO}}") {
                    $('#video_div').show();
                    $('#video_parallax_div').show();
                    $('#featured_preview_div').show();
                    $('#featured_image_div').show();

                    $('#gallery_image_div').hide();
                    $('#image_parallax_div').hide();
                }

            });


            //category_el.trigger('change');
            render_type_el.trigger('change');

        });
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
                <a href="/admin/posts/edit/{{$post->id}}">{{trans('messages.edit_post')}} - {{$post->title}}</a>
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
                        <i class="icon-docs"></i>{{trans('messages.edit_post')}} - {{$post->title}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">


                    <form action="/admin/posts/update" id="form-username" method="post"
                          class="form-horizontal form-bordered" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>

                            <div class="col-sm-4">
                                @include('admin.layouts.notify')
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="id" value="{{$post->id}}"/>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">{{trans('messages.company')}}</label>
                            <div class="col-sm-8">
                                <input id="company " class="form-control" type="text" name="company"
                                       placeholder="{{trans('messages.enter_post_company')}}"  value="{{old('company',$post->company)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">{{trans('messages.title')}}</label>

                            <div class="col-sm-8">
                                <input id="title" class="form-control" type="text" name="title"
                                       placeholder="{{trans('messages.enter_post_title')}}"
                                       value="{{old('title',$post->title)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description"
                                   class="col-sm-3 control-label">{{trans('messages.description')}}</label>
                            <div class="col-sm-8">
                                <textarea id="description" class="form-control" name="description">{{old('description',$post->description)}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-sm-3 control-label">{{trans('messages.countries')}}</label>
                            <div class="col-sm-8">
                                <select  id="country" name="country" class="form-control" >
                                    <option selected="selected" >
                                        {{old('country',$post->country)}}
                                    </option>

                                    @foreach($countries as $country)

                                    <option value="{{$country->name}}" >{{$country->name}}
                                    </option>

                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state" class="col-sm-3 control-label">{{trans('messages.states')}} </label>

                            <div class="col-sm-8">
                                <select id="state" name="state" class="form-control" >
                                    <option selected="selected">
                                        {{old('state',$post->state)}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-8">
                                <select id="city" name="city" class="form-control">
                                    <option selected="selected">
                                        {!!  old('city',$post->city)!!}
                                    </option>
                                </select>
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="category" class="col-sm-3 control-label">{{trans('messages.category')}}</label>

                            <div class="col-sm-8">
                                <select name="category" id="category" class="form-control">
                                  @if(isset($post->parent_category))
                                    @foreach($categories as $category)
                                        <option {{$post->parent_category->id == $category->id ? 'selected':''}}
                                                value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                    @else 
                                        @foreach($categories as $category)
                                        <option 
                                                value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sub_category"
                                   class="col-sm-3 control-label">{{trans('messages.sub_category')}}</label>

                            <div class="col-sm-8">
                                <select id="sub_category" name="sub_category" class="form-control">
                                  @if(isset($sub_categories))
                                    @foreach($sub_categories as $sub)
                                        <option {{$post->category->id == $sub->id ? 'selected':''}} value="{{$sub->id}}">{{$sub->title}}</option>
                                    @endforeach
                                   @else 





                                   @endif 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="salary" class="col-sm-3 control-label">{{trans('messages.salary')}}</label>

                            <div class="col-sm-8">
                                <input id="salary " class="form-control" type="text" name="salary"
                                       placeholder="{{trans('messages.salary')}}" value="{{old('salary',$post->salary)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="experience" class="col-sm-3 control-label">{{trans('messages.experience')}}</label>

                            <div class="col-sm-8">
                                <input id="experience " class="form-control" type="number" name="experience"
                                       placeholder="{{trans('messages.experience')}}" value="{{old('experience',$post->experience)}}"/>
                            </div>
                        </div>

                        <div class="form-group" id="featured_image_div">
                            <label for="featured_image"
                                   class="col-sm-3 control-label">{{trans('messages.featured_image')}}</label>
                            <div class="col-sm-8">
                                <input id="featured_image" class="form-control" type="file" name="featured_image"/>
                            </div>
                        </div>

                        @if(strlen($post->featured_image) >0 && $post->render_type != App\Posts::RENDER_TYPE_GALLERY)
                            <div class="form-group" id="featured_preview_div">
                                <label class="col-sm-3 control-label"></label>

                                <div class="col-sm-8">
                                    <a target="_blank" href="{{$post->featured_image}}"><img
                                                src="{{$post->featured_image}}" style="width:200px;"/></a>
                                </div>
                            </div>
                        @endif

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
                                    <option {{$post->status == \App\Posts::STATUS_PUBLISHED?'selected':''}}
                                            value="{{\App\Posts::STATUS_PUBLISHED}}">{{trans('messages.published')}}
                                    </option>
                                    <option {{$post->status == \App\Posts::STATUS_HIDDEN?'selected':''}}
                                            value="{{\App\Posts::STATUS_HIDDEN}}">{{trans('messages.hidden')}}
                                    </option>
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
        </div>
    </div>
@stop