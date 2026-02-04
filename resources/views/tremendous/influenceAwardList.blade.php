<x-layouts.app :title="__('Influence Awards List')">

<div class="container">
    <div class="row">
        
        <div class="col-md-10 col-md-offset-1">
        <p>
            <a class="btn btn-default" href="{{route('tremendous.orderslist')}}">Tremendous reward List</a>
            <a class="btn btn-primary" href="{{route('tremendous.influenceAwards')}}">Influence Awards</a>
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
                <div class="panel-heading">Influence Awards List ( Total : {{$awards->total()}} )</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">External Id or BC Id</th>
                                <th scope="col">Reward Rule id</th>
                                <th scope="col">Reward Points</th>
                                <th scope="col" >Response</th>
                                <th scope="col" >Date
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($awards as $index => $award)
                                <tr>
                                    <td>{{$index + $awards->firstItem() }}</td>
                                    <td>{{$award->email}}</td>
                                    <td>{{$award->name}}</td>
                                    <td>{{ $award->order_id }}</td>
                                    <td>{{ $award->externalId }}</td>
                                    <td>{{ $award->rewardRuleId}}</td>
                                    <td>{{ $award->rewardPoints}}</td>
                                    <td>{{ $award->response }}</td>
                                    <td>{{ $award->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $awards->links() }}
                    </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
