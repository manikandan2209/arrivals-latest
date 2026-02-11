<x-layouts.app :title="__('Tremendous Settings')">

<div class="container">    
            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <x-panel paneltitle="Tremendous Settings" active>
               
                <div class="panel-body">
                    <form class="row" action="{{ route('tremendous.settings.update') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <div class="col-md-12">
                                            <x-forms.input class="mb-4" label="Tremendous Api key" name="tremendous_api_key" type="text" value="{{ $settings->where('name', 'tremendous_api_key')->first()->value ?? '' }}" id="settings_tremendous_api_key"/>
                                            <x-forms.input class="mb-4" label="Influence API key" name="influence_api_key" type="text" value="{{ $settings->where('name', 'influence_api_key')->first()->value ?? '' }}" id="settings_influence_api_key"/>
                                            <x-forms.input class="mb-4" label="Tonerbuzz Store Hash" name="tb_store_hash" type="text" value="{{ $settings->where('name', 'tb_store_hash')->first()->value ?? '' }}" id="settings_tb_store_hash"/>
                                            <x-forms.input class="mb-4" label="Tonerbuzz Access Token" name="tb_access_token" type="text" value="{{ $settings->where('name', 'tb_access_token')->first()->value ?? '' }}" id="settings_tb_access_token"/>  
                                            <x-forms.input class="mb-4" label="Tonerbuzz Client Id" name="tb_client_id" type="text" value="{{ $settings->where('name', 'tb_client_id')->first()->value ?? '' }}" id="settings_tb_client_id"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-4">
                                            <x-button type='primary' class="mb-2">Update Settings</x-button>
                                        </div>
                                    </div>
                            </div>
                    </form>
                </div>
            </x-panel>
</div>
</x-layouts.app>
