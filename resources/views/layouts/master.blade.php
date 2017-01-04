<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="author" content="{{$settings_general->site_url}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! $settings_seo->google_verify !!}

    {!! $settings_seo->bing_verify !!}

    {!! $settings_custom_css->custom_css !!}


    {!! $settings_general->analytics_code !!}


    <!--favicon-->
    <link rel="apple-touch-icon" href="/assets/theme/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="/assets/theme/images/favicon.ico" type="image/x-icon">

    <!-- bootstrap -->
    <link href="/assets/plugins/bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="/assets/plugins/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- lightbox -->
    <link href="/assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">


    <!-- Themes styles-->
    <link href="/assets/theme/css/theme.css" rel="stylesheet">
    <!-- Your custom css -->
    <link href="/assets/theme/css/theme-custom.css" rel="stylesheet">
    <link href="/jQuery-Autocomplete-master/content/styles.css" rel="stylesheet">

    @yield('extra_css')
    <link rel="shortcut icon" href="/assets/img/favicon.ico"/>

    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style type="text/css">
      .tagbox { 
background-color:#eee;
border: 1px solid #ccc;
margin:0px 10px 10px 0px;
line-height: 200%;
padding:2px 0 2px 2px;

}
.taglink  { 
padding:2px;
}

.tagbox a, .tagbox a:visited, .tagbox a:active { 
text-decoration:none;
}

.tagcount { 
background-color:green;
color:white;
position: relative;
padding:2px;
}
      /*
      .jo-sociallocker-strong
      {
        font-size: 20px!important;
        text-align: center;
      }
      .jo-sociallocker-inner-wrap
      {
        background-color: white !important;
        color: #0077b5;
        border-radius: 5px !important;
        border-color: #0077b5 !important;
        padding: 10px; 
        border-width: 3px !important;
        border-style: solid;
*/

      }
    </style>
</head>
<body>
<!-- wrapper page -->
<div class="wrapper">

    @include('layouts.header')

    <!-- body-content -->
    <div class="body-content clearfix" >

       @yield('content')

    </div><!--end body-content -->


    @include('layouts.footer')

</div><!-- end wrapper page -->




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/assets/plugins/jquery.js"></script>
<script src="/assets/plugins/jquery.easing-1.3.pack.js"></script>
<!-- jQuery Bootstrap -->
<script src="/assets/plugins/bootstrap-3.3.2/js/bootstrap.min.js"></script>
<!-- Lightbox -->
<script src="/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Theme JS -->
<script src="/assets/theme/js/theme.js"></script>
{!! $settings_custom_js->custom_js !!}

   <!--  GOOGLE JS FOR AUTOFILL COUNTRY AND STATE NAME -->
<!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDO1ZffBXM25_YA_5uJ-MaWTKBzGdDRi68"></script>-->



<!--
<script type="text/javascript">

  var geocoder;

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
} 
//Get the latitude and the longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng)
}

function errorFunction(){
    console.log("Geocoder failed");
}

  function initialize() {
    //geocoder = new google.maps.Geocoder();
  }

  function codeLatLng(lat, lng) {
      geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results)
        if (results[1]) {
         //formatted address
        console.log(results[0].formatted_address)
        //find country name
             for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {

            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate

                // condition for get city name
                 if (results[0].address_components[i].types[b] == "administrative_area_level_2") {

                    //this is the object you are looking for
                    city= results[0].address_components[i];
                    document.getElementById('city').value = city.long_name;
                }

                // condition for get state name
                if (results[0].address_components[i].types[b] == "administrative_area_level_1") {

                    //this is the object you are looking for
                    state = results[0].address_components[i];
                    document.getElementById('state').value = state.long_name;
                }

                // condition for get country name
                if(results[0].address_components[i].types[b] == "country")
                {
                  country= results[0].address_components[i];
                  document.getElementById('country').value = country.long_name;
                 document.cookie = "country="+country.long_name;

                }
            }

        }
        //city data
        //alert(city.short_name + " " + city.long_name)
        


        } else {
          console.log("No results found");
        }
      } else {
        console.log("Geocoder failed due to: " + status);
      }
    });
  }
</script>
-->

@yield('extra_js')
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5843fae70309266e"></script> 

<script src="jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="http://demo.phpgang.com/social-locker-jquery/social-locker.js"></script>

<script type="text/javascript">
    jQuery.noConflict();                    
    jQuery(document).ready(function ($) {
        $("#Apply_for_job").sociallocker({
            text: {
                
                
            },

            theme: "starter", // Theme

            locker: {
                close: false,
                timer: 0
            },

            buttons: {   // Buttons you want to show on box
                order: ["twitter-tweet", "facebook-like","twitter-follow", "google-plus", "linkedin-share"] 
            },

            facebook: {  
                
                like: {
                    title: "Like us",
                    url: "https://www.facebook.com/FacebookforDevelopers/" // link to like in Facebook button
                }
            },

            twitter: {
                tweet: {
                    title: "Tweet", 
                    text: "PHPGang Programming Blog, Tutorials, jQuery, Ajax, PHP, MySQL and Demos.", // tweet text
                    url: "http://www.phpgang.com/" //tweet link
                },
                follow: {
                    title: "Follow us", 
                    url: "http://twitter.com/phpgang" // Twitter profile to follow 
                }
            },

            google: {                                
                plus: {
                    title: "Plus +1",
                    url: "http://www.phpgang.com/" // Google plus link for +1
                }
            },

            linkedin: {
                url: "http://www.phpgang.com/",      // LinkedIn url to share 
                share: {
                    title: "Share"
                }
            }
        });
    });
</script>
</body>
</html>