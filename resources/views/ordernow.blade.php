@extends('master')
@section('content')
    <div class="container">
        <div class="col-sm-9">
            <label for="">Products</label>
            <br />
            <br />
            <div class="">
                @foreach ($products as $item)
                    <div class="row search-item cart-list-devider">
                        <div class="col-sm-3">
                            <a href="detail/{{ $item->id }}">
                                <img class="trending-img" src="{{ $item->gallery }}">
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <div class="">
                                <h3>{{ $item->name }}</h3>
                                <h5>{{ $item->price }} SR</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-3">
            <label for="">Order Detail</label>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Price</td>
                        <td>{{ $total }} SR</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>0 SR</td>
                    </tr>
                    <tr>
                        <td>Delivery</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td>{{ $total + 30 }} SR</td>
                    </tr>
                </tbody>
            </table>

            <form method="POST" action="orderplace">
                @csrf
                <label for="">Address</label>
                <div class="form-group">
                    <textarea placeholder="enter yoyr address" name="address" class="form-control" required> </textarea>
                </div>
                <div class="form-group">
                    <label for="">Payment Method</label>
                    <p><input type="radio" value="Credit Card" name="payment" checked> <span>Credit Card</span> </p>
                    <p><input type="radio" value="Mada" name="payment"> <span>Mada</span> </p>
                    <p><input type="radio" value="cash" name="payment"> <span>Payment on Delivery</span> </p>

                </div>
                <button type="submit" class="btn btn-success">Order Now</button>
            </form>
        </div>
    </div>
@endsection
<div class="clearfix"></div>
</div>
