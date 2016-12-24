@extends('layouts.master')


@section('extra_css')

    <title>Applicants</title>


    <meta name="description" content="Applicants On JobFeeder">





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



                    </ul>
                    <div class="white-space-20"></div>
                    <a href="/customer/job_post" class="btn  btn-line soft btn-theme btn-pill btn-block">Post a Job</a>
                </div>    </div>

            <div class="col-md-9 col-sm-9">
                <div class="block-section box-side-account">
                    @if(sizeof($applicants)>0)
                    <h3 class="no-margin-top">Applicants</h3>
                    @else
                        <h3 class="no-margin-top">No Applicants</h3>
                    @endif

                        <hr/>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th class="text-right">Resume</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicants as $applicant)
                            <tr>
                                <th scope="row">{{$applicant->title}}</th>
                                <td>{{$applicant->name}}</td>
                                <td>{{$applicant->email}}</td>
                                <td class="text-right"><a href="{{$applicant->resume}}" class="btn btn-theme btn-xs btn-default">Resume</a></td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination -->
                    <nav >
                        <ul class="pagination pagination-theme no-margin pull-right  ">
                            {!! $applicants->render() !!}

                        </ul>
                    </nav><!-- pagination -->

                </div>
            </div>

        </div>
    </div>
    </div>

@endsection