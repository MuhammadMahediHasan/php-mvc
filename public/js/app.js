
$('#form').on('submit', function (e) {
	e.preventDefault();

	$('.text-danger').text('').hide();
	$('.form-control').removeClass('is-invalid');

	$.ajax({
		url: '/buyer-transactions/store',
		type: 'POST',
		data: $(this).serialize(),
		dataType: 'json',
		success: function (response) {
			if (response.success) {
				alert('Form submitted successfully!');
			} else if (response.errors) {
				// Display error messages from the backend
				for (let field in response.errors) {
					const errorMessage = response.errors[field];
					$(`#${field}-error`).text(errorMessage).show();
					$(`#${field}`).addClass('is-invalid');
				}
			}
		},
		error: function (xhr, status, error) {
			console.error('Request failed: ', error);
		}
	});
});