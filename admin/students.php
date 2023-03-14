<?php

$user = new Student();

$students = $user->findAll('ORDER BY last_name ASC');

?>

<div class="row">
    <div class="col-md-12">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title"> 
                    <i class="fas fa-users"></i> 
                    List of all students (<?= count($students) ?>)
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($students) > 0): ?>
                                    <?php foreach($students as $student): ?>
                                        <tr>
                                            <td>
                                                <?= $student->id_number ?>
                                            </td>
                                            <td>
                                                <?= $student->first_name . ' ' . $student->last_name ?>
                                            </td>
                                            <td>
                                                <?= $student->email ?>
                                            </td>
                                            <td>
                                                <?= date_create($student->created_at)->format('l, F d, Y h:i A') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No students found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>