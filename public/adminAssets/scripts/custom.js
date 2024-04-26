$(document).ready(function(e) {
	$(".form-control-file").change(function () {
		var preview = $(this).attr("data-att-preview");
		readURL(this, preview);
	});
});

function readURL(input, preview) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			jQuery('#'+preview).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

var adminAjax = function (i = null, ii = null, type = 'POST') {
    console.log(ii);
    return new Promise(function(resolve, reject) {
        if (!i) {
            console.log('Empty URL provided. Aborting Ajax request.');
            reject('Empty URL provided.');
            return;
        }

        console.log('Preparing Ajax request...');
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
                console.log('Ajax request successful. Response received:', response);
                console.log('Response status code:', response.status);
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
