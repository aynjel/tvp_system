<?php

$enroll = new Enrollment();

$student_id = Input::get('student_id');
$id = Input::get('id');

if(!isset($_GET['id']) || !$enroll->find($id)){
    Redirect::to('?page=dashboard');
}

try{
    $enroll->delete($id);

    Session::flash('success', 'Enrollment deleted successfully!');
    echo '<script>window.location.href = "?page=student&id=' . $student_id . '"</script>';
}catch(Exception $e){
    Session::flash('error', $e->getMessage());
}
