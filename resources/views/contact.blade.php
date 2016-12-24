@extends('layouts.master')

@section('extra_css')

    <title>Contact</title>


    <meta name="description" content="Contact Us">





@stop

@section('content')
    <div class="container min-hight" style="padding-top:20px">
        <div class="row" >
            <div class="col-md-9 col-sm-9"  style="padding-bottom:20px">
                <h2>Contact Form</h2>
                <p>Lorem ipsum dolor sit amet, Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat consectetuer adipiscing elit, sed diam nonummy nibh euismod tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                <div class="space20"></div>
                <!-- BEGIN FORM-->
                @include('admin.layouts.notify')

                <form action="/contact" method="post" class="horizontal-form margin-bottom-40" role="form">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="name" name="name" class="form-control" placeholder="Your Name">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" rows="8"></textarea>
                    </div>


                    <div class="form-group no-margin">
                        <button type="submit" class="btn btn-theme btn-md-3 btn-t-primary pull-right">Send</button>
                    </div>

                </form>
                <!-- END FORM-->
            </div>

            <div class="col-md-3 col-sm-3">
                <h2>Our Contacts</h2>
                <address>
                    <strong>Loop, Inc.</strong><br>
                    795 Park Ave, Suite 120<br>
                    San Francisco, CA 94107<br>
                    <abbr title="Phone">P:</abbr> (234) 145-1810
                </address>
                <address>
                    <strong>Email</strong><br>
                    <a href="mailto:#">info@email.com</a><br>
                    <a href="mailto:#">support@example.com</a>
                </address>


                <div class="clearfix margin-bottom-30"></div>

                <h2>About Us</h2>
                <p>Sediam nonummy nibh euismod tation ullamcorper suscipit</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-check"></i> Officia deserunt molliti</li>
                    <li><i class="fa fa-check"></i> Consectetur adipiscing </li>
                    <li><i class="fa fa-check"></i> Deserunt fpicia</li>
                </ul>
            </div>
        </div>
    </div>

@endsection