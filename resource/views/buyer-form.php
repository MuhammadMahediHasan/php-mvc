<?php include_once view('layout/header.php') ?>

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
                            <input type="number" class="form-control" id="amount" name="amount" required maxlength="20">
                            <small class="text-danger" id="amount-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="buyer">Buyer (Text, Numbers, Spaces, Max 20 Characters)</label>
                            <input type="text" class="form-control" id="buyer" name="buyer" required maxlength="20" pattern="[A-Za-z0-9 ]+">
                            <small class="text-danger" id="buyer-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="receipt_id">Receipt ID (Text)</label>
                            <input type="text" class="form-control" id="receipt_id" name="receipt_id" required>
                            <small class="text-danger" id="receipt-id-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="items">Items (Multiple, Text)</label>
                            <input type="text" class="form-control" id="items" name="items" required>
                            <small class="text-danger" id="items-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="buyer_email">Buyer Email</label>
                            <input type="email" class="form-control" id="buyer_email" name="buyer_email" required>
                            <small class="text-danger" id="buyer-email-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="note">Note (Max 30 Words)</label>
                            <textarea class="form-control" id="note" name="note" rows="4" required></textarea>
                            <small class="text-danger" id="note-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <small class="text-danger" id="phone-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="city">City (Text, Spaces)</label>
                            <input type="text" class="form-control" id="city" name="city" required pattern="[A-Za-z\s]+">
                            <small class="text-danger" id="city-error"></small>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once view('layout/footer.php') ?>
