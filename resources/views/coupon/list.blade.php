<x-layouts.app :title="__('Coupons List')">
<div class="container">
    <div class="row">
        <p class="text-left mb-4">
            <x-button tag="a" href="{{route('coupon.create' , ['site'=> $site])}}" variant="primary" size="default" class="inline-block " icon="fas-plus">Add New</x-button>
        </p>
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
                                <th scope="col" width="240px"  class="px-6 py-3 font-medium">Actions</th>
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
                                        <ul class="flex space-x-4">
                                            <li>
                                                <a class="inline-block text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{route('coupon.edit' ,['site'=> $site ,'coupon' => $coupon->id])}}">View / Edit</a>
                                            </li>
                                            <li><form class="inline-form" method="POST" action="{{route('coupon.destroy' ,['site'=> $site , 'coupon' => $coupon->id])}}" onsubmit="return confirm('Are you sure you want to delete this item?');" >
                                            {{csrf_field()}}
                                            {{ method_field('delete') }}
                                            <x-icon-button icon="fas-trash" variant="danger"  icon-position="right"></x-icon-button>
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
