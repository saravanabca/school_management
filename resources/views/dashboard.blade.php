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

        <button class="create_btn ms-auto add_student_btn">Add New
            Student</button>
    </div>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Department</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal " id="add_student" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog student-dialog modal-l">
            <div class="modal-content">
                <p class="student_add_title">Add student Details</p>

                <div class="modal-header">

                </div>

                <div class="modal-body">
                    <form id="student_add_form">
                        <div class="student_add_main">
                            <div class="row">
                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="first_name" placeholder="first Name"
                                            name="first_name">
                                        <label for="first_name">First Name</label>
                                        <div class="error-message" id="first_name_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="last_name" placeholder=""
                                            name="last_name">
                                        <label for="last_name">Last Name</label>
                                        <div class="error-message" id="last_name_error"></div>

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
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="mobile" placeholder=""
                                            name="mobile">
                                        <label for="mobile">Mobile</label>
                                        <div class="error-message" id="mobile_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">

                                    <textarea row="40" cols="40" class="form-control w-100" id="address" name="address"
                                        placeholder="Address"></textarea>
                                    <!-- <label for="address">Address</label> -->
                                    <div class="error-message" id="address_error"></div>

                                </div>


                                <div class="col col-md-12 mt-4">
                                    <select name="status" class="form-control" id="status">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="error-message" id="status_error"></div>

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

<!-- <script src="{{asset('js/student.js') }}"></script> -->

@endsection