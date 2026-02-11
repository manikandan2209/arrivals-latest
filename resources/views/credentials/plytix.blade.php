<x-layouts.app :title="__('Plytix Credentials Settings')">
<div class="container">
    <div class="row">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
         @endif
        <div class="col-md-8 col-md-offset-2">
           
        @if($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <form class="row" action="{{ route('credentials.plytix-update',['id'=>$credential->id])}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH ') }}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 p-4  ">
                <div class="panel-heading mb-4 font-bold">Plytix Credentials Settings</div>
                <div class="">
                    <div class="mb-4">
                            <input type="hidden" value="set_info" name="used_for" >
                            <x-forms.input label="Api Key" name="api_key" type="text" value="{{$credential->api_key}}" />
                            <x-forms.input label="Password" name="password" type="text" value="{{$credential->password}}"/>
                        </div>
                            <x-button type="primary" >Update Settings</x-button>
                        </div>
                    </div>
            </form> 
        </div>
    </div>
</div>
</x-layouts.app>
