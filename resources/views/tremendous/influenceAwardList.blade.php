<x-layouts.app :title="__('Influence Awards List')">

<div class="container">
            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <x-panel paneltitle="Influence Awards List ( Total : {{$awards->total()}} )" active>
                <div class="panel-body">
                    <x-table.table>
                        <x-slot name="tbhead">
                                                        <tr>
                                <th class="px-4 py-2" scope="col">#</th>
                                <th class="px-4 py-2" scope="col">Email</th>
                                <th class="px-4 py-2" scope="col">Name</th>
                                <th class="px-4 py-2" scope="col">Order ID</th>
                                <th class="px-4 py-2" scope="col">External Id or BC Id</th>
                                <th class="px-4 py-2" scope="col">Reward Rule id</th>
                                <th class="px-4 py-2" scope="col">Reward Points</th>
                                <th class="px-4 py-2" scope="col" >Response</th>
                                <th class="px-4 py-2" scope="col" >Date
                            </tr>
                        </x-slot>
                        <x-slot name="tbbody">
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
                        </x-slot>
                    </x-table.table>
                    {{ $awards->links() }}
                    </div>
            </x-panel>
</div>
</x-layouts.app>
