<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pincode;
use Illuminate\Http\Request;

class ListEmployeeController extends Controller
{
    public function listEmployee(Request $request)
    {
        $filter = $request->input('filter');

        $employees = Pincode::query();

        if ($filter) {
            $employees->where('pincode_value', 'LIKE', "%{$filter}%")
                    ->orWhere('city_code', 'LIKE', "%{$filter}%");
        }

        $employees = $employees->paginate(20)->appends(['filter' => $filter]);

        return view('internals.employee', [
            'employees' => $employees,
            'filter' => $filter,
        ]);
    }


    public function storePincode(Request $request)
    {
        $data = $request->validate([
            'pincode' => 'required|digits:6',
        ]);
        $pincode = $request->input('pincode');
        $pincode = new Pincode();
        $pincode->pincode_value = $request->input('pincode') ?? null;
        $pincode->city_code = $request->input('city_code') ?? null;
        $pincode->save();
        return redirect()->route('employee.list')->with('success', 'Customer deleted successfully!');
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
            $pincode->city_code = $request->city_code;
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

    public function listCustomers(Request $request)
    {
        $filter = $request->input('customer');
    
        $query = Customer::select('cust_code','cust_la_ent','cust_location');
    
        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('cust_code', 'LIKE', "%{$filter}%")
                  ->orWhere('cust_la_ent', 'LIKE', "%{$filter}%")
                  ->orWhere('cust_location', 'LIKE', "%{$filter}%");
            });
        }
    
        $customers = $query->paginate(20)->appends(['customer' => $filter]);
    
        return view('internals.customer', [
            'customers' => $customers,
            'filter' => $filter,
        ]);
    }
    
    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'city' => 'required',
        ]);
        $customer = new Customer();
        $customer->cust_code = $request->input('code');
        $customer->cust_la_ent = $request->input('name');
        $customer->cust_location = $request->input('city');
        $customer->save();
        return redirect()->route('customers.list')->with('success', 'Customer deleted successfully!');
    }
    public function deleteCustomer($id)
    {
        $customer = Customer::where('cust_code', $id)->first();
        if(isset($customer)){
            $customer->delete();
        } else {
            return redirect()->back()->with('error', 'Customer not found!');
        }
        return redirect()->route('customers.list')->with('success', 'Customer deleted successfully!');
    }
    public function editCustomer($id)
    {
        $customer = Customer::where('cust_code', $id)->first();
        return view('editcustomer', compact('customer'));
    }
    public function updateCustomer(Request $request, $cust_code)
    {
        $customer = Customer::where('cust_code', $cust_code)->first();
        if(isset($customer)){
            $customer->cust_la_ent = $request->cust_la_ent ?? null;
            $customer->cust_location = $request->cust_location ?? null;            
            $customer->save();
        } else {
            return redirect()->back()->with('error', 'Pincode not found!');
        }

        return redirect()->route('customers.list')->with('success', 'Customer updated successfully!');
    }

}
