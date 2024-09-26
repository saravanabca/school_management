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

        <button class="create_btn ms-auto add_homework_btn">Add New
            Student</button>
    </div>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal " id="add_homework" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog student-dialog modal-l">
            <div class="modal-content">
                <p class="student_add_title">Add Homework Details</p>

                <div class="modal-header">

                </div>

                <div class="modal-body">
                    <form id="homework_add_form">
                        <div class="student_add_main">
                            <div class="row">
                                <div class="col col-md-12 mt-4">
                                    <select name="student_id" class="form-control" id="student_id">
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="student_id_error"></div>
                                </div>



                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="title" placeholder="" name="title">
                                        <label for="title">Title</label>
                                        <div class="error-message" id="title_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <textarea row="40" cols="40" class="form-control w-100" id="description"
                                        name="description" placeholder="description"></textarea>
                                    <div class="error-message" id="description_error"></div>

                                </div>

                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating text-center w-100">
                                        <input type="date" class="form-control" id="due_date" placeholder=""
                                            name="due_date">
                                        <label for="due_date">Due Date</label>
                                        <div class="error-message" id="due_date_error"></div>

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

<script src="{{asset('js/homework.js') }}"></script>

@endsection