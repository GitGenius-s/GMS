<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;

class ListEmployeeController extends Controller
{
    public function listEmployee()
    {
        $employees = Pincode::select('pincode_value','city_code')->paginate(20);

        return view('internals.employee', [
            'employees' => $employees,
        ]);
    }   

    public function storePincode(Request $request)
    {
        $data = $request->validate([
            'pincode' => 'required|digits:6',
        ]);
        $pincode = $request->input('pincode');
        Pincode::create([
            'pincode_value' => $pincode,
            'state_id' => 1, 
        ]);
        return response()->json(['message' => 'Pincode stored successfully!']);
    }
    public function searchPincode(Request $request)
    {
        $data = $request->validate([
            'pincode' => 'required',
        ]);
        $pincode = $request->input('pincode');
        if (empty($pincode)) {
            $pincode_data = collect([])->paginate(20); // returns empty result
        } else {
            $pincode_data = Pincode::where('pincode_value', 'LIKE', "%{$pincode}%")->orWhere('city_code', 'LIKE', "%{$pincode}%")->paginate(20);
        }
        if(empty($pincode_data) || $pincode_data->isEmpty()){
            return redirect()->route('employee.list')->with('error', 'No data found!');
        }
        
        return view('internals.employee', [
            'employees' => $pincode_data,
        ]);
    }
    public function edit($id)
    {
        $pincode = Pincode::where('pincode_value', $id)->first();
        return view('edit', compact('pincode'));
    }
    public function update(Request $request, $pincode_id)
    {
        $request->validate([
            'pincode_value' => 'required',
        ]);

        $pincode = Pincode::where('pincode_value', $pincode_id)->first();
        if(isset($pincode)){
            $pincode->pincode_value = $request->pincode_value;
            $pincode->save();
        } else {
            return redirect()->back()->with('error', 'Pincode not found!');
        }

        return redirect()->route('employee.list')->with('success', 'Pincode updated successfully!');
    }
    public function deletePincode($id)
    {
        $pincode = Pincode::where('pincode_value', $id)->first();
        if(isset($pincode)){
            $pincode->delete();
        } else {
            return redirect()->back()->with('error', 'Pincode not found!');
        }

        return redirect()->route('employee.list')->with('success', 'Pincode deleted successfully!');
    }

}
