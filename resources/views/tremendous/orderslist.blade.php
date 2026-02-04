<x-layouts.app :title="__('Tremendous Orders List')">

<div class="container">
    <div class="row">
        
        <div class="col-md-10 col-md-offset-1">
        <p>
            <a class="btn btn-primary" href="{{route('tremendous.orderslist')}}">Tremendous reward List</a>
            <a class="btn btn-default" href="{{route('tremendous.influenceAwards')}}">Influence Awards</a>
            <a class="btn btn-default" href="{{route('tremendous.settings')}}">Settings</a>

        </p>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif  
            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <div class="panel panel-default">
                <div class="panel-heading">Tremendous Orders List ( Total : {{$orders->total()}} )</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Influence Redeem id</th>
                                <th scope="col">Email</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Tremendous id</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{$index + $orders->firstItem() }}</td>
                                    <td>{{$order->redeem_id}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>{{ $order->tremendous_reward_order_id}}</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                    </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
