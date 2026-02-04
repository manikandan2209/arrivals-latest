<x-layouts.app :title="__('Coupons Page Items List')">


<div class="container">
   
    <div class="row">
        <ul class="nav navbar-nav">
            <li><a @if ($site == 'tb') style="font-weight:bold" @endif  href="{{route('couponspage.index' , ['site'=> 'tb'])}}">Tonerbuzz</a></li>
            <li><a @if ($site == 'os') style="font-weight:bold" @endif href="{{route('couponspage.index' , ['site'=> 'os'])}}">Original Supplies</a></li>
            <li><a @if ($site == 'gi') style="font-weight:bold" @endif href="{{route('couponspage.index' , ['site'=> 'gi'])}}">Genuine ink</a></li>
            <li><a @if ($site == 'tbdev') style="font-weight:bold" @endif  href="{{route('couponspage.index' , ['site'=> 'tbdev'])}}">Tonerbuzz sandbox</a></li>
        </ul>
        <p class="text-right">
            @if($couponspagesettings)
            <a class="btn btn-warning text-right" href="{{route('couponspage.push' , ['site'=> $site, 'id' => $couponspagesettings->id])}}">Push to Bc</a>

            <a class="btn btn-info text-right" href="{{route('couponspagesettings.edit' , ['site'=> $site, 'coupons_page_setting' => $couponspagesettings->id])}}">Edit Page Settings</a>

            @else
            <a class="btn btn-info text-right" href="{{route('couponspagesettings.create' , ['site'=> $site])}}">Create Settings</a>
            @endif
            <a class="btn btn-primary text-right" href="{{route('couponspage.create' , ['site'=> $site])}}">Add New</a>
        </p>
        <div class="col-md-10 col-md-offset-1">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif    
            <div class="panel panel-default">
                <div class="panel-heading">Coupons page data</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">description</th>
                                <th scope="col">limit_text</th>
                                <th scope="col">coupon</th>
                                <th scope="col">is_active</th>
                                <th scope="col">sort</th>
                                <th scope="col" width="200px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($couponspage as $index => $couponpage)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$couponpage->title}}</td>
                                    <td>{{$couponpage->description}}</td>
                                    <td>{{$couponpage->limit_text}}</td>
                                    <td>{{$couponpage->coupon}}</td>
                                    <td>{{$couponpage->is_active? 'Yes' : 'No' }}</td>
                                    <td>{{$couponpage->sort}}</td>
                                    <td class="">
                                        <ul class="list-inline">
                                            <li>
                                        <a class="btn btn-primary" href="{{route('couponspage.edit' ,['site'=> $site ,'coupons_page' => $couponpage->id])}}">View / Edit</a>
                                    </li>
                                    <li><form class="inline-form" method="POST" action="{{route('couponspage.destroy' ,['site'=> $site , 'coupons_page' => $couponpage->id])}}" onsubmit="return confirm('Are you sure you want to delete this item?');" >
                                            {{csrf_field()}}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </li>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
