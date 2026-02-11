<x-layouts.app :title="__('Banner Settings')">
<div class="container">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Banner Settings')}}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Manage banner header settings') }}</p>
    </div>
        <div class="col-md-8 col-md-offset-2">
        @if($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <div class="p-6">
                    <form class="" action="{{ route('banner-settings.update') }}" method="POST">
                        {{ csrf_field() }}
                        @foreach($bannerSettings as $index => $item)
                        <div class="mb-4">
                                <label for="bannerSettings_{{$item->id}}">{{$item->name}} : @if($item->status) Active @endif</label>
                                <input type="hidden" value="{{$item->id}}" name="bannerSettings[{{$index}}][id]" >

                                <div class="flex items-center gap-2">
                                    <x-forms.switch label="" name="bannerSettings[{{$index}}][status]" value="1" checked="{{ $item->status ? 'checked' : '' }}" />
                                    <x-forms.input label="" name="bannerSettings[{{$index}}][value]" type="text" value="{{ $item->value }}" />
                                </div>
                        </div>  
                        @endforeach

                        <div class="mt-6">
                            <x-button type="primary">{{ __('Update Settings') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
</x-layouts.app>
