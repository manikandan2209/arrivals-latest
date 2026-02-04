<x-layouts.app :title="__('Add New Coupon Page Item')">

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
                <div class="panel-heading">Add new Coupon page item</div>
                <div class="panel-body">
                   <form class="form-horizontal" method="POST" action="{{ route('couponspage.store',  [ 'site' => $site]) }}">
                        {{ csrf_field() }}

                        <input type="hidden"  name="site" value="{{$site}}" >
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description"  class="form-control" name="description" >{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('limit_text') ? ' has-error' : '' }}">
                            <label for="limit_text" class="col-md-4 control-label">Limit text</label>

                            <div class="col-md-6">
                                <input id="limit_text" type="text" class="form-control" name="limit_text" value="{{ old('limit_text') }}" required>

                                @if ($errors->has('limit_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('limit_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('coupon') ? ' has-error' : '' }}">
                            <label for="coupon" class="col-md-4 control-label">Coupon</label>

                            <div class="col-md-6">
                                <p><input id="coupon" type="text" class="form-control" name="coupon" value="{{ old('coupon') }}" required >
                                <span class="coupon-error"></span>
                                </p>
                                @if ($errors->has('coupon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coupon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                            <label for="is_active" class="col-md-4 control-label">Active</label>

                            <div class="col-md-6">
                                <select  id="is_active" name="is_active" class="form-control">
                                    <option @if( old('is_active') ) selected @endif value=1>Enabled</option>
                                    <option @if( old('is_active') == false ) selected @endif value=0>Disabled</option>
                                </select>
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('sort') ? ' has-error' : '' }}">
                            <label for="sort" class="col-md-4 control-label">Sort order</label>

                            <div class="col-md-6">
                                <input id="sort" type="number" class="form-control" name="sort" value="{{ old('sort') }}" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
