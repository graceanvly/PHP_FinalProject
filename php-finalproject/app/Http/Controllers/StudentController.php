<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    // get
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($student);
    }

    // add
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'grade' => 'required'
        ]);

        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    // update
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Not found'], 404);
        }
    
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'grade' => 'required'
        ]);
    
        $student->update($validatedData);
        return response()->json(['success' => true, 'data' => $student]);
    }

    // delete
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $student->delete();
        return response()->json(null, 204);
    }
}