<x-layouts.app :title="__('SSO Login Logs')">
<div class="container">
            <p class="text-right inline-block mb-4"> 
                <x-button class="w-[200px]" type="danger" href="{{route('sso-login.delete-all')}}" tag="a">Delete all</x-button>
            </p>
            
            <x-panel paneltitle="SSO Login Logs" active>
                <div class="panel-heading"><strong>Logs</strong> ( Total: {{ $ssologin_logs->total() }} )</strong></div>

                <div class="panel-body">
                    <x-table.table>
                        <x-slot name="tbhead">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left" scope="col">#</th>
                                <th class="px-6 py-3 font-bold text-left" scope="col">Name</th>   
                                <th class="px-6 py-3 font-bold text-left" scope="col">Email</th>
                                <th class="px-6 py-3 font-bold text-left" scope="col">Site</th>
                                <th class="px-6 py-3 font-bold text-left" scope="col">Action</th>
                                <th class="px-6 py-3 font-bold text-left" scope="col">Payload</th>
                                <th class="px-6 py-3 font-bold text-left" scope="col">Token</th>
                                <th scope="col">Date/Time</th>
                            </tr> 
                        </x-slot>
                        <x-slot name="tbbody">
                            @foreach ($ssologin_logs as $index => $log)
                                <x-table.tr>
                                    <td class="px-6 py-2">{{$index + $ssologin_logs->firstItem() }}</td>
                                    <td class="px-6 py-2">{{$log->name}}</td>
                                    <td class="px-6 py-2">{{$log->email}}</td>
                                    <td class="px-6 py-2">{{$log->site}}</td>
                                    <td class="px-6 py-2">{{$log->action}}</td>
                                    <td style="width:200px; word-wrap: break-word;word-break: break-all;" class="px-6 py-2">{{$log->payload}}</td>
                                    <td class="px-6 py-2">@if($log->payload) login token created @endif</td>
                                    <td class="px-6 py-2">{{$log->created_at->format('d M Y g:i a')}}</td>
                                </x-table.tr>
                            @endforeach
                        </x-slot>
                    </x-table.table>
                    {{ $ssologin_logs->links() }}
                </div>
            </x-panel>
</div>

</x-layouts.app>