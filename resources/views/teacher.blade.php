@extends('layouts.app')

@php
$title = 'students';
@endphp

@section('custom_style')


@endsection

@section('content')
@include('layouts.top_navbar')
<div class="main-div">
    <div class="main_head1 d-flex">
        <p class="page_heading">Student Details</p>

        <button class="create_btn ms-auto add_teacher_btn">Add New
            Student</button>
    </div>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal " id="add_teacher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog student-dialog modal-l">
            <div class="modal-content">
                <p class="student_add_title">Add Teacher Details</p>

                <div class="modal-header">

                </div>

                <div class="modal-body">
                    <form id="teacher_add_form">
                        <div class="student_add_main">
                            <div class="row">
                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="name" placeholder="Teacher Name"
                                            name="name">
                                        <label for="name">Teacher Name</label>
                                        <div class="error-message" id="name_error"></div>

                                    </div>
                                </div>



                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="email" placeholder="" name="email">
                                        <label for="email">Email</label>
                                        <div class="error-message" id="email_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center password_group w-100">
                                        <input type="password" class="form-control" id="password" placeholder=""
                                            name="password">
                                        <label for="password">Password</label>
                                        <div class="error-message" id="password_error"></div>

                                    </div>
                                </div>

                            </div>

                            <div class="d-flex mt-4">
                                <div class="ms-auto">
                                    <button type="button" class="cancel_btn " data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button>
                                    <button type="submit" class="save_student_details">Save</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



</div>
@endsection

@section('custom_scripts')

<script src="{{asset('js/teacher.js') }}"></script>

@endsection