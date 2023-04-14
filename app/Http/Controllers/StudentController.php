<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Retrieve all students and return them as a JSON response
    public function index()
    {
        $students = Student::with('user')->get();
        return response()->json($students);
    }

    // Validate the incoming request, create a new student, and return a success message along with the created student as a JSON response
    public function store(Request $request)
    {
        // $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'grade' => 'required',
        //     'class_section' => 'required',
        // ]);
        /** @var User */
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => 'student'
        ]);
            //create association
        $student = Student::create([
            'user_id'=> $user->id,
            'grade' => 1,
            'class_section' => 'Youcode'
        ]);
        
        return response()->json(['message' => 'Student created successfully', 'student' => $user], 201);
    }

    // Retrieve a specific student by their ID and return them as a JSON response
    public function show(User $user)
    {
        return $user->load('student');
    }

    // Validate the incoming request, update the specified student, and return a success message along with the updated student as a JSON response
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'grade' => 'sometimes|required',
            'class_section' => 'sometimes|required',
        ]);

        if ($request->has('first_name')) {
            $student->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $student->last_name = $request->last_name;
        }

        if ($request->has('grade')) {
            $student->grade = $request->grade;
        }

        if ($request->has('class_section')) {
            $student->class_section = $request->class_section;
        }

        $student->save();

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    // Delete the specified student and return a success message as a JSON response
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
