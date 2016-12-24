@extends('layouts.master')


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


                    </ul>
                    <div class="white-space-20"></div>
                    <a href="/customer/job_post" class="btn  btn-line soft btn-theme btn-pill btn-block">Post a Job</a>
                </div>    </div>
            <div class="col-md-9 col-sm-9">
                <!-- Block side right -->
                <div class="block-section box-side-account">
                    <h3 class="no-margin-top">Change Password</h3>
                    <hr/>
                    <div class="row">
                        @include('admin.layouts.notify')
                        <div class="col-md-7">
                            <form action="/customer/change_password" method="post">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" name="old_password" class="form-control">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Re-type New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-theme btn-t-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- end Block side right -->
            </div>

        </div>
    </div>
    </div>

@endsection