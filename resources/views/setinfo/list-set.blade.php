<x-layouts.app :title="__('Set Product Info')">
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <p class="text-right">
            <a class="btn btn-primary text-right" href="{{route('set-info.sync-plytix')}}">Sync with Plytix</a>
            <a class="btn btn-danger text-right" href="{{route('set-info.delete-all')}}">Delete all</a>
        </p>
            
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Set Product info</strong> ( Total: {{ $products->total() }} )</strong></div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Bc link</th>
                                <th>Plytix Link</th>
                                <th scope="col">Contains</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{$index + $products->firstItem() }}</td>
                                    <td>{{$product->sku}}</td>
                                    <td>
                                        @if($product->tb_url)
                                        <a target="_blank" href="{{$product->tb_url}}">TB</a> ,
                                        @endif
                                        @if($product->gi_url)
                                        <a target="_blank" href="{{$product->gi_url}}">GI</a> ,
                                        @endif
                                        @if($product->os_url)
                                        <a target="_blank" href="{{$product->os_url}}">OS</a>
                                        @endif
                                    </td>
                                    <td><a target="_blank" href="https://pim.plytix.com/products/{{$product->plytix_id}}/attributes">View in Plytix</a>
                                    </td>
                                    <td>
                                        @foreach ( $product->contains as $item )
                                            <a class="badge badge-secondary" style="font-size: 14px" href="https://pim.plytix.com/products/{{$item->plytix_id}}/attributes" target="_blank"> {{$item->sku}} </a>
                                            @if(!$loop->last)
                                            ,
                                            @endif 
                                        @endforeach

                                    </td>
                                <tr/>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>