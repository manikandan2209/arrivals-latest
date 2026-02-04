<x-layouts.app :title="__('Credentials Settings')">
<div class="container">
    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
    @foreach($credentials as $index => $credential)
    <form class="row" action="{{ route('credentials.update',['id'=>$credential->id]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PATCH ') }}

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 p-4    ">
        <div class="panel-heading"><strong>{{ strtoupper( $credential->site)}} Credentials Settings</strong></div>

            <div class="">
                        <div class="mb-4">
                            <x-forms.input label="Store Hash" name="store_hash" type="text" value="{{$credential->store_hash}}" />
                            <x-forms.input label="Access Token" name="access_token" type="text" value="{{$credential->access_token}}" />
                            <x-forms.input label="Client ID" name="client_id" type="text" value="{{$credential->client_id}}" />
                        </div>
                    <x-button type="primary">Update Settings</x-button>
                </div>
            </div>
        </form>
    @endforeach
</div>
</x-layouts.app>
