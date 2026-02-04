<x-layouts.app :title="__('Plytix Settings')">
<div class="container">
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif

            <div class="panel panel-default">
                <div class="panel-heading"><strong>PlytixSettings</strong></div>

                <div class="panel-body">
                    
                    <form class="row" action="{{ route('plytix.update') }}" method="POST">
                        {{ csrf_field() }}
                        @foreach($plytixSettings as $index => $item)
                        <div class="col-md-12">
                                <div class="col-sm-3">
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
                                <div class="col-sm-6">
                                    <input type="hidden" value="{{$item->id}}" name="plytixSettings[{{$index}}][id]" >
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="plytixSettings[{{$index}}][value]" @if($item->value) checked @endif value="1" > Use site based images from plytix
                                            </label>
                                        </div>
                                </div>
                                <div class="col-sm-3">
                                @if ($item->site == 'tb')
                                    <a class="btn btn-danger" href="https://arrivals.tonerbuzz.com/plytix/restore-default-images.php?site=toner_buzz" target="_blank" onclick="return confirm('Are you sure you want to restore all the images with use custom image flag is true?');" >Restore images</a>
                                @elseif ($item->site == 'gi')
                                    <a class="btn btn-danger" href="https://arrivals.tonerbuzz.com/plytix/restore-default-images.php?site=genuine_ink" target="_blank" onclick="return confirm('Are you sure you want to restore all the images with use custom image flag is true?');" >Restore images</a>
                                @elseif ($item->site == 'os')
                                    <a class="btn btn-danger" href="https://arrivals.tonerbuzz.com/plytix/restore-default-images.php?site=original_supplies" target="_blank" onclick="return confirm('Are you sure you want to restore all the images with use custom image flag is true?');" >Restore images</a>
                                @elseif ($item->site == '123_office')
                                    <a class="btn btn-danger" href="https://arrivals.tonerbuzz.com/plytix/restore-default-images.php?site=123_office" target="_blank" onclick="return confirm('Are you sure you want to restore all the images with use custom image flag is true?');" >Restore images</a>
                                @endif
                                </div>
                        </div>  
                        @endforeach

                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <button class="btn btn-style-1 btn-primary" type="submit" data-toast="" data-toast-position="topRight" data-toast-type="success" data-toast-icon="fe-icon-check-circle" data-toast-title="Success!" data-toast-message="Your profile updated successfuly.">Update Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
</x-layouts.app>
