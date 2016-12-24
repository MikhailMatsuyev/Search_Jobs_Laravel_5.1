@extends('layouts.master')

@section('extra_css')

    <title>Login</title>


    <meta name="description" content="Login On Jobrra>




@stop



@section('content')
    <div class="block-section ">
        <div class="container" style="padding-bottom:70px">
            <div class="panel panel-md">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" >
                            

                            @include('admin.layouts.notify')
                            <!-- form login -->
                            <form action="/login" method="POST">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email"  name="email" class="form-control" placeholder="Your Email">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password"  class="form-control" placeholder="Your Password">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="checkbox flat-checkbox">
                                                <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                    Remember me?
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <p class="help-block"><a href="#myModal" data-toggle="modal">Forgot password?</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin">
                                    <button class="btn btn-theme btn-lg btn-t-primary btn-block">Log In</button>
                                </div>
                            </form><!-- form login -->

                        </div>


                    </div>
                </div>
            </div>

            <div class="white-space-20"></div>
            <div class="text-center color-black">Not a member? &nbsp; <a href="/register" class="link-black"><strong>Create an account free</strong></a></div>
        </div>


    </div>




    <!-- modal forgot password -->
    <div class="modal fade" id="myModal" >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="/forgot-password" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" >Forgot Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter Your Email</label>
                            <input type="email" class="form-control " name="email" placeholder="Email">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-theme" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-theme">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end modal forgot password -->

@endsection