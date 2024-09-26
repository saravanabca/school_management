<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department; 
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\Mark;

class StudentController extends Controller
{
    public function student()
    {
        return view('student');
    }


    public function student_add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
        
            Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

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
        $studentdetails = Student::get();
    
        return response()->json(['studentdetails' => $studentdetails]);
    }
    
    public function student_delete(Request $request)
    {
        $id = $request->input('selectedId');
        // dd($id);
        if (!is_array($id)) {
          $id = [$id]; 
      }
    
        Student::whereIn('id', $id)->delete();
    
        return response()->json([
          'status' => true,
          'message' => 'Student Deleted Successfully'
      ]);
    
    }

    public function viewHomework($student_id)
    {
        $homeworks = Homework::where('student_id', $student_id)->get();

        return response()->json($homeworks);
    }


    public function trackPerformance(Request $request, $student_id)
    {
        // Validate the period input
        $request->validate([
            'period' => 'required|in:year,month,week',
        ]);

        // Get the current date and time
        $now = Carbon::now();

        // Set date range based on the selected period
        switch ($request->period) {
            case 'year':
                $startDate = $now->startOfYear();
                $endDate = $now->endOfYear();
                break;

            case 'month':
                $startDate = $now->startOfMonth();
                $endDate = $now->endOfMonth();
                break;

            case 'week':
                $startDate = $now->startOfWeek();
                $endDate = $now->endOfWeek();
                break;
        }

        // Get marks within the specified period
        $marks = Mark::where('student_id', $student_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Get homework completion within the specified period
        $homeworks = Homework::where('student_id', $student_id)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->get();

        // Return the marks and homework data
        return response()->json([
            'marks' => $marks,
            'homeworks' => $homeworks,
            'period' => $request->period,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);
    }

   
}