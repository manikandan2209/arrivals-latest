<x-layouts.app :title="__('Tremendous Settings')">

<div class="container">
    <div class="row">
        
        <div class="col-md-10 col-md-offset-1">
        <p>
            <a class="btn btn-default" href="{{route('tremendous.orderslist')}}">Tremendous reward List</a>
            <a class="btn btn-default" href="{{route('tremendous.influenceAwards')}}">Influence Awards</a>
            <a class="btn btn-primary" href="{{route('tremendous.settings')}}">Settings</a>
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
                <div class="panel-heading">Settings</div>
                <div class="panel-body">
                    <form class="row" action="{{ route('tremendous.settings.update') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3 col-md-12">
                                            <label>Tremendous Api key</label>
                                            <input class="form-control" type="text" id="account-fn" value="{{ $settings->where('name', 'tremendous_api_key')->first()->value ?? '' }}" name="tremendous_api_key" id="settings_tremendous_api_key">
                                        </div>
                                        <div class="input-group mb-3 col-md-12">
                                            <label>Influence API key</label>
                                            <input class="form-control" type="text" id="account-fn" value="{{ $settings->where('name', 'influence_api_key')->first()->value ?? '' }}" name="influence_api_key" id="settings_influence_api_key">
                                        </div>
                                        <div class="input-group mb-3 col-md-12">
                                            <label>Tonerbuzz Store Hash</label>
                                            <input class="form-control" type="text" id="account-fn" value="{{ $settings->where('name', 'tb_store_hash')->first()->value ?? '' }}" name="tb_store_hash" id="settings_tb_store_hash">
                                        </div>
                                        <div class="input-group mb-3 col-md-12">
                                            <label>Tonerbuzz Access Token</label>
                                            <input class="form-control" type="text" id="account-fn" value="{{ $settings->where('name', 'tb_access_token')->first()->value ?? '' }}" name="tb_access_token" id="settings_tb_access_token">
                                        </div>
                                        <div class="input-group mb-3 col-md-12">
                                            <label>Tonerbuzz Client Id</label>
                                            <input class="form-control" type="text" id="account-fn" value="{{ $settings->where('name', 'tb_client_id')->first()->value ?? '' }}" name="tb_client_id" id="settings_tb_client_id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <button class="btn btn-primary" type="submit" >Update Settings</button>
                                        </div>
                                    </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
