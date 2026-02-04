<x-layouts.app :title="__('Edit Coupon')">

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <p class="text-right"><a class="btn btn-default text-right" href="{{route('coupon.index',['site' => $site])}}">Back</a></p>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">Edit Coupon Message</div>
                <div class="panel-body">
                   <form class="form-horizontal" method="POST" action="{{ route('coupon.update' ,[  'site' =>$site, 'coupon' =>$coupon->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH ') }}
                        <div class="form-group{{ $errors->has('coupon') ? ' has-error' : '' }}">
                            <label for="coupon" class="col-md-4 control-label">Coupon</label>

                            <div class="col-md-6">
                                <p><input id="coupon" type="text" class="form-control" name="coupon" value="{{ $coupon->coupon }}" required autofocus>
                                    <span class="coupon-error"></span>
                                </p>
                                <a class="btn btn-info m-5 get-data-btn" href="#">Get Coupon info from Bigcommerce</a>
                                @if ( $errors->has('coupon') )
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coupon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="expires" class="col-md-4 control-label">Expires</label>

                            <div class="col-md-6">
                                <input id="expires" type="text" class="form-control" name="expires" value="{{ $coupon->expires }}" readonly>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="loyalty_points" class="col-md-4 control-label">Loyalty Type</label>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                <input type="radio" autocomplete="off" onChange="document.getElementById('loyalty_points').value='';" name="loyalty_points_type" id="per_dollar" value="per_dollar" {{ $coupon->loyalty_points_type == 'per_dollar' ? 'checked' : '' }} > per dollar
                                </label><br/>
                                <label class="radio-inline">
                                <input type="radio" autocomplete="off" onChange="document.getElementById('loyalty_points').value='';" name="loyalty_points_type" id="per_order" value="per_order" {{ $coupon->loyalty_points_type == 'per_order' ? 'checked' : '' }} > per order / 1 tier 
                                </label><br/>
                                <label class="radio-inline">
                                <input type="radio" autocomplete="off" onChange="document.getElementById('loyalty_points').value='';" name="loyalty_points_type" id="tier_2" value="tier_2" {{ $coupon->loyalty_points_type == 'tier_2' ? 'checked' : '' }} > 2 tiers
                                </label><br/>
                                <label class="radio-inline">
                                <input type="radio" autocomplete="off" onChange="document.getElementById('loyalty_points').value='';" name="loyalty_points_type" id="tier_3" value="tier_3" {{ $coupon->loyalty_points_type == 'tier_3' ? 'checked' : '' }} > 3 tiers
                                </label><br/>
                            </div>
                        </div>
                        <div class="form-group loyalty_points_group">
                            <label for="loyalty_points" class="col-md-4 control-label general_loyalty_points">Loyalty Points</label>

                            <div class="col-md-6">
                                <input id="loyalty_points" type="text" class="form-control" name="loyalty_points" value="{{ $coupon->loyalty_points }}"  >
                            </div>
                        </div>
                         <div class="form-group loyalty_points_group">
                            <label for="min_purchase" class="col-md-4 control-label general_min_purchase">Minimum purchase value</label>

                            <div class="col-md-6">
                                <input id="min_purchase" type="text" class="form-control" name="min_purchase" value="{{ $coupon->min_purchase }}" required>
                            </div>
                        </div>
                        <div class="form-group loyalty_points_tier2_group">
                            <label for="loyalty_points_tier2" class="col-md-4 control-label">Tier 2 Loyalty Points</label>

                            <div class="col-md-6">
                                <input id="loyalty_points_tier2" type="text" class="form-control" name="loyalty_points_tier2" value="{{ $coupon->loyalty_points_tier2 }}"  >
                            </div>
                        </div>
                        <div class="form-group loyalty_points_tier2_group">
                            <label for="min_order_tier2" class="col-md-4 control-label">Tier 2 Order Minimum</label>
                            <div class="col-md-6">
                                <input id="min_order_tier2" type="text" class="form-control" name="min_order_tier2" value="{{ $coupon->min_order_tier2 }}"  >
                            </div>
                        </div>
                        <div class="form-group loyalty_points_tier3_group">
                            <label for="loyalty_points_tier3" class="col-md-4 control-label">Tier 3 Loyalty Points</label>

                            <div class="col-md-6">
                                <input id="loyalty_points_tier3" type="text" class="form-control" name="loyalty_points_tier3" value="{{ $coupon->loyalty_points_tier3 }}"  >
                            </div>
                        </div>
                        <div class="form-group loyalty_points_tier3_group">
                            <label for="min_order_tier3" class="col-md-4 control-label">Tier 3 Order Minimum</label>
                            <div class="col-md-6">
                                <input id="min_order_tier3" type="text" class="form-control" name="min_order_tier3" value="{{ $coupon->min_order_tier3 }}"  >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="influence_reward_rule_id" class="col-md-4 control-label">Influence Reward Rule Id</label>

                            <div class="col-md-6">
                                <input id="influence_reward_rule_id" type="text" class="form-control" name="influence_reward_rule_id" value="{{ $coupon->influence_reward_rule_id }}"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-md-4 control-label">Type</label>

                            <div class="col-md-6">
                                <input id="type" type="text" class="form-control" name="type" value="{{ $coupon->type }}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_active" class="col-md-4 control-label">Active</label>

                            <div class="col-md-6">
                                <input id="is_active" is_active="text" class="form-control" name="is_active" value="{{ $coupon->is_active ? 'Yes' : 'No' }}" readonly>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('msg_applied') ? ' has-error' : '' }}">
                            <label for="msg_applied" class="col-md-4 control-label">Message if Applied</label>

                            <div class="col-md-6">
                                <input id="msg_applied" type="text" class="form-control" name="msg_applied" value="{{ $coupon->msg_applied }}" required>

                                @if ($errors->has('msg_applied'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('msg_applied') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                         <div class="form-group{{ $errors->has('msg_not_applied') ? ' has-error' : '' }}">
                            <label for="msg_not_applied" class="col-md-4 control-label">Message if Not Applied</label>

                            <div class="col-md-6">
                                <input id="msg_not_applied" type="text" class="form-control" name="msg_not_applied" value="{{ $coupon->msg_not_applied }}" required>

                                @if ($errors->has('msg_not_applied'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('msg_not_applied') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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
