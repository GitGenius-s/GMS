@extends('layout')

@section('title','Customers List')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>List of customers</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form action="customers.add" method="POST" class="pb-5">
            @csrf
            <div><input type="text" name="code" placeholder="Enter code"></div>
            <div><input type="text" name="name" placeholder="Enter name"></div>
            <div><input type="text" name="city" placeholder="Enter city"></div>
            <div><button type="submit" class="btn btn-primary">Add customer</button></div>
            <div>
                {{$errors->first('pincode')}}
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form action="{{ route('customers.list') }}" method="GET" class="pb-5">
            <input type="text" name="customer" placeholder="Search customer" value="{{ request('customer') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <div>
                {{ $errors->first('customer') }}
            </div>
        </form>
        
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>s_no</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                <tr>
                    {{-- Serial number across paginated pages --}}
                    <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                    <td>{{ $customer->cust_code }}</td>
                    <td>{{ $customer->cust_la_ent }}</td>
                    <td>{{ $customer->cust_location }}</td>
                    <td>
                        <!-- Edit Icon -->
                        <a href="{{ route('customers.edit', $customer->cust_code) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit">Edit</i>
                        </a>
            
                        <!-- Delete Icon -->
                        <form action="{{ route('customers.delete', $customer->cust_code) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash-alt">Del</i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12 text-center">
        {{ $customers->links() }}
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection