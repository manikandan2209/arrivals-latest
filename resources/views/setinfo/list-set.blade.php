<x-layouts.app title="__('Set Product Info')">
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <p class="flex gap-2 mb-4 justify-end">
            <x-button type="primary" href="{{route('set-info.sync-plytix')}}" tag="a" >Sync with Plytix</x-button>
            <x-button type="danger" href="{{route('set-info.delete-all')}}" tag="a" >Delete all</x-button>
        </p> 
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 p-4  ">
                <div class="panel-heading mb-4 font-bold">Set Product info</div>
                <div class="panel-body">
                    <table class="w-full text-sm text-left rtl:text-right text-body mb-4">
                        <thead class="text-sm bg-neutral-secondary-medium border-b border-default-medium">
                            <tr class="text-left">
                                <th class="px-6 py-3 font-bold text-left"  scope="col">#</th>
                                <th class="px-6 py-3 font-bold text-left"  scope="col">SKU</th>
                                <th class="px-6 py-3 font-bold text-left"  scope="col">Bc link</th>
                                <th class="px-6 py-3 font-bold text-left"  scope="col">Plytix Link</th>
                                <th class="px-6 py-3 font-bold text-left"  scope="col">Contains</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr class="bg-neutral-primary-soft border-b  border-default-medium">
                                    <td class="px-6 py-2">{{$index + $products->firstItem() }}</td>
                                    <td class="px-6 py-2">{{$product->sku}}</td>
                                    <td class="px-6 py-2">
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
                                    <td class="px-6 py-2"><a target="_blank" href="https://pim.plytix.com/products/{{$product->plytix_id}}/attributes">View in Plytix</a>
                                    </td>
                                    <td class="px-6 py-2">
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