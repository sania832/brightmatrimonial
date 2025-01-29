@extends('layouts.theme.master')

@section('content')
		<main>
		<section class="match-banner">
			<img class="match-banner-img" src="{{ asset('themeAssets/images/hero-banner.jpg') }}" alt="">
		</section>
		<section class="match-list common-padding common-bg-pattern">
			<div class="container">
                <div class="row">
                    <div class="col-12 match-tab">
                        <!-- Tab panes -->
                        <div class="tab-content mt-4" id="interestTabs">
                            <div role="tabpanel" id="interest-send-list">
                                <ul id="viwed-matches-list">
                                    @if(!empty($data))
                                        @foreach ($data as $key => $value )
                                        <li>
                                            <a href="{{ route('userProfile',['id' => $value['id']]) }}" class="match-item">
                                                <div class="col-12 col-md-2 match-img-container">
                                                    <img class="match-img" src="{{ $value['image'] ? $value['image'] : 'default/default-user.jpg' }}" alt="{{ $value['name'] ? $value['name'] : '' }}" style="width: 100px; height: 100px; object-fit: cover;">
                                                </div>
                                                <div class="match-info-container col-12 col-md-10">
                                                    <div class="match-info">
                                                        <h2>{{ $value['name'] ? $value['name'] : '' }}</h2>
                                                        <p class="match-id">Profile ID : BG{{ $value['id'] ? $value['id'] : '' }}</p>
                                                        <img class="match-info-img" src="/themeAssets/images/title-border.svg" alt="">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['age'] }}</p></div>
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['city'] }}</p></div>
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['height'] }}</p></div>
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['state'] }}</p></div>
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['marital_status'] }}</p></div>
                                                            <div class="col-sm-12 col-md-6"><p>{{ $value['income'] }}</p></div>
                                                            {{-- <div class="col-sm-12"><p>{{ $value['occupation'] }}</p></div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                    @else
                                        <p class="text-center p-2 rounded" style="background-color: rgba(211, 211, 211, 1); color: black;" >No records found.</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
	</main>
    <!-- /main -->
@endsection

@section('js')
{{-- <script>
    $(document).ready(function() {
        getData(1, 'viwed-matches-list');
    });

    // GET LIST
    function getData(page = 1, section = '') {
        var data = new FormData();
        data.append('page', page);
        data.append('count', 10);
        data.append('section', section);

        // Assuming 'response' is a Promise object
        var response = runAjax(SITE_URL + '/get_matches', data);

        console.log(response);

        // Process the response using a Promise
        response.then(function(value) {
            if (value.status == '200') {
                var htmlData = '';
                $('#' + section).empty();
                if (value.data.length > 0) {
                    $.each(value.data, function(index, value) {
                        var defaultImagePath = '{{ url('') }}' + '/images/default_user.jpg'; // Path to the default image within your assets

                        var imageUrl = (value.image && /\.(?:jpg|jpeg|png|gif)$/.test(value.image)) ? value.image : defaultImagePath;
                        var altText = value.name || '';

                        var imageElement = '<img class="match-img" src="' + imageUrl + '" alt="' + altText + '" style="width: 100px; height: 100px; object-fit: cover;">';

                        htmlData += '<li>' +
                            '<a href="{{ url("profile")}}/' + value.id + '" class="match-item">' +
                                '<div class="col-12 col-md-2 match-img-container">' +
                                    imageElement +
                                '</div>' +
                                '<div class="match-info-container col-12 col-md-10">' +
                                    '<div class="match-info">' +
                                        '<h2>' + (value.name ? value.name : '') + '</h2>' +
                                        '<p class="match-id">Profile ID : BG' + (value.id ? value.id : '') + '</p>' +
                                        '<img class="match-info-img" src="{{ asset("themeAssets/images/title-border.svg") }}" alt="">' +
                                        '<div class="row">' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.age + '</p></div>' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.city + '</p></div>' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.height + '</p></div>' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.state + '</p></div>' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.marital_status + '</p></div>' +
                                            '<div class="col-sm-12 col-md-6"><p>' + value.income + '</p></div>' +
                                            // '<div class="col-sm-12"><p>' + value.occupation + '</p></div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</a>' +
                        '</li>';
                    });
                }else {
                    // If no records found, display a message
                    htmlData = '<p class="text-center p-2 rounded" style="background-color: rgba(211, 211, 211, 1); color: black;" >No records found.</p>';
                }
			$('#search-list').html(htmlData);
            }
        });
    }
</script> --}}

@endsection
