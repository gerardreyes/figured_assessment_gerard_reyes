@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div><br />
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>Type</td>
                <td>Quantity</td>
                <td>Balance</td>
                <td>Unit Price</td>
                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td>{{$inventory->id}}</td>
                <td>{{$inventory->type}}</td>
                <td>{{$inventory->quantity}}</td>
                <td>{{$inventory->balance}}</td>
                <td>{{$inventory->unit_price}}</td>
                <td><a href="{{ route('inventories.edit', $inventory->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('inventories.destroy', $inventory->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        @endsection