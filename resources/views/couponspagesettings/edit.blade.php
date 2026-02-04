<x-layouts.app :title="__('Edit Coupon Page Settings')">
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <p class="text-right"><a class="btn btn-default text-right" href="{{route('couponspage.index',['site' => $site])}}">Back</a></p>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">Edit Coupon Page Settings</div>
                <div class="panel-body">
                   <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('couponspagesettings.update' ,[  'site' => $site, 'coupons_page_setting' => $couponspagesettings->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden"  name="site" value="{{$site}}" >
                        <div class="form-group">
                            <label for="title" class="col-md-3 control-label">Title</label>

                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $couponspagesettings->title }}" >
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
                            <label for="page_id" class="col-md-3 control-label">Page ID</label>

                            <div class="col-md-8">
                                <input id="page_id" type="text" class="form-control" name="page_id" value="{{ $couponspagesettings->page_id }}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="body" class="col-md-3 control-label">Body</label>

                            <div class="col-md-8">
                                <textarea id="body"  class="form-control" name="body" rows="15" >{{ $couponspagesettings->body }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
