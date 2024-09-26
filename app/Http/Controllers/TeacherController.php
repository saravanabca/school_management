<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Homework;
use App\Models\Mark;
use Illuminate\Validation\ValidationException;


class TeacherController extends Controller
{
    public function teacher()
    {
        return view('teacher');
    }
    public function teacher_add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
        
            Teacher::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => 'teacher_add_success',
                'status_value' => true,
                'message' => 'teacher Created Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_value' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function teacher_update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:teachers,email'. $id,
        ]);
        $teacher  = Teacher::findOrFail($id);
        
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        
        if ($request->input('password')) {
            $teacher->password = bcrypt($request->input('password'));
        }
        
        $teacher->save();
    
        return response()->json([
          'status' => 'teacher_update_success',
          'status_value' => true,
          'message' => 'teacher Created Successfully'
      ]);
    }
    
    public function teacher_get()
    {
        $teacherdetails = Teacher::get();
        // dd($teacherdetails);
        return response()->json(['teacherdetails' => $teacherdetails]);
    }

   
    public function teacher_delete(Request $request)
    {
        $id = $request->input('selectedId');
        // dd($id);
        if (!is_array($id)) {
          $id = [$id]; 
      }
    
        Teacher::whereIn('id', $id)->delete();
    
        return response()->json([
          'status' => true,
          'message' => 'Teacher Deleted Successfully'
      ]);
    
    }

    public function homework()
    {
      $students = Student::all();
        
        return view('homework',compact('students'));
    }

     public function mark()
    {
        $students = Student::all();

        return view('mark',compact('students'));
    }

    

    public function mark_add(Request $request)
    {
        try {
            // Validate the request inputs
            $request->validate([
                'student_id' => 'required|integer|exists:students,id',  // Validate student_id
                'marks' => 'required|integer',
                'subject' => 'required|string',
                'date' => 'required|date',
            ]);
    
            // Create the Mark record
            Mark::create([
                'student_id' => $request->student_id,  // Correctly access student_id
                'marks' => $request->marks,
                'subject' => $request->subject,
                'date' => $request->date,
            ]);
    
            // Return a success response
            return response()->json([
                'status' => 'mark_add_success',
                'status_value' => true,
                'message' => 'Mark created successfully'
            ]);
        } catch (Exception $e) {
            // Log the error
            \Log::error('Mark Add Error: ' . $e->getMessage());
    
            // Return error response
            return response()->json([
                'status_value' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }   
    }
    

    // public function homework_add(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'student_id' => 'required|exists:students,id',
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'due_date' => 'required|date', // Ensure this is validated as a date
    //         ]);
    
    //         // Homework::create($request->all());
    //         Homework::create([
    //             'student_id' => $request->student_id,  // Correctly access student_id
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'due_date' => $request->due_date,
    //         ]);
    
    //         return response()->json([
    //             'status' => 'homework_add_success',
    //             'status_value' => true,
    //             'message' => 'Homework created successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         \Log::error('Homework Add Error: ' . $e->getMessage());
    //         return response()->json([
    //             'status_value' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
    
    
    public function homework_add(Request $request)
    {
        try{
        $homeworkData = $request->all();
        // dd($homeworkData);
        // Create a new instance of InvoiceModel
        $homework = new Homework;
    
        // Set the properties from the request data
        $homework->fill($homeworkData); 


       

        $homework->save();
        
       return response()->json([
          'status' =>'homework_add_success',
          'status_value' => true,
          'message' => 'Homework Created Successfuly'
      ]);
    }
      catch (Exception $e) {
        return response()->json([
            'status_value' => false,
            'message' => $e->getMessage()
        ]); 
    }
       
    }

}