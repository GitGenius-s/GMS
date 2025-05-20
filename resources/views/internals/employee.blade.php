@extends('layout')

@section('title','Employee List')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>List of employees</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form action="pincode.add" method="POST" class="pb-5">
            @csrf
            <input type="text" name="pincode" placeholder="Enter pincode number">
            <button type="submit" class="btn btn-primary">Add Pincode</button>
            <div>
                {{$errors->first('pincode')}}
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form action="pincode.search" method="POST" class="pb-5">
            @csrf
            <input type="text" name="pincode" placeholder="Search">
            <button type="submit" class="btn btn-primary">Search</button>
            <div>
                {{$errors->first('pincode')}}
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
                    <th>Pincode</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $index => $employee)
                <tr>
                    {{-- Serial number across paginated pages --}}
                    <td>{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
                    <td>{{ $employee->pincode_value }}</td>
                    <td>{{ $employee->city_code }}</td>
                    <td>
                        <!-- Edit Icon -->
                        <a href="{{ route('pincode.edit', $employee->pincode_value) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
            
                        <!-- Delete Icon -->
                        <form action="{{ route('pincode.delete', $employee->pincode_value) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash-alt"></i>
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
        {{ $employees->links() }}
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection