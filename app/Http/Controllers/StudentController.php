<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department; 
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function student()
    {
        return view('student');
    }


    public function student_add(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|regex:/^[0-9]{10}$/|unique:students,mobile,',
                'email' => 'required|email|unique:students,email',
                'address' => 'required|string',
                'department_id' => 'required|exists:departments,id', 
                'status' => 'required|boolean'
            ]);

            $studentData = $request->all();
            $student = new Student();
            $student->fill($studentData);
            $student->save();

            return response()->json([
                'status' => 'student_add_success',
                'status_value' => true,
                'message' => 'Student Created Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_value' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function student_update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|regex:/^[0-9]{10}$/|unique:students,mobile,' . $id,
            'email' => 'required|email|unique:students,email,' . $id, 
            'address' => 'required',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|boolean',
        ]);
    
        // Find the student by id and update their information
        $student = Student::findOrFail($id);
        $student->fill($request->all());
        $student->save();
    
        return response()->json([
          'status' => 'student_update_success',
          'status_value' => true,
          'message' => 'Student Created Successfully'
      ]);
    }
    

    public function student_get()
    {
        $studentdetails = Student::with('department')->get();
    
        return response()->json(['studentdetails' => $studentdetails]);
    }
    

   
}