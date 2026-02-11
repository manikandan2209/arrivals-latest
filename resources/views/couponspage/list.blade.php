<x-layouts.app :title="__('Coupons Page Items List')">


<div class="container">
   
    <div class="row">
        <ul class="flex gap-4 mb-4">
            <li><a @if ($site == 'tb') style="font-weight:bold" @endif  href="{{route('couponspage.index' , ['site'=> 'tb'])}}">Tonerbuzz</a></li>
            <li><a @if ($site == 'os') style="font-weight:bold" @endif href="{{route('couponspage.index' , ['site'=> 'os'])}}">Original Supplies</a></li>
            <li><a @if ($site == 'gi') style="font-weight:bold" @endif href="{{route('couponspage.index' , ['site'=> 'gi'])}}">Genuine ink</a></li>
            <li><a @if ($site == 'tbdev') style="font-weight:bold" @endif  href="{{route('couponspage.index' , ['site'=> 'tbdev'])}}">Tonerbuzz sandbox</a></li>
        </ul>
        <p class="text-right flex gap-2 mb-4 items-end  justify-end">
            @if($couponspagesettings)
            <x-button tag="a" type="success" class="btn btn-warning text-right" href="{{route('couponspage.push' , ['site'=> $site, 'id' => $couponspagesettings->id])}}">Push to Bc</x-button>

            <x-button tag="a" type="secondary" class="btn btn-info text-right" href="{{route('couponspagesettings.edit' , ['site'=> $site, 'coupons_page_setting' => $couponspagesettings->id])}}">Edit Page Settings</x-button>

            @else
            <x-button tag="a" class="btn btn-info text-right" href="{{route('couponspagesettings.create' , ['site'=> $site])}}">Create Settings</x-button>
            @endif
            <x-button tag="a" icon="fas-plus" class="btn btn-primary text-right" href="{{route('couponspage.create' , ['site'=> $site])}}">Add New</x-button>
        </p>
        <div class="col-md-10 col-md-offset-1">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif    
            <x-panel paneltitle="Coupons page data">
                <div class="panel-body">
                    <x-table.table>
                        <x-slot name="tbhead">
                            <tr>
                                <th class="px-4 py-2" scope="col">#</th>
                                <th class="px-4 py-2" scope="col">Title</th>
                                <th class="px-4 py-2" scope="col">description</th>
                                <th class="px-4 py-2" scope="col">limit_text</th>
                                <th class="px-4 py-2" scope="col">coupon</th>
                                <th class="px-4 py-2" scope="col">is_active</th>
                                <th class="px-4 py-2" scope="col">sort</th>
                                <th class="px-4 py-2" scope="col" width="250px">Actions</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbbody">
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
                                        <ul class="flex gap-2">
                                            <li>
                                        <x-button tag="a"  href="{{route('couponspage.edit' ,['site'=> $site ,'coupons_page' => $couponpage->id])}}">View / Edit</x-button>
                                    </li>
                                    <li><form class="inline-form" method="POST" action="{{route('couponspage.destroy' ,['site'=> $site , 'coupons_page' => $couponpage->id])}}" onsubmit="return confirm('Are you sure you want to delete this item?');" >
                                            {{csrf_field()}}
                                            {{ method_field('delete') }}
                                            <x-button type="danger" class="mt">Delete</x-button>
                                        </form>
                                    </li>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table.table>
                    </div>
            </x-panel>
        </div>
    </div>
</div>
</x-layouts.app>
