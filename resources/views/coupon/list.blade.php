<x-layouts.app :title="__('Coupons List')">
<div class="container">
    <div class="row">
      
        <p class="text-right"><a class="btn btn-primary text-right" href="{{route('coupon.create' , ['site'=> $site])}}">Add New</a></p>
        <div class="col-md-10 col-md-offset-1">
          
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 p-4   ">
                <div class="font-bold text-lg mb-2">Coupons List</div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                            <tr>
                                <th scope="col"  class="px-6 py-3 font-bold">#</th>
                                <th scope="col" class="px-6 py-3 font-bold">Coupon code</th>
                                <th scope="col" class="px-6 py-3 font-bold">Loyalty Points</th>
                                <th scope="col" class="px-6 py-3 font-bold">Loyalty Type</th>
                                <th scope="col" class="px-6 py-3 font-bold">Influence Reward Rule Id</th>
                                <th scope="col" class="px-6 py-3 font-bold">Expires</th>
                                <th scope="col" class="px-6 py-3 font-bold">Active</th>
                                <th scope="col" width="200px"  class="px-6 py-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $index => $coupon)
                                <tr class="bg-neutral-primary-soft border-b  border-default">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{$index+1}}</th>
                                    <td class="px-6 py-2">{{$coupon->coupon}}</td>
                                    <td class="px-6 py-2">{{$coupon->loyalty_points}}</td>
                                    <td class="px-6 py-2">{{$coupon->loyalty_points_type}}</td>
                                    <td class="px-6 py-2">{{$coupon->influence_reward_rule_id}}</td>
                                    <td class="px-6 py-2">{{$coupon->expires}}</td>
                                    <td class="px-6 py-2">{{$coupon->is_active? 'Yes' : 'No' }}</td>
                                    <td class="px-6 py-2">
                                        <ul class="list-inline">
                                            <li>
                                        <a class="" href="{{route('coupon.edit' ,['site'=> $site ,'coupon' => $coupon->id])}}">View / Edit</a>
                                    </li>
                                    <li><form class="inline-form" method="POST" action="{{route('coupon.destroy' ,['site'=> $site , 'coupon' => $coupon->id])}}" onsubmit="return confirm('Are you sure you want to delete this item?');" >
                                            {{csrf_field()}}
                                            {{ method_field('delete') }}
                                            <x-button type="danger" buttonType="submit">Delete</x-button>
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
