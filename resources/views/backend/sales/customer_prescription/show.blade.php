@extends('backend.layouts.app')

@section('content')
    @php
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">User Details</h4>
                            <table class="table table-striped">
                                <tr>
                                    <th>User Name: </th>
                                    <td>{{ $pre->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone: </th>
                                    <td>{{ $pre->user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>User Address: </th>
                                    <td>{{ $pre->user->address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Details</h4>
                            <table class="table table-striped">
                                <tr>
                                    <th>Product Name: </th>
                                    <td>{{ $pre->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone: </th>
                                    <td>{{ $pre->product->single_price }}</td>
                                </tr>
                                <tr>
                                    <th>User Address: </th>
                                    <td>{{ $pre->product->pack_Price }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach(json_decode($pre->prescription_image) as $img)
                        <div class="col-md-6">
                            <img src="{{ static_asset('uploads/prescriptions')."/". $img  }}" >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
