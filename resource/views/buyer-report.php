<?php startSection('content'); ?>

<div class="container mt-auto">
    <div class="row pt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Buyer Transaction Report</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Buyer</th>
                                    <th>Receipt ID</th>
                                    <th>Items</th>
                                    <th>Buyer Email</th>
                                    <th>Note</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php endSection(); ?>

<?php startSection('scripts'); ?>

<script>
    const fetchReportData = () => {
        $.ajax({
            url: '/buyer-transactions/load',
            type: 'GET',
            data: $('#search-form').serialize(),
            dataType: 'json',
            success: function ({data, status}) {
                $('table > tbody').empty();
                data.forEach((v) => {
                    $('table > tbody').append(`
                        <tr>
                            <td>${v.amount}</td>
                            <td>${v.buyer}</td>
                            <td>${v.receipt_id}</td>
                            <td>${v.items}</td>
                            <td>${v.buyer_email}</td>
                            <td>${v.note}</td>
                            <td>${v.phone}</td>
                            <td>${v.city}</td>
                        </tr>
                    `);
                });
            },
            error: function (xhr, status, error) {
                console.error('Request failed: ', error);
            }
        });
    };
    fetchReportData();
</script>

<?php endSection(); ?>

<?php require_once view('layout/layout.php'); ?>
