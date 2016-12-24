@section('extra_js')
    <script src="/jQuery-Autocomplete-master/src/jquery.autocomplete.js"></script>
    <!-- Javascript -->

    <script>

        $(document).ready(function () {

            var country = "AAAA";

            $('#search').click(function () {
                $('#search_form').attr('action', "/jobs?" + "q=" + $('#keyword').val() + "&country=" + $('#country').val() + "&state=" + $('#state').val() + "&city=" + $('#city').val());
            });

            $('#keyword').autocomplete({
                serviceUrl: '/api/keywords',
                params: {},
                onSelect: function (suggestion) {
                }
            });

            $('#country').autocomplete({
                serviceUrl: '/api/countries'
            });

            $('#state').autocomplete({
                lookup: function (query, done) {

                    $.get("/api/states?query=" + query + "&country=" + $("#country").val(), function (result) {

                        done(result);
                    });

                }
            });


            $('#city').autocomplete({
                lookup: function (query, done) {

                    $.get("/api/city?query=" + query + "&state=" + $("#state").val(), function (result) {
                        done(result);
                    });

                }
            });

        });

    </script>
@stop


<form action="/jobs" id="search_form" method="POST" role="form">

    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <input type="text" id="keyword" name="title" class="form-control" placeholder="All Professionals" >
            </div>
        </div>


        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

        <div class="col-md-2">
            <div class="form-group">
                <input type="text" id="country" name="country" value="{{isset($country_geo)?$country_geo:''}}" class="form-control" placeholder="Country" >
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <input type="text" id="state" name="state" class="form-control" placeholder="State" 
                value="{{isset($state_geo)?$state_geo:''}}">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <input type="text" id="city" name="city" class="form-control" placeholder="City"
                value="{{isset($city_geo)?$city_geo:''}}">
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group">
                <div class="select-style">
                    <select class="form-control" name="category">
                        <option value="-1">All</option>
                        @foreach($categories as $category)
                            <option>{{$category->title}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <button type="submit" id="search" class="btn btn-primary btn-block"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
