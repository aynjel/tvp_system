<?php

$get_student = new Student();
$enroll = new Enrollment();
$transaction = new Transaction();

$id = Input::get('id');

if(!isset($_GET['id']) || !$get_student->find($id)){
    Redirect::to('?page=dashboard');
}

if(Input::exists()){
    try{
        $enroll->create([
            'student_id' => Input::get('student_id'),
            'school_year' => Input::get('school_year'),
            'session' => Input::get('session'),
            'tuition' => Input::get('tuition'),
            'course' => Input::get('course'),
            'year_level' => Input::get('year_level')
        ]);
        Session::flash('success', 'Student enrolled successfully!');
        echo '<script>window.location.href = "?page=student&id=' . $id . '"</script>';
    }catch(Exception $e){
        Session::flash('error', $e->getMessage());
    }
}

$student = $get_student->find($id);

$enrollments = $enroll->findAll('WHERE student_id = ' . $student->id . ' ORDER BY school_year DESC');

?>

<div class="row">
    <div class="col-md-12">

        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 text-uppercase fw-bold">
                            <i class="fas fa-user me-2"></i> <?= $student->first_name . ' ' . $student->last_name ?>
                        </h4>
                    </div>
                    <div class="d-flex">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#enroll-student">
                            <i class="fas fa-plus"></i> Enroll Student
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">
                    Enrollment Record
                </h4>
            </div>
            <div class="card-body">
                <?php if(count($enrollments) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">School Year</th>
                                <th scope="col">Session</th>
                                <th scope="col">Year Level</th>
                                <th scope="col">Course</th>
                                <th scope="col">Tuition</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Date Enrolled</th>
                                <th scope="col">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($enrollments as $e): ?>
                            <tr>
                                <td><?= $e->school_year ?></td>
                                <td><?= $e->session ?></td>
                                <td><?= $e->year_level ?></td>
                                <td><?= $e->course ?></td>
                                <td>₱ <?= number_format($e->tuition, 2) ?></td>
                                <td>₱ <?= number_format($transaction->getBalance($e->id), 2) ?></td>
                                <td><?= date('F d, Y', strtotime($e->created_at)) ?></td>
                                <td>
                                    <?php if($transaction->getBalance($e->id) > 0): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    <?php else: ?>
                                    <span class="badge bg-success">Paid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="?page=enrollment&id=<?= $e->id ?>">View</a></li>
                                            <li><a class="dropdown-item" href="?page=delete-enrollment&id=<?= $e->id ?>&student_id=<?= $student->id ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">
                    No records found.
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="enroll-student" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="enroll-studentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="enroll-studentLabel">
                    Enroll Student
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12" style="display: none;">
                            <input type="hidden" name="student_id" value="<?= $student->id ?>">
                        </div>

                        <div class="col-md-6 mt-3">
                            <select name="school_year" required class="form-control">
                                <option selected hidden disabled value="">Select School Year</option>
                                <?php 
                                        $current_year = date('Y');
                                        $next_year = $current_year + 1;
                                        $school_year = $current_year . '-' . $next_year;

                                        foreach(range(0, 5) as $year) {
                                            $school_year = $current_year . '-' . $next_year;
                                            echo "<option value='$school_year'>$school_year</option>";
                                            $current_year++;
                                            $next_year++;
                                        }
                                    ?>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <select name="session" required class="form-control">
                                <option selected hidden disabled value="">Select Semester</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <select name="course" required class="form-control">
                                <option selected hidden disabled value="">Select Course</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BPED">BPED</option>
                                <option value="BEED">BEED</option>
                                <option value="BSED">BSED</option>
                                <option value="BSENTREP">BSENTREP</option>
                                <option value="BSHM">BSHM</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <select name="year_level" required class="form-control">
                                <option selected hidden disabled value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>Tuition</label>
                            <input type="number" name="tuition" required class="form-control" placeholder="₱ 0.00">
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