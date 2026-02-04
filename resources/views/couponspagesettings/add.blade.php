<x-layouts.app :title="__('Create Coupon Page Settings')">

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
           
        <p class="text-right"><a class="btn btn-default text-right" href="{{route('couponspage.index',[ 'site' => $site])}}">Back</a></p>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif    
        <div class="panel panel-default">
                <div class="panel-heading">Create Coupon page Settings</div>
                <div class="panel-body">
                   <form class="form-horizontal" method="POST" action="{{ route('couponspagesettings.store',  [ 'site' => $site]) }}">
                        {{ csrf_field() }}

                        <input type="hidden"  name="site" value="{{$site}}" >
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" >
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
                            <label for="page_id" class="col-md-4 control-label">Page ID</label>

                            <div class="col-md-6">
                                <input id="page_id" type="text" class="form-control" name="page_id" value="{{ old('page_id') }}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Body</label>

                            <div class="col-md-6">
                                <textarea id="description"  class="form-control" name="body" rows="15" >{{ old('body') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
