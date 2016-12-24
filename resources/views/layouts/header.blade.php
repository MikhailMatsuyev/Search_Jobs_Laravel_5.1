<!-- main-header -->
<header class="main-header">

    <!-- main navbar -->
    <nav class="navbar navbar-default main-navbar hidden-sm hidden-xs">
@if(strlen($settings_general->logo_120)>0)
        <a href="/">
            <img src="{{$settings_general->logo_120}}" alt="logo" style="padding-top: 12px;position: absolute;"/>
        </a>
        @endif

        <div class="container">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                <ul class="nav navbar-nav">

                    <li class=""><a href="/"><strong>Home</strong></a></li>
                    <li class=""><a href="/jobs"><strong>Find a Job</strong></a></li>
                    <li class=""><a href="/customer/job_post"><strong>Post a Job</strong></a></li>
                    <li class=""><a href="/contact"><strong>Contact Us</strong></a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="link-profile dropdown-toggle"  data-toggle="dropdown" >
                                    <img src="{{Auth::user()->avatar}}" alt="" class="img-profile"> &nbsp; {{Auth::user()->name}} <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/customer"> Account </a></li>
                                    <li><a href="/customer/change_password"> Change Password</a></li>
                                    <li><a href="/customer/applicants">Applicants</a></li>

                                </ul>
                            </li>
                            <li class="link-btn"><a href="/logout"><span class="btn btn-theme  btn-pill btn-xs btn-line">Logout</span></a></li>
                        </ul>
                    @else

                    <li class="link-btn"><a href="/login"><span
                                    class="btn btn-theme btn-pill btn-xs btn-line">Login</span></a></li>
                    <li class="link-btn"><a href="/register"><span class="btn btn-theme  btn-pill btn-xs btn-line">Register</span></a>
                    </li>
                        @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- end main navbar -->

    <!-- mobile navbar -->
    <div class="container">
        <nav class="mobile-nav hidden-md hidden-lg">
            <a href="#" class="btn-nav-toogle first">
                <span class="bars"></span>
                Menu
            </a>

            <div class="mobile-nav-block">
                <h4>Navigation</h4>
                <a href="#" class="btn-nav-toogle">
                    <span class="barsclose"></span>
                    Close
                </a>

                <ul class="nav navbar-nav">
                    <li class=""><a href="/"><strong>Home</strong></a></li>
                    <li class=""><a href="/job_list"><strong>Find a Job</strong></a></li>
                    <li class=""><a href="/customer/job_post"><strong>Post a Job</strong></a></li>
                    <li class=""><a href="/contact"><strong>Contact Us</strong></a></li>
                    <li class=""><a href="/login"><strong>Login</strong></a></li>
                    <li class=""><a href="/register"><strong>Register</strong></a></li>


                </ul>
            </div>
        </nav>
    </div>
    <!-- mobile navbar -->
    @if (Request::is('/'))
        <div class="hero-header">
            <div class="inner-hero-header">
                <div class="container">


                    <div class="relative" >

                        @include('search_form')

                    </div>
                </div>
            </div>


            <!-- modal Advanced search -->
            <div class="modal fade" id="modal-advanced">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Advanced Job Search</h4>
                            </div>
                            <div class="modal-body">
                                <h5>Find Jobs</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>With all of these words</label>
                                            <input type="text" class="form-control " name="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>With the exact phrase</label>
                                            <input type="text" class="form-control " name="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Show jobs of type</label>
                                    <select class="form-control">
                                        <option value="all">All job types</option>
                                        <option value="fulltime">Full-time</option>
                                        <option value="parttime">Part-time</option>
                                        <option value="contract">Contract</option>
                                        <option value="internship">Internship</option>
                                        <option value="temporary">Temporary</option>
                                    </select>
                                </div>
                                <div class="white-space-10"></div>
                                <h5>Where and When</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Radius </label>
                                            <select id="radius" class="form-control">
                                                <option value="0">only in</option>
                                                <option value="5">within 5 kilometers</option>
                                                <option value="10">within 10 kilometers</option>
                                                <option value="15">within 15 kilometers</option>
                                                <option selected="" value="25">within 25 kilometers</option>
                                                <option value="50">within 50 kilometers</option>
                                                <option value="100">within 100 kilometers</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Of </label>
                                            <input type="text" class="form-control" maxlength="250"
                                                   value="United States">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Age - Jobs published </label>
                                            <select class="form-control">
                                                <option value="any">anytime</option>
                                                <option value="15">within 15 days</option>
                                                <option value="7">within 7 days</option>
                                                <option value="3">within 3 days</option>
                                                <option value="1">since yesterday</option>
                                                <option value="last">since my last visit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Display</label>
                                            <select class="form-control">
                                                <option selected="" value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-theme" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-success btn-theme">Find Jobs</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal forgot password -->


        </div>
    @endif
</header><!-- end main-header -->