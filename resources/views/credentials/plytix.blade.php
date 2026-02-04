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
        <form class="row" action="{{ route('credentials.plytix-update',['credential'=>$credential->id])}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH ') }}
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Plytix Credentials Settings</strong></div>
                <div class="panel-body">
                        <input type="hidden" value="set_info" name="used_for" >

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group mb-3 col-md-12">
                                    <label>Api Key</label>
                                    <input class="form-control" type="text" value="{{$credential->api_key}}" name="api_key" id="credentials_{{$credential->id}}">
                                </div>
                                <div class="input-group mb-3 col-md-12">
                                    <label>Password</label>
                                    <input class="form-control" type="text" value="{{$credential->password}}" name="password" id="credentials_{{$credential->id}}">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <button class="btn btn-primary" type="submit" >Update Settings</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>
</x-layouts.app>
