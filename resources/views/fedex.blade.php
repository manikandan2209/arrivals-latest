<x-layouts.app :title="__('FedEx Settings')">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Shipping Cutoff Time')}}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Set cutoff time shipping') }}</p>
    </div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="row" action="{{ route('fedex.update') }}" method="POST">
            {{ csrf_field() }}
             <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <?php $i = 0; ?>
                        @foreach($settings as $index => $item)
                        <div class="">
                                <label for="fedex_{{$item->id}}">{{$item->label}} : </label>
                                <input type="hidden" value="{{$item->id}}" name="fedex[{{$i}}][id]" >
                                <select name="fedex[{{$i}}][value]" id="fedex_{{$item->id}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-[200px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                    <option value="fedex" {{$item->value == 'fedex' ? 'selected' : ''}}>Fedex</option>
                                    <option value="ups" {{$item->value == 'ups' ? 'selected' : ''}}>UPS</option>
                                </select>
                        </div>
                        <?php $i++; ?>
                        @endforeach
                </div>
            </div>
            <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Shipping Cutoff Time Settings</h2>
                            
                            @foreach($cutoff as $index => $item)
                                <div class="mb-4">
                                    <input type="hidden" value="{{$item->id}}" name="fedex[{{$i}}][id]" >
                                    <x-forms.timepicker  label="{{$item->label}}" name="fedex[{{$i}}][value]" value="{{$item->value}}" />
                                </div>
                                <?php $i++; ?>
                            @endforeach
                            <div class="mt-6 flex items-center gap-4">
                                <x-button type="primary">{{ __('Update Settings') }}</x-button>
                                <x-button type="secondary" tag="a" href="{{route('fedex.cache-clean')}}" >Clear Cache</x-button>
                                </div>
                    </div>
                </div>
            </div>
           
            </form>
        </div>
        
    </div>
</div>
</x-layouts.app>
