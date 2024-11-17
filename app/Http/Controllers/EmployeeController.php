<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    public function getData(Request $request)
    {

        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value', '');
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderColumn = $request->input('columns' . $orderColumnIndex . 'data', 'id');
        $orderDirection = $request->input('order.0.dir', 'asc');

        $query = Employee::query();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            });
        }

        $recordsTotal = Employee::count();
        $recordsFiltered = $query->count();

        $data = $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($length)
            ->get();

        $records = [];

        $url = url('/');
        foreach ($data as $employee) {

            $action = "";
            $action .= "<a href='" . $url . "/employees/edit/" . $employee->id . "' class='btn btn-info mr_2'>Edit</a>";
            $action .= '<button type="button" onclick="delect_emp(' . $employee->id . ')" class="btn btn-danger ml-2">Delete</button>';

            $records[] = [
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'phone_number' => $employee->phone_number,
                'created_at' => date('d-m-Y h:s', strtotime($employee->created_at)),
                'action' => $action
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records
        ]);
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:employees',
            'country_code' => 'required',
            'phone_number' => ['required', 'regex:/^\d{10}$/'],
            'address' => 'required',
            'gender' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'country_code.required' => 'Please select country code',
            'gender.required' => 'Please select gender',
            'email.email' => 'Please enter valid email',
            'email.unique' => 'This email already exits',
            'first_name.string' => 'First name must be string.',
            'last_name.string' => 'Last name must be string',
        ]);


        $image_name = '';

        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $image_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path() . '/photo_upload';
            $image->move($destination, $image_name);
        }

        $emp = $request->all();
        $emp['photo'] = $image_name;
        if (!empty($request->hobby)) {
            $emp['hobby'] = implode(',', $request->hobby);
        }

        Employee::create($emp);
        session()->flash('success', 'Employee has been created successfully!');
        return redirect()->route('employees.list');
    }

    public function edit($id)
    {
        $employee = Employee::find($id);


        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $id = $request->id;


        $request->validate([
            'first_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:employees,email,' . $id,
            'country_code' => 'required',
            'phone_number' => ['required', 'regex:/^\d{10}$/'],
            'address' => 'required',
            'gender' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'country_code.required' => 'Please select country code',
            'gender.required' => 'Please select gender',
            'email.email' => 'Please enter valid email',
            'email.unique' => 'This email already exits',
            'first_name.string' => 'First name must be string.',
            'last_name.string' => 'Last name must be string',
        ]);

        $image_name = '';

        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $image_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path() . '/photo_upload';
            $image->move($destination, $image_name);

            $filePath = public_path('/photo_upload/' . $request->old_photo);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } else {
            $image_name = $request->old_photo;
        }

        $employees = Employee::find($id);

        $employees->first_name = $request->first_name;
        $employees->last_name = $request->last_name;
        $employees->email = $request->email;
        $employees->country_code = $request->country_code;
        $employees->phone_number = $request->phone_number;
        $employees->gender = $request->gender;
        $employees->photo = $image_name;

        if (!empty($request->hobby)) {
            $employees->hobby = implode(',', $request->hobby);
        }
        $employees->save();
        session()->flash('success', 'Employee has been updated successfully!');
        return redirect()->route('employees.list');
    }

    public function delete(Request $request)
    {
        $employee = Employee::find($request->id);
        $file_name = $employee->photo;
        $employee->delete();

        $filePath = public_path('/photo_upload/' . $file_name);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return redirect()->route('employees.list');
    }
}
