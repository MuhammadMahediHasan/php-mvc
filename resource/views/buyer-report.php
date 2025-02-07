<?php startSection('content'); ?>

<div class="container mt-auto">
    <div class="row pt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Buyer Transaction Report</h5>
                </div>
                <div class="card-body">
                    <form action="" id="form">
                        <div class="row">
                            <div class="col-3 form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="col-3 form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                            <div class="col-3 form-group">
                                <label for="entry_by">Entry By</label>
                                <input type="text" placeholder="Entry By" class="form-control" id="entry_by" name="entry_by">
                            </div>
                            <div class="col-3 form-group">
                                <label for="">:</label> <br>
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

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
    $('#form').on('submit', function (e) {
        e.preventDefault();

        fetchReportData($(this).serialize());
    });
    const fetchReportData = (payload = {}) => {
        $.ajax({
            url: '/buyer-transactions/load',
            type: 'GET',
            data: payload,
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
