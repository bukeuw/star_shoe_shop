$('document').ready(function() {
	$('form').validate({
		// errorClass and validClass has same
		// and errorElement set to span because
		// we are using bootstrap css classes
		errorClass: 'help-block',
		validClass: 'help-block',
		errorElement: 'span',
		// validation rules
		rules: {
			name: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			password: {
				required: true,
				minlength: 6
			},
			password_confirmation: {
				required: true,
				minlength: 6,
				equalTo: '#password'
			}
		},
		// custom validation error messages
		messages: {
			name: {
				required: 'Nama harus diisi',
			},
			email: {
				required: 'Email harus diisi',
				email: 'Silahkan masukan email yang valid',
			},
			password: {
				required: 'Password harus diisi',
				minlength: 'Password tidak boleh kurang dari 6 karakter'
			},
			password_confirmation: {
				required: 'Silahkan konfirmasi password anda',
				minlength: 'konfirmasi password tidak boleh kurang dari 6 karakter',
				equalTo: 'Konfirmasi password tidak sesuai'
			}
		},
		highlight: function(element, errorClass, validClass) {
		    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
		    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
		}
	})
});