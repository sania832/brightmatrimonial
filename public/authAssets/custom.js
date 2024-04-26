// AJAX RUN
var runAjax = function (i = null, ii = null, type = 'POST') {
    return new Promise(function(resolve, reject) {
        if (!i) {
            // console.log('Empty URL provided. Aborting Ajax request.');
            reject('Empty URL provided.');
            return;
        }

        // console.log('Preparing Ajax request...');
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
                // console.log('Ajax request successful. Response received:', response);
                // console.log('Response status code:', response.status);
                console.log('Response message:', response.message);
                resolve(response);
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed. Status:', status, 'Error:', error);
                reject(new Error('Error: ' + error));
            }
        });
    });
};

// LOGIN
function loginUser(){
	var data = new FormData();
	data.append('email', $('.ai-signin #email').val());
	data.append('password', $('.ai-signin #password').val());

	runAjax(SITE_URL +'/loginUser', data).then(function (value) {
        if (value.status === '200') {
            // request was successful
            swal.fire({
				title: 'Success!',
				text: 'You are Logged in.',
				type: 'success',
				// Pass the jQuery object to the swal.fire method
				onClose: function() {
                    window.location.href = SITE_URL +'/admin';
				}
			});
        } else if (value.status === '422') {
            // there was an error with the data
            console.log('The status is:', value.status);
            $('.validation-div').text('');
            $.each(value.error, function (index, value) {
                $('.val-' + index).text(value);
            });
        } else if (value.status === '201') {
            // the user was already registered
            $('.validation-div').text('');
            swal.fire({ title: value.message, type: 'error' });
        } else if (value.status === '402') {
            // handle a 402 error
            $('.validation-div').text('');
            swal.fire({ title: value.message, type: 'warning' });
        } else {
            // handle any other status codes
            $('.validation-div').text('');
            swal.fire({ title: value.message, type: 'error' });
        }
    }).catch(function (error) {
        console.log('An error occurred:', error);
    });
}

// REGISTRATION
function registerUsers(){
	var data = new FormData();
	data.append('first_name', $('.ai-signup #first_name').val());
	data.append('last_name', $('.ai-signup #last_name').val());
	data.append('email', $('.ai-signup #email').val());
	data.append('country_code', $('.ai-signup #country_code').val());
	data.append('phone_number', $('.ai-signup #phone_number').val());
	data.append('profile_for', $('.ai-signup #profile_for').val());
	data.append('gender', $('.ai-signup #gender').val());
	data.append('password', $('.ai-signup #password').val());
	data.append('day', $('.ai-signup #day').val());
	data.append('month', $('.ai-signup #month').val());
	data.append('year', $('.ai-signup #year').val());
	data.append('password_confirmation', $('.ai-signup #password_confirmation').val());
		console.log("Data to be sent:");
	for (const [key, value] of data.entries()) {
		console.log(key + ": " + value);
	}
	var response = runAjax(SITE_URL +'/registerUser', data);
	    if (response) { // check if the response is defined
        response.then(function (value) { // process the response using a Promise
            if (value.status === '200') {
                // request was successful
                swal.fire({
					title: 'Success!',
					text: 'Registration successfully.',
					type: 'success',
					// Pass the jQuery object to the swal.fire method
					onClose: function() {
						window.location.href = SITE_URL +'/';
					}
				});
            } else if (value.status === '422') {
                // there was an error with the data
                console.log('The status is:', value.status);
                $('.validation-div').text('');
                $.each(value.error, function (index, value) {
                    $('.val-' + index).text(value);
                });
            } else if (value.status === '201') {
                // the user was already registered
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            } else if (value.status === '402') {
                // handle a 402 error
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'warning' });
            } else {
                // handle any other status codes
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            }
        }).catch(function (error) { // handle any errors that occur
            console.log('An error occurred:', error);
        });
    }
}

//partner preference
function partnerPreference(){
    console.log('nvjnsdjnvj');
	var data = new FormData();
	data.append('looking_for', $('.ai-signup #looking_for').val());
	data.append('from_age', $('.ai-signup #from_age').val());
	data.append('to_age', $('.ai-signup #to_age').val());
	data.append('religion', $('.ai-signup #religion').val());
	data.append('mother_tounge', $('.ai-signup #mother_tounge').val());

    console.log("Data to be sent:");
	for (const [key, value] of data.entries()) {
		console.log(key + ": " + value);
	}
	var response = runAjax(SITE_URL +'/save-partner-preference', data);
	    if (response) { // check if the response is defined
        response.then(function (value) { // process the response using a Promise
            if (value.status === '200') {
                // request was successful
                swal.fire({
					title: 'Success!',
					text: 'Successfully Saved.',
					type: 'success',
					// Pass the jQuery object to the swal.fire method
					onClose: function() {
						window.location.href = SITE_URL +'/';
					}
				});
            } else if (value.status === '422') {
                // there was an error with the data
                console.log('The status is:', value.status);
                $('.validation-div').text('');
                $.each(value.error, function (index, value) {
                    $('.val-' + index).text(value);
                });
                swal.fire({ title: value.message, type: 'error' });
                console.log('error');
            } else if (value.status === '201') {
                // the user was already registered
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            } else if (value.status === '402') {
                // handle a 402 error
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'warning' });
            } else {
                // handle any other status codes
                $('.validation-div').text('');
                swal.fire({ title: value.message, type: 'error' });
            }
        }).catch(function (error) { // handle any errors that occur
            console.log('An error occurred:', error);
        });
    }
}
