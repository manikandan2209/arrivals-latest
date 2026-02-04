<x-layouts.app :title="__('SSO Login Logs')">
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <p class="text-right">
            <a class="btn btn-danger text-right" href="{{route('sso-login.delete-all')}}">Delete all</a>
        </p>
            
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Logs</strong> ( Total: {{ $ssologin_logs->total() }} )</strong></div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>   
                                <th scope="col">Email</th>
                                <th scope="col">Site</th>
                                <th scope="col">Action</th>
                                <th scope="col">Payload</th>
                                <th scope="col">Token</th>
                                <th scope="col">Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ssologin_logs as $index => $log)
                                <tr>
                                    <td>{{$index + $ssologin_logs->firstItem() }}</td>
                                    <td>{{$log->name}}</td>
                                    <td>{{$log->email}}</td>
                                    <td>{{$log->site}}</td>
                                    <td>{{$log->action}}</td>
                                    <td style="width:200px; word-wrap: break-word;word-break: break-all;">{{$log->payload}}</td>
                                    <td>@if($log->payload) login token created @endif</td>
                                    <td>{{$log->created_at->format('d M Y g:i a')}}</td>
                                <tr />
                            @endforeach
                        </tbody>
                    </table>
                    {{ $ssologin_logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>