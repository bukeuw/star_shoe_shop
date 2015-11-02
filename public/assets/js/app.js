var FormRule = {
	loginform: {
		email: {
			required: true,
			email: true
		},
		password: {
			required: true
		}
	},

	registerform: {
		email: {
			required: true,
			email: true
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

	productform: {
		name: {
			required: true
		},
		description: {
			required: true,
			maxlength: 255
		},
		stock: {
			required: true,
			number: true,
			min: 0
		},
		unit: {
			required: true
		},
		price: {
			required: true,
			number: true,
			min: 0
		}
	},

	categoryform: {
		title: {
			required: true
		},
		parent: {
			required: true
		}
	}
};

var FormMessage = {
	loginMsg: {
		email: {
			required: 'Email tidak boleh kosong',
			email: 'Silahkan masukan email yang valid'
		},
		password: {
			required: 'Password tidak boleh kosong'
		}
	},

	registerMsg: {
		email: {
			required: 'Email tidak boleh kosong',
			email: 'Silahkan masukan email yang valid'
		},
		password: {
			required: 'Password tidak boleh kosong',
			minlength: 'Password minimal 6 karakter'
		},
		password_confirmation: {
			required: 'Silahkan konfirmasi password Anda',
			minlength: 'Konfirmasi minimal 6 karakter',
			equalTo: 'Konfirmasi password tidak sesuai'
		}
	},

	productMsg: {
		name: {
			required: 'Nama produk tidak boleh kosong'
		},
		description: {
			required: 'Keterangan produk tidak boleh kosong',
			maxlength: 'Keterangan produk maksimal 255 karakter'
		},
		stock: {
			required: 'Jumlah stok tidak boleh kosong',
			min: 'Jumlah stok minimal 0'
		},
		unit: {
			required: 'Satuan tidak boleh kosong'
		},
		price: {
			required: 'Harga tidak boleh kosong',
			min: 'Harga minimal 0'
		}
	},

	categoryMsg: {
		title: {
			required: 'Judul kategori tidak boleh kosong'
		},
		parent: {
			required: 'Induk kategori tidak boleh kosong'
		}
	}
};

function validateFormInput(form_id) {
	var validationRules = {},
		validationMessages = {};

	if(form_id === '#login-form') {
		validationRules = FormRule.loginform;
		validationMessages = FormMessage.loginMsg;
	} else if(form_id === '#register-form') {
		validationRules = FormRule.registerform;
		validationMessages = FormMessage.registerMsg;
	} else if(form_id === '#product-form') {
		validationRules = FormRule.productform;
		validationMessages = FormMessage.productMsg;
	} else if(form_id === '#category-form') {
		validationRules = FormRule.categoryform;
		validationMessages = FormMessage.categoryMsg;
	}

	$(form_id).validate({
		// errorClass and validClass has same
		// and errorElement set to span because
		// we are using bootstrap css classes
		errorClass: 'help-block',
		validClass: 'help-block',
		errorElement: 'span',

		// validation rules
		rules: validationRules,
		
		// custom validation error messages
		messages: validationMessages,

		highlight: function(element, errorClass, validClass) {
		    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},

		unhighlight: function(element, errorClass, validClass) {
		    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
		}
	});
}