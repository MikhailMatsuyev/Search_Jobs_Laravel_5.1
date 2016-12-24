@extends('layouts.master')



@section('content')
    <div class="body-content clearfix" >

        <div class="block-section bg-color2">
            <div class="container">
                <!-- text centered -->
                <div class="text-center">
                    <h1>Oops!</h1>
                    <h2>Sorry, maybe you are lost below is the good starting point for you.<br/><small>Error code: 403</small></h2>

                    <p>Here are some helpful links instead:</p>
                    <ul class="list-inline">
                        <li> <a href="/">Home</a></li>
                        <li><a href="/job_list">Find a Job</a></li>
                        <li> <a href="/contact">Contact Us</a></li>
                    </ul>
                </div><!-- end text centered -->

                <!-- big text error -->
                <div class="big-error">403</div><!-- end big text error -->
            </div>
        </div>
    </div><!--end body-content -->


@stop

