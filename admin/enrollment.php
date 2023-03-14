<?php

$student = new Student();
$enrollment = new Enrollment();
$transaction = new Transaction();

$enrollment_id = Input::get('id');

if(!$enrollment->find(Input::get('id')) || !$enrollment_id){
    echo '<script>window.location.history.back()</script>';
}

$enroll = $enrollment->find($enrollment_id);

$student = $student->get($enroll->student_id)->first();

$transactions = $transaction->findAll('WHERE enrollment_id = ' . $enrollment_id. ' ORDER BY created_at DESC');

$total_paid = 0;
foreach($transactions as $t){
    $total_paid += $t->amount;
}

$balance = $enroll->tuition - $total_paid;

if(Input::exists()){
    try{
        $transaction->create([
            'enrollment_id' => $enrollment_id,
            'amount' => Input::get('amount'),
            'reference_id' => rand(1000000000, 9999999999)
        ]);
        Session::flash('success', 'Payment added successfully!');
        echo '<script>window.location.href = "?page=enrollment&id=' . $enrollment_id . '"</script>';
    }catch(Exception $e){
        Session::flash('error', $e->getMessage());
    }
}

// H::dnd($transaction, true);

?>

<div class="row">
    <div class="col-md-12">

        <div class="card shadow">

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 text-uppercase fw-bold">
                            <i class="fas fa-user me-2"></i> <?= $student->first_name . ' ' . $student->last_name ?>

                            <?php if($balance > 0): ?>
                            <span class="badge bg-danger text-light badge-lg">
                                Balance: ₱   <?= number_format($balance, 2) ?>
                            </span>
                            <?php else: ?>
                            <span class="badge bg-success text-light badge-lg">
                                Paid: ₱   <?= number_format($enroll->tuition, 2) ?>
                            </span>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="d-flex">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pay">
                            <i class="fas fa-plus me-2"></i> Add Payment
                        </button>

                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_number" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="id_number" value="<?= $student->id_number ?>"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <input type="text" class="form-control" id="course" value="<?= $enroll->course ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="year_level" class="form-label">Year Level</label>
                            <input type="text" class="form-control" id="year_level" value="<?= $enroll->year_level ?>"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="school_year" class="form-label">School Year</label>
                            <input type="text" class="form-control" id="school_year" value="<?= $enroll->school_year ?>"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="session" class="form-label">Session</label>
                            <input type="text" class="form-control" id="session" value="<?= $enroll->session ?>"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tuition" class="form-label">Tuition</label>
                            <input type="text" class="form-control" id="tuition" value="₱ <?= number_format($enroll->tuition, 2) ?>"
                                disabled>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-money-bill-wave"></i> Transaction History (<?= count($transactions) ?>)
                </h4>
            </div>
            <div class="card-body">
                <?php if(count($transactions) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Reference ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($transactions) > 0): ?>
                            <?php foreach($transactions as $transaction): ?>
                            <tr>
                                <td><?= $transaction->reference_id ?></td>
                                <td><?= date_create($transaction->created_at)->format('l, F d, Y h:i A') ?></td>
                                <td>₱ <?= number_format($transaction->amount, 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No transaction history</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">
                    No transaction history
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="enroll-studentLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="enroll-studentLabel">
                    Pay
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 mt-3">
                            <label>Amount to Pay</label>
                            <input type="number" name="amount" required class="form-control" placeholder="₱ 0.00">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="enroll-student">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>