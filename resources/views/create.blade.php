@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Add Inventory
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('inventories.store') }}">
            <div class="form-group">
                @csrf
                <label for="type">Type:</label>
                <input type="text" class="form-control" name="type" />
            </div>
            <div class="form-group">
                <label for="quantity">Price :</label>
                <input type="text" class="form-control" name="quantity" />
            </div>
            <div class="form-group">
                <label for="balance">Balance :</label>
                <input type="text" class="form-control" name="balance" />
            </div>
            <div class="form-group">
                <label for="unit_price">Unit Price :</label>
                <input type="text" class="form-control" name="unit_price" />
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
@endsection