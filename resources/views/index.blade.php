@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>

<div class="card uper">
    <div class="card-header">
        FERTILISER INVENTORY
    </div>
    <div class="card-body">
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br />
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="alert alert-info">
            Quantity On Hand = {{$quantityOnHand['total']}} | Valuation = ${{$quantityOnHand['price']}}
        </div>
        <div>
            <form method="post" action="{{ route('inventories.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="application">Application:</label>
                    <input type="number" class="form-control" name="application" min=0 max="{{$quantityOnHand['total']}}" />
                </div>
                <button type="submit" class="btn btn-primary">Apply</button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Date</td>
                    <td>Type</td>
                    <td>Quantity</td>
                    <td>Balance</td>
                    <td>Unit Price</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                <tr>
                    <td>{{$inventory->id}}</td>
                    <td>{{$inventory->transaction_date}}</td>
                    <td>{{$inventory->type}}</td>
                    <td>{{$inventory->quantity}}</td>
                    <td>{{$inventory->balance}}</td>
                    <td>{{$inventory->unit_price}}</td>
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
    </div>
    <div class="card-footer">By Gerard Jerome Reyes</div>
</div>
@endsection