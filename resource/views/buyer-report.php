<?php include_once view('layout/header.php') ?>

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
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once view('layout/footer.php') ?>
