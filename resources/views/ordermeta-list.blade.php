<x-layouts.app :title="__('Order Metafields')">

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif    
        <div class="panel panel-default">
                <div class="panel-heading">{{ ucfirst($resource) }} Metafields </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Key : value</th>
                                <th scope="col">{{ucfirst($resource)}} </th>
                                <th scope="col" width="200px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php($i = 1)
                          @foreach($orderMetaFeilds as $resource_id => $orderMetaFeild)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>
                                    @foreach($orderMetaFeild as $item)
                                        {{$item['key']}} : {{$item['value']}}<br/>
                                    @endforeach
                                    </td>
                                    <td>{{$resource_id}}</td>
                                    <td class="">
                                        <form class="inline-form" method="POST" action="{{route('ordermeta.delete' ,['resource'=> $resource , 'resource_id'=> $resource_id])}}" onsubmit="return confirm('Are you sure you want to delete this item?');" >
                                           {{ method_field('delete') }}
                                           {{ csrf_field() }}
                                            @foreach($orderMetaFeild as $item)
                                            <input name="metafieldsId[]" type="hidden" value="{{$item['id']}}">
                                            @endforeach
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
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
