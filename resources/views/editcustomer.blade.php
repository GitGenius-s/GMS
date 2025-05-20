@extends('layout')

@section('title', 'Edit Customer')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit Customer</h1>

        <form action="{{ route('customers.update', $customer->cust_code) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="cust_code" class="form-label">Customer</label>
                <input type="text" name="cust_la_ent" value="{{ old('cust_la_ent', $customer->cust_la_ent) }}" class="form-control">
                <input type="text" name="cust_location" value="{{ old('cust_location', $customer->cust_location) }}" class="form-control">
                @error('cust_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('customers.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
