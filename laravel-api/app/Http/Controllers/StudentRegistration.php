<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class StudentRegistration extends Controller
{

    function AddStudent(Request $request)
    {
        try {
            $Data = Validator::make($request->all(), [
                'name' => 'required|string|max:20',
                'email' => 'required|string|email|max:255|unique:students',
                'password' => 'required|string|min:8|confirmed',
                'education' => 'required|string',
                'address' => 'required|string|max:255',
                'age' => 'required|integer|min:18|max:80',
                'gender' => 'required|string|in:male,female,other',
                'contact' => 'required|string',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);

            if ($Data->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $Data->errors(),
                ], 422);
            }

            // Validation passed, create StudentModel object
            $stdobj = new StudentModel();
            $stdobj->name = $request->name;
            $stdobj->email = $request->email;
            $stdobj->password = bcrypt($request->password);
            $stdobj->education = $request->education;
            $stdobj->address = $request->address;
            $stdobj->age = $request->age;
            $stdobj->gender = $request->gender;
            $stdobj->contact = $request->contact;

            // Handle picture upload if available
            if ($request->hasFile('picture')) {
                $picture = time() . "_IMG." . $request->file('picture')->getClientOriginalExtension();
                $picturePath = $request->file('picture')->storeAs('student_pictures', $picture);
                $stdobj->picture = $picturePath;
            }

            // Save the model to the database
            $stdobj->save();

            return response()->json([
                'code' => 201,
                'message' => 'Resource created successfully',
            ], 201);
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function FindStudent($id, Request $request)
    {

        $findstd = StudentModel::find($id);

        if ($findstd) {
            // Record found
            return response()->json(['success' => true, 'data' => $findstd], 200);
        } else {
            // Record not found
            return response()->json(['success' => false, 'message' => 'record not exist try again..', 'data' => null], 404);
        }
    }


    public function FindAll(Request $request)
    {
        $stdnt = StudentModel::all();
    
        if ($stdnt->isNotEmpty()) {
            return response()->json([
                "status" => 200,
                "message" => "Records found...",
                "data" => $stdnt
            ]);
        } else {
            return response()->json([
                "status" => 404,
                "message" => "Db is empty...",
                "data" => null
            ]);
        }
    }


    public function UpdateStudent($id, Request $request)
    {


        $Data = Validator::make($request->all(), [
            'name' => 'required|string|max:20',  // Name remains required
            'email' => 'required|string|email|max:255|unique:students,email,' . $id, // Enforce uniqueness for updates
            'password' => 'nullable|string|min:8|confirmed',  // Password is now optional for updates
            'education' => 'nullable|string',  // Education is now optional
            'address' => 'nullable|string|max:255',  // Address is now optional
            'age' => 'nullable|integer|min:18|max:80',  // Age is now optional
            'gender' => 'nullable|string|in:male,female,other',  // Gender is now optional
            'contact' => 'nullable|string',  // Contact is now optional
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024'
        ]);


        if ($Data->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $Data->errors(),
            ], 422);
        }


        $stdobj = StudentModel::find($id);

        if ($stdobj) {


            $stdobj->name = $request->name;
            $stdobj->email = $request->email;
            $stdobj->password = bcrypt($request->password);
            $stdobj->education = $request->education;
            $stdobj->address = $request->address;
            $stdobj->age = $request->age;
            $stdobj->gender = $request->gender;
            $stdobj->contact = $request->contact;

            // Handle picture upload if available
            if ($request->hasFile('picture')) {
                $picture = time() . "_IMG." . $request->file('picture')->getClientOriginalExtension();
                $picturePath = $request->file('picture')->storeAs('student_pictures', $picture);
                $stdobj->picture = $picturePath;
            }

            // Save the model to the database
            $stdobj->save();
            return response()->json(['success' => true, 'message' => 'Record updated successfully', 'data' => $stdobj], 200);
        } else {
            // Record not found
            return response()->json(['success' => false, 'message' => 'Record not found', 'data' => null], 404);
        }
    }


    function DeleteStudent($id)
    {
        $findstd = StudentModel::find($id);

        if ($findstd) {

            // Record found
            $findstd->delete();

            return response()->json(['success' => true, 'message' => 'record deleted successfully'], 200);
        } else {
            // Record not found
            return response()->json(['success' => false, 'message' => 'Record not found', 'data' => null], 404);
        }


    }





    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user =StudentModel::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            return response()->json(['success' => true,"message"=>"login success..", 'user' => $user]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['success' => true, 'message' => 'Logout successful']);
    }

}














