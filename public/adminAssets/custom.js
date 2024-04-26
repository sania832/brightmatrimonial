$(document).ready(function(e) {
	$("#image").change(function () {
		readURL(this, 'image-src');
	});
});

function readURL(input, id) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			jQuery('#'+id).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

var adminAjax = (function (i = null, ii = null, type = 'POST'){
	if(i == ''){ return; }
	ii.append('visit_from', 'web');
	var ob = jQuery.ajax({
		url: i,
		type: type,
		enctype: 'multipart/form-data',
		contentType: 'application/json; charset=UTF-8',
		processData: false,
		contentType: false,
		data: ii,
		cache: false,
		async: false,
		success: function (response) {
		},
	}).responseText;
	return jQuery.parseJSON(ob);
});
