@extends('layouts.master')



@section('content')
        <!-- body-content -->
    <div class="body-content clearfix" >

        <div class="block-section bg-color2">
            <div class="container">
                <!-- text centered -->
                <div class="text-center">
                    <h1>Oops!</h1>
                    <h2>We can't seem to find the page you're looking for.<br/><small>Error code: 404</small></h2>

                    <p>Here are some helpful links instead:</p>
                    <ul class="list-inline">
                        <li> <a href="/">Home</a></li>
                        <li><a href="/job_list">Find a Job</a></li>
                        <li> <a href="/contact">Contact Us</a></li>
                    </ul>
                </div><!-- end text centered -->

                <!-- big text error -->
                <div class="big-error">404</div><!-- end big text error -->
            </div>
        </div>
    </div><!--end body-content -->


@stop

