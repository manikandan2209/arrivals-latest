<x-layouts.app :title="__('Tremendous Orders List')">

<div class="container">

            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <x-panel paneltitle="Tremendous Orders List ( Total : {{$orders->total()}} )" active>
                <div class="panel-body">
                    <x-table.table>
                        <x-slot name="tbhead">
                            <tr>
                                <th class="px-4 py-2" scope="col">#</th>
                                <th class="px-4 py-2" scope="col">Influence Redeem id</th>
                                <th class="px-4 py-2" scope="col">Email</th>
                                <th class="px-4 py-2" scope="col">Amount</th>
                                <th class="px-4 py-2" scope="col">Tremendous id</th>
                                <th class="px-4 py-2" scope="col">Date</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbbody">
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
                        </x-slot>
                    </x-table.table>
                    {{ $orders->links() }}
                    </div>
            </x-panel>
</div>
</x-layouts.app>
