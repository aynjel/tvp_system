<?php

$student = new Student();

$students = $student->findAll();

?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-students"></i> Master List Records (<?= count($students) ?>)
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($students) > 0): ?>
                            <?php foreach($students as $e): ?>
                                <tr>
                                    <td>
                                        <?= $e->id_number ?>
                                    </td>
                                    <td><?= $e->first_name . ' ' . $e->last_name ?></td>
                                    <td>
                                    <a class="btn btn-info text-light btn-sm" href="?page=student&id=<?= $e->id ?>">
                                        View
                                    </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>