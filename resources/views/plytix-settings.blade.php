<x-layouts.app :title="__('Plytix Settings')">
<div class="container">
   
        @if($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
            <x-panel paneltitle="Plytix Settings">

                <div class="panel-body">
                    
                    <form class="row" action="{{ route('plytix.update') }}" method="POST">
                        {{ csrf_field() }}
                        @foreach($plytixSettings as $index => $item)
                        <div class="mb-4 flex gap-2 items-center">
                                <div class="w-[200px]">
                                <div class="checkbox">
                                @if ($item->site == 'tb')
                                    <span>Tonnerbuzz</span>
                                @elseif ($item->site == 'gi')
                                    <span>Genuine Ink</span>
                                @elseif ($item->site == 'os')
                                    <span>Original supplies</span>
                                @elseif ($item->site == '123_office')
                                    <span>123 office</span>
                                @endif
                                </div>
                                </div>
                                <div class="">
                                    <input type="hidden" value="{{$item->id}}" name="plytixSettings[{{$index}}][id]" >
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="plytixSettings[{{$index}}][value]" @if($item->value) checked @endif value="1" > Use site based images from plytix
                                            </label>
                                        </div>
                                </div>
                                <div class="col-sm-3"> 
                                @if ($item->site == 'tb')
                                   <?php $uri = "toner_buzz" ?>
                                @elseif ($item->site == 'gi')
                                    <?php $uri = "genuine_ink" ?>
                                @elseif ($item->site == 'os')
                                    <?php $uri = "original_supplies" ?>
                                @elseif ($item->site == '123_office')
                                   <?php $uri = "123_office" ?>
                                @endif
                                <x-button type="danger" tag="a" class="w-[150px]" href="https://arrivals.tonerbuzz.com/plytix/restore-default-images.php?site={{$uri}}" target="_blank" onclick="return confirm('Are you sure you want to restore all the images with use custom image flag is true?');">Restore images</x-button>
                                </div>
                        </div>  
                        @endforeach

                        <div class="mt  -4 inline-block">
                            <x-button type='primary' buttontype="submit">Update Settings</x-button>
                        </div>
                    </form>
                </div>
            </x-panel>

</div>
</x-layouts.app>
