<x-layouts.app :title="__('Coupon Cart Logs')">
<div class="container">

            <form action="{{route('coupon-cart-log.index')}}" method="get">
            <div class="flex gap-4 mb-4 ">
                <div class="col-md-2"> 
                <label for="inputSite">Site</label>
                    <select id="inputSite" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" name="site">
                        <option selected value=''>Any</option>
                        <option value="tonerbuzz" {{ request('site') == "tonerbuzz" ? 'selected' : '' }}>Tonerbuzz</option>
                        <option value="tonerbee" {{ request('site') == "tonerbee" ? 'selected' : '' }}>Tonerbee</option>
                        <option value="genuineink" {{ request('site') == "genuineink" ? 'selected' : '' }}>Genuineink</option>
                        <option value="originalsupplies" {{ request('site') == "originalsupplies" ? 'selected' : '' }}>Original Supplies</option>
                    </select>
                </div>
                <div class="col-md-2">   
                <label for="inputPage">Page</label>
                    <select id="inputPage" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" name="c_page">
                        <option selected value='' >Any</option>
                        <option value="cart"  {{ request('c_page') == "cart" ? 'selected' : '' }}>Cart</option>
                        <option value="checkout" {{ request('c_page') == "checkout" ? 'selected' : '' }} >Checkout</option>
                    </select>
                </div>
                <div class="col-md-2">  
                <label for="inputApplied">Applied</label>
                    <select id="inputApplied" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" name="is_success">
                        <option selected value='' >Any</option>
                        <option value="1" {{ request('is_success') == "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_success') == "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-2">
                <label for="inputOrdered">Ordered</label>
                    <select id="inputOrdered" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" name="is_ordered" value="{{request('is_ordered')}}">
                        <option value="">Any</option>
                        <option value="1" {{ request('is_ordered') == "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_ordered') == "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-2">   
                <label for="inputCoupon">Coupon</label>
                    <input type="text" value="{{request('coupon')}}" class="form-control" name="coupon"/>
                </div>
                
                <div class="col-md-2">  
                <label for="inputDate">Date</label>
                <input type="date" id="inputDate" name="date" value="{{request('date')}}" max="{{ date('Y-m-d') }}" class="form-control" />
                </div>
                

            </div>
                <p class="text-right">   
                    <a href="{{route('coupon-cart-log.index')}}" class="btn btn-default">Clear All</a> 
                    <button type="submit" class="btn btn-primary">Filter</button>
                </p>
            </form>

            <x-panel paneltitle="Coupon Cart Logs ( Total : {{ $couponCartLogs->total() }} )" >

                <div class="panel-body">
                    <div class="table-responsive">
                        <x-table.table>
                            <x-slot name="tbhead">
                                <tr>
                                    <th class="px-4 py-2" scope="col">#</th>
                                    <th class="px-4 py-2" scope="col">Email</th>
                                    <th class="px-4 py-2" scope="col">Coupon</th>
                                    <th class="px-4 py-2" scope="col">Site/Page/Cart ID</th>
                                    <th class="px-4 py-2" scope="col">Cart Total</th>
                                    <th class="px-4 py-2" scope="col">Applied Successfully</th>
                                    <th class="px-4 py-2" scope="col">Order Converted</th>
                                    <th class="px-4 py-2" scope="col">Date/Time</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbbody">
                                @foreach ($couponCartLogs as $index => $log)
                                <tr>
                                    <td>{{$index + $couponCartLogs->firstItem() }}</td>
                                    <td>{{$log->email}}</td>
                                    <td>{{$log->coupon}}</td>
                                    <td>{{$log->site}}
                                        @if($log->page)
                                        <p>Page: {{$log->page}}</p>
                                        @endif
                                        @if($log->page)
                                        <p class="small">Cart ID:<br>{{$log->cart_id}}</p>
                                        @endif
                                    </td>
                                    <td>{{$log->cart_total}}</td>
                                    <td>
                                        @if($log->page == 'checkout')
                                        N/A
                                        @else
                                        {{$log->is_success ? 'Yes' : 'No'}}
                                        @endif
                                        @if($log->reason)
                                        <p class="small">Reason :<br />{{$log->reason }}</p>
                                        @endif
                                    </td>
                                    <td>{{$log->is_ordered ? 'Yes' : 'No'}}
                                        @if($log->order_id)
                                        <p>Order id : {{$log->order_id}}</p>
                                        @endif
                                    </td>
                                    <td>{{$log->created_at->format('d M Y g:i a')}}</td>
                                    </tr>
                                    @endforeach
                            </x-slot>
                        </x-table.table>
                    </div>
                    {{ $couponCartLogs->appends(request()->except('page'))->links() }}
                </div>
</x-panel>
</div>

</x-layouts.app>