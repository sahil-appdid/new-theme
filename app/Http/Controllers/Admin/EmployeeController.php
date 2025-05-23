<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Hash;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('content.tables.employees');
    }

    public function store(Request $request)
    {
        $validated=$request->validate(
        [
            'name'     => 'required|regex:/[a-zA-Z\s]+$/',
            'phone'    => 'required|digits:10',
            'email'    => 'required|unique:employees|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => 'required|min:7|confirmed',
            'profile'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2000',
        ],
            [
                'name.required'      => 'Please enter your first name',
                'name.regex'         => 'Name should be a string',
                'phone.required'     => 'Please enter your Phone no',
                'phone.digits'       => 'Please enter 10 digit Phone no',
                'email.required'     => 'Please enter your email',
                'email.regex'        => 'Please enter a valid email',
                'password.confirmed' => 'Passwords do not match',
                'profile.image'      => 'File type should be an image',
                'profile.mimes'      => 'Please upload an image of above mentioned formats',
                'profile.max'        => 'Maximum size of image should be 2MB',
            ]);

        // $validated      = $request->all();
        $profilePic     = FileUploader::uploadFile($validated['profile']);
        $hashedPassword = Hash::make($request->password);

        $data              = new Employee();
        $data->name        = $request->name;
        $data->email       = $request->email;
        $data->phone       = $request->phone;
        $data->password    = $hashedPassword;
        $data->profile_pic = $profilePic;
        $data->save();
        return back();
    }

    public function edit($id)
    {
        $data = Employee::findOrFail($id);
        // dd($data);
        return response($data);
    }

    public function update(Request $request)
    {
        $validated      = $request->all();
        $profilePic     = FileUploader::uploadFile($validated['profile']);
        $hashedPassword = Hash::make($request->password);

        $data              = Employee::findOrFail($request->id);
        $data->name        = $request->name;
        $data->email       = $request->email;
        $data->phone       = $request->phone;
        $data->password    = $hashedPassword;
        $data->profile_pic = $profilePic;
        $data->save();
        return back();

        // return response([
        //     'header'  => 'Updated!',
        //     'message' => 'users updated successfully',
        //     'table'   => 'users-table',
        // ]);
    }

    public function destroy($id)
    {

        Employee::findOrFail($id)->delete();
        return response([
            'header' => 'Deleted!',
            'message' => 'emmployee deleted successfully',
            'table' => 'employees-table',
        ]);
    }

}
