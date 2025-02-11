$(document).ready(function(e) {
	$(".input-file").change(function () {
		var preview = $(this).attr("data-att-preview");
		readURL(this, preview);
	});

	// Add To Cart Box
	$('.modal_dialog').click(function(){
		$('#item_id').val($(this).attr('data-att-id'));
		$('#modal_dialog-title').text($(this).attr('data-att-title'));
	});

	// SELECT LANGUAGE
	$(".close-box").click(function () {
		$('.mfp-close').trigger('click');
	});
});

// AJAX RUN
var runAjax = function (i = null, ii = null, type = 'POST') {
    return new Promise(function(resolve, reject) {
        if (!i) {
            reject('Empty URL provided.');
            return;
        }

        ii.append('visit_from', 'web');
        ii.append('_token', token);

        jQuery.ajax({
            url: i,
            type: type,
            enctype: 'multipart/form-data',
            contentType: 'application/json; charset=UTF-8',
            processData: false,
            contentType: false,
            data: ii,
            cache: false,
            success: function (response) {
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject(new Error('Error: ' + error));
            }
        });
    });
};

// Update Profile
async function updateProfile (step = 1) {
	console.log('update profile', step)
	
	var data = new FormData();
	data.append('step', step === 'alfa'? step : parseInt(step));
	data.append('first_name', $('#completeProfile #first_name').val());
	data.append('last_name', $('#completeProfile #last_name').val());
	data.append('day', $('#completeProfile #day').val());
	data.append('month', $('#completeProfile #month').val());
	data.append('year', $('#completeProfile #year').val());
	data.append('religion', $('#completeProfile #religion').val());
	// data.append('community', $('#completeProfile #community').val());
	data.append('mother_tongue', $('#completeProfile #mother_tongue').val());

	data.append('city', $('#completeProfile #city').val());
	data.append('state', $('#completeProfile #state').val());
	if($('input[type="radio"][name="live_with_family"]:checked').is(':checked')) { data.append('live_with_family', $('input[type="radio"][name="live_with_family"]:checked').val()); }
	data.append('marital_status', $('#completeProfile #marital_status').val());
	//data.append('diet', $('#completeProfile #diet').val());
    var selectedDiet = $('input[type="radio"][name="diet"]:checked').val();
    if (selectedDiet) { data.append('diet', selectedDiet); }
	// if($('input[type="radio"][name="diet"]:checked').is(':checked')) { data.append('diet', $('input[type="radio"][name="diet"]:radio').val()); }
	data.append('height', $('#completeProfile #height').val());
	data.append('weight', $('#completeProfile #weight').val());
	//data.append('horoscope_require', $('#completeProfile #horoscope_require').val());
	if($('input[type="radio"][name="horoscope_require"]:checked').is(':checked')) { data.append('horoscope_require', $('input[type="radio"][name="horoscope_require"]:checked').val()); }
	//data.append('manglik', $('#completeProfile #manglik').val());
	if($('input[type="radio"][name="manglik"]:checked').is(':checked')) { data.append('manglik', $('input[type="radio"][name="manglik"]:checked').val()); }

	// step 2
	data.append('highest_qualification', $('#completeProfile #highest_qualification').val());
	data.append('company_name', $('#completeProfile #company_name').val());
	data.append('position', $('#completeProfile #position').val());
	var incomeType = $('#income_type').is(':checked') ? 'Monthly' : 'Yearly';    data.append('income_type', incomeType);
	data.append('income', $('#completeProfile #income').val());

	// step 3
	data.append('cast', $('#completeProfile #cast').val());
	data.append('family_type', $('#completeProfile #family_type').val());
	data.append('father_occupation', $('#completeProfile #father_occupation').val());
	data.append('mother_occupation', $('#completeProfile #mother_occupation').val());
	data.append('number_of_siblings', $('#completeProfile #number_of_siblings').val());
	// step 4
	data.append('smoking_habits', $('#completeProfile #smoking_habits').val());
    data.append('drinking_habits', $('#completeProfile #drinking_habits').val());
	data.append('open_to_pets', $('#completeProfile #open_to_pets').val());
	data.append('languages_spoken', $('#completeProfile #languages_spoken').val());
	// step 5
	data.append('place_of_birth', $('#completeProfile #place_of_birth').val());
	data.append('date_of_birth', $('#completeProfile #date_of_birth').val());
	data.append('time_of_birth', $('completeProfile #time_of_birth').val());
	data.append('zodiac_sign', $('#completeProfile #zodiac_sign').val());
	data.append('horoscope_match', $('#completeProfile #horoscope_match').val());
	data.append('manglik_dosha', $('#completeProfile #manglik_dosha').val());
	// step 6
	data.append('hobbies', $('#completeProfile #hobbies').val());
    data.append('favorite_music', $('#completeProfile #favorite_music').val());
	data.append('favorite_books', $('#completeProfile #favorite_books').val());
	data.append('favorite_movies', $('#completeProfile #favorite_movies').val());
	data.append('favorite_sports', $('#completeProfile #favorite_sports').val());
	// step 7
	data.append('partner_age_range', $('#completeProfile #min_age').val()+'-'+$('#completeProfile #max_age').val());
	data.append('relation_type', $('#completeProfile #relation_type').val());
	data.append('partner_religion', $('#completeProfile #partner_religion').val());
	data.append('partner_mother_tongue', $('#completeProfile #partner_mother_tongue').val());
	data.append('partner_diet_preferences', $('#completeProfile #partner_diet_preferences').val());
	data.append('partner_state_living_in', $('#completeProfile #partner_state_living_in').val());	
	data.append('partner_city_living_in', $('#completeProfile #partner_city_living_in').val());	
	data.append('partner_qualifications', $('#completeProfile #partner_qualifications').val());	
	data.append('partner_income', $('#completeProfile #partner_income').val());	

	if($('input[type="radio"][name="brother"]:checked').is(':checked')) { data.append('brother', $('input[type="radio"][name="brother"]:checked').val()); }
	if($('input[type="radio"][name="sister"]:checked').is(':checked')) { data.append('sister', $('input[type="radio"][name="sister"]:checked').val()); }
	data.append('family_living_in', $('#completeProfile #family_living_in').val());
	data.append('family_bio', $('#completeProfile #family_bio').val());
	data.append('address', $('#completeProfile #family_address').val());
	data.append('contact_no', $('#completeProfile #family_contact_no').val());

	data.append('about', $('#completeProfile #about').val());
	data.append('country_code', $('#completeProfile #country_code').val());
	data.append('mobile_no', $('#completeProfile #mobile_no').val());

	data.append('otp', $('#completeProfile #otp').val());

	if(step == 'alfa'){
		data.append('profile_photo', $('#filiUpload')[0].files[0]);
		data.append('cover_photo', $('#filiUpload2')[0].files[0]);
	}
	if(step == 9){
		var document_type = $('.document_type.active').attr('data-document-type');
		data.append('document_type', document_type);
		data.append('document_number', $('#document_number'+document_type).val());
		data.append('document', $('#fileDocument'+document_type)[0].files[0]);
	}
	console.log('Completed Profile Body : ', data.values);
	var response = runAjax(SITE_URL +'/completeProfile', data);
	console.log('Response LLL ', response)
	if (response) { // check if the response is defined
        response.then(function (value) { // process the response using a Promise
            if (value.status === '200') {
				if(step == 'alfa'){
					window.location.href = SITE_URL + '/profile';
				}else{
					var nextStep = parseInt(step) + 1;
					var nextUrl = SITE_URL + '/complete-profile/' + nextStep;
					window.location.href = nextUrl; // Redirect to the next step
				}
            } else if (value.status === '422') {
                // there was an error with the data
                $('.validation-div').text('');
                $.each(value.error, function (index, value) {
                    $('.val-' + index).text(value);
                });
            } else if (value.status === '201') {
                // the user was already registered
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            }else {
                // handle any other status codes
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            }
        }).catch(function (error) { // handle any errors that occur
			console.log('error', error);
            $('.validation-div').text('');
            swal.fire({ title: 'An error occurred while submitting the form. Please try again.', type: 'error' });
            // Enable the submit button
            submitButton.prop('disabled', false);
        });
    }
}


// Create Order
function createOrder(plan_id){
	var package_id = $('#planList-'+ plan_id +' input[name="flexRadioDefault"]:checked').is(':checked') ? $('#planList-'+ plan_id +' input[name="flexRadioDefault"]:checked').val() : '';
	var data = new FormData();
	data.append('plan_id', plan_id);
	data.append('package_id', package_id);
	var response = runAjax(SITE_URL +'/create-order', data);
	if(response.success == '1'){

		openRazorpay(response.data);
		//swal.fire({ type: 'success', title: response.message, showConfirmButton: false, timer: 1500 });
		//setTimeout(function(){ window.location.assign(SITE_URL +'/payment-order'); }, 2000);
	}else if(response.status == '201'){
		swal.fire({ type: 'error', title: response.message});
	}
}
