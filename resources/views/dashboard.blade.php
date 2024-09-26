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





</div>
@endsection

@section('custom_scripts')

<!-- <script src="{{asset('js/student.js') }}"></script> -->

@endsection