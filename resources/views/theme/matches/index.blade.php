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
                        <ul class="nav nav-tabs justify-content-between" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#daily-recomodation" role="tab" data-toggle="tab">Daily Recomodation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#question-match" role="tab" data-toggle="tab">Question Match</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#just-joined" role="tab" data-toggle="tab">Just Joined</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#view-matches" role="tab" data-toggle="tab">Viewed Matches</a>
                            </li> --}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-4">
                            <div role="tabpanel" class="tab-pane fade in active show" id="daily-recomodation">
                                <ul id="daily-recomodation-list"></ul>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="question-match">
                                <ul id="question-match-list"></ul>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="just-joined">
                                <ul id="just-joined-list"></ul>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="view-matches">
                                <ul id="viewed-matches-list"></ul>
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
<script>
    $(document).ready(function() {
        getData(1, 'daily-recomodation-list');
        getData(1, 'question-match-list');
        getData(1, 'just-joined-list');
        // getData(1, 'viwed-matches-list');
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
                        htmlData += '<li>' +
                            '<a href="{{ url("profile")}}/' + value.id + '" class="match-item">' +
                                '<div class="col-12 col-md-2 match-img-container">' +
                                    '<img class="match-img" src="' + value.image + '" alt="' + value.name + '" style="width: 100px; height: 100px; object-fit: cover;">' +
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

                    // });

                }else {
                    // If no records found, display a message
                    htmlData = '<p class="text-center p-2 rounded" style="background-color: rgba(211, 211, 211, 1); color: black;" >No records found.</p>';
                }

                $('#' + section).html(htmlData);
            }
        });
    }
</script>

@endsection
