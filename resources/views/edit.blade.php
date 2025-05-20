@extends('layout')

@section('title', 'Edit Pincode')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit Pincode</h1>

        <form action="{{ route('pincode.update', $pincode->pincode_value) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="pincode_value" class="form-label">Pincode</label>
                <input type="text" name="pincode_value" value="{{ old('pincode_value', $pincode->pincode_value) }}" class="form-control">
                @error('pincode_value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('employee.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
