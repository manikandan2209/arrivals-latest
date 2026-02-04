<x-layouts.app :title="__('Coupon Cart Logs')">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif


            <form action="{{route('coupon-cart-log.index')}}" method="get">
            <div class="row">
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputSite">Site</label>
                    <select id="inputSite" class="form-control" name="site">
                        <option selected value=''>Any</option>
                        <option value="tonerbuzz" {{ request('site') == "tonerbuzz" ? 'selected' : '' }}>Tonerbuzz</option>
                        <option value="tonerbee" {{ request('site') == "tonerbee" ? 'selected' : '' }}>Tonerbee</option>
                        <option value="genuineink" {{ request('site') == "genuineink" ? 'selected' : '' }}>Genuineink</option>
                        <option value="originalsupplies" {{ request('site') == "originalsupplies" ? 'selected' : '' }}>Original Supplies</option>
                    </select>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputPage">Page</label>
                    <select id="inputPage" class="form-control" name="c_page">
                        <option selected value='' >Any</option>
                        <option value="cart"  {{ request('c_page') == "cart" ? 'selected' : '' }}>Cart</option>
                        <option value="checkout" {{ request('c_page') == "checkout" ? 'selected' : '' }} >Checkout</option>
                    </select>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputApplied">Applied</label>
                    <select id="inputApplied" class="form-control" name="is_success">
                        <option selected value='' >Any</option>
                        <option value="1" {{ request('is_success') == "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_success') == "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputOrdered">Ordered</label>
                    <select id="inputOrdered" class="form-control" name="is_ordered" value="{{request('is_ordered')}}">
                        <option value="">Any</option>
                        <option value="1" {{ request('is_ordered') == "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_ordered') == "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputCoupon">Coupon</label>
                    <input type="text" value="{{request('coupon')}}" class="form-control" name="coupon"/>
                </div>
                </div>
                
                <div class="col-md-2">
                <div class="form-group">    
                <label for="inputDate">Date</label>
                <input type="date" id="inputDate" name="date" value="{{request('date')}}" max="{{ date('Y-m-d') }}" class="form-control" />
                </div>
                </div>
                

            </div>
                <p class="text-right">   
                    <a href="{{route('coupon-cart-log.index')}}" class="btn btn-default">Clear All</a> 
                    <button type="submit" class="btn btn-primary">Filter</button>
                </p>
            </form>

            <div class="panel panel-default">
                <div class="panel-heading"><strong>Logs</strong> ( Total: {{ $couponCartLogs->total() }} )</strong>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Coupon</th>
                                    <th scope="col">Site/Page/Cart ID</th>
                                    <th scope="col">Cart Total</th>
                                    <th scope="col">Applied Successfully</th>
                                    <th scope="col">Order Converted</th>
                                    <th scope="col">Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    <tr />
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $couponCartLogs->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>