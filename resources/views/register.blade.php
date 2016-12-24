@extends('layouts.master')


@section('extra_css')

    <title>Register</title>


    <meta name="description" content="Register On Jobrra">



    <!--Og tags-->
    <meta property="og:site_name" content="{{$settings_general->site_title}}"/>
    <meta property="og:title" content="Register"/>
    <meta property="og:description"
          content="Register On JobFeeder"/>

@stop


@section('content')


    <div class="block-section "   style="padding-bottom:130px">
        <div class="container">
            <div class="panel panel-md">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            @include('admin.layouts.notify')

                            <!-- form login -->
                            <form action="/register" method="POST">

                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Your Password">
                                </div>
                                <div class="form-group">
                                    <label>Re-type Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type Your Password">
                                </div>
                                <div class="white-space-10"></div>
                                <div class="form-group no-margin">
                                    <button class="btn btn-theme btn-lg btn-t-primary btn-block">Register</button>
                                </div>
                            </form><!-- form login -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection