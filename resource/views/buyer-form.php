<?php startSection('content'); ?>

<div class="container mt-auto">
    <div class="row pt-4">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h5>Buyer Transaction</h5>
                </div>
                <div class="card-body">

                    <form action="#" method="POST" id="form">
                        <div class="form-group">
                            <label for="amount">Amount (Only Numbers, Max 20 Digits)</label>
                            <input type="number" placeholder="Amount" class="form-control" id="amount" name="amount"  maxlength="20">
                            <small class="text-danger" id="amount-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="buyer">Buyer (Text, Numbers, Spaces, Max 20 Characters)</label>
                            <input type="text" placeholder="Buyer" class="form-control" id="buyer" name="buyer" pattern="[A-Za-z0-9 ]+">
                            <small class="text-danger" id="buyer-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="receipt_id">Receipt ID (Text)</label>
                            <input type="text" placeholder="Receipt ID" class="form-control" id="receipt_id" name="receipt_id" >
                            <small class="text-danger" id="receipt-id-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="items">Items (Multiple, Text)</label>
                            <select id="items" name="items"  class="form-control select2-tag" multiple="multiple">
                            </select>
<!--                            <input type="text" class="form-control" id="items" name="items" >-->
                            <small class="text-danger" id="items-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="buyer_email">Buyer Email</label>
                            <input type="email" placeholder="Buyer Email" class="form-control" id="buyer_email" name="buyer_email" >
                            <small class="text-danger" id="buyer-email-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="note">Note (Max 30 Words)</label>
                            <textarea placeholder="Note" class="form-control" id="note" name="note" rows="4" ></textarea>
                            <small class="text-danger" id="note-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" placeholder="Phone" class="form-control" id="phone" name="phone" >
                            <small class="text-danger" id="phone-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="city">City (Text, Spaces)</label>
                            <input type="text" placeholder="City" class="form-control" id="city" name="city"  pattern="[A-Za-z\s]+">
                            <small class="text-danger" id="city-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="entry_by">Entry By (Number)</label>
                            <input type="number" placeholder="Entry By" class="form-control" id="entry_by" name="entry_by" >
                            <small class="text-danger" id="entry-by-error"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php endSection(); ?>

<?php startSection('scripts'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const el = {
        'amount': $('#amount'),
        'buyer': $('#buyer'),
        'receipt_id': $('#receipt_id'),
        'items': $('#items'),
        'buyer_email': $('#buyer_email'),
        'note': $('#note'),
        'city': $('#city'),
        'phone': $('#phone'),
        'entry_by': $('#entry_by'),
        'form': $('#form'),
        'errors': $('.text-danger')
    };

    el.items.select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: 'White (only text) and hit enter',
        createTag: function({term}) {
            if (!/^[A-Za-z\s]+$/.test(term)) {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true
            };
        }
    })

    el.form.on('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        el.errors.text('').hide();
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: '/buyer-transactions/store',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function ({success, status}) {
                if (status === 201) {
                    alert('Form submitted successfully!');
                }
            },
            error: function ({status, responseJSON}) {
                if (status === 422) {
                    alert(responseJSON.message);
                    for (let field in responseJSON.errors) {
                        const errorMessage = responseJSON.errors[field];
                        $(`#${field}-error`).text(errorMessage).show();
                        $(`#${field}`).addClass('is-invalid');
                    }
                }
            }
        });
    });

    const validateForm = () => {
        let isValid = true;

        el.errors.text("");
        if (!/^\d+$/.test(el.amount.val())) {
            $('#amount-error').text("Amount must be a number.");
            isValid = false;
        }

        if (!/^[A-Za-z0-9\s]{1,20}$/.test(el.buyer.val())) {
            $('#buyer-error').text("Buyer must be text, spaces, or numbers (max 20 characters).");
            isValid = false;
        }

        if (!/^[A-Za-z]+$/.test(el.receipt_id.val())) {
            $('#receipt-id-error').text("Receipt ID must contain only letters.");
            isValid = false;
        }

        const items = el.items.val();
        items.forEach(v => {
            if (!/^[A-Za-z\s,]+$/.test(v)) {
                $('#items-error').text("Items must contain only text (comma-separated).");
                isValid = false;
            }
        })

        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(el.buyer_email.val())) {
            $('#buyer-email-error').text("Invalid email format.");
            isValid = false;
        }


        if (!el.note.val()) {
            $('#note-error').text("Note Field is required.");
            isValid = false;
        }

        if (el.note.val().split(/\s+/).length > 30) {
            $('#note-error').text("Note cannot exceed 30 words.");
            isValid = false;
        }

        if (!/^[A-Za-z\s]+$/.test(el.city.val())) {
            $('#city-error').text("City must contain only text and spaces.");
            isValid = false;
        }

        if (!/^\d+$/.test(el.phone.val()) || el.phone.val().length < 11 || el.phone.val().length > 13) {
            console.log(!/^\d+$/.test(el.phone.val()), el.phone.val().length < 11, el.phone.val().length > 13)
            $('#phone-error').text("Phone must contain only valid number.");
            isValid = false;
        } else {
            let phone = el.phone.val();
            if (!phone.startsWith("880")) {
                phone = `880${Number(phone)}`;
                el.phone.val(phone);
            }
        }

        if (!/^\d+$/.test(el.entry_by.val())) {
            $('#entry-by-error').text("Entry By must contain only numbers.");
            isValid = false;
        }

        return isValid;
    }
</script>

<?php endSection(); ?>

<?php require_once view('layout/layout.php'); ?>
