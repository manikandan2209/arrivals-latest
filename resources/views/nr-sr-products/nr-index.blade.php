<x-layouts.app :title="__('Non Returnable Products')">

<div class="container">
    <nav class="navbar navbar-default">
        <div class="flex items-center gap-2 mb-4">
            <x-button type="primary" href="{{route('nrandsrproducts.publish')}}" tag="a" class="ml-2" target="_blank">Publish</x-button>
            <x-button type="primary" href="{{route('nrandsrproducts.re_publish')}}" tag="a" class="ml-2" target="_blank">Re-publish</x-button>
        </div>
    </nav>
            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <x-panel paneltitle="Data Import" >
            <form action="{{ route('nrandsrproducts.nr_import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}  
                <x-forms.input label=" " name="file" accept=".csv" type="file" class="w-[500px] mb-4"/>
                <x-button type="primary" class="mb-2" buttontype="submit">Import CSV</x-button>
            </form>
        </x-panel>

        <x-panel paneltitle="Non Returnable Products List  ( Total : {{$items->total()}} )" active>
                <div class="panel-body">

                <div class="flex items-center gap-2 mb-4">
                <x-forms.search class="w-[500px]" action="{{route('nrandsrproducts.nr_index')}}" name="query" value="{{request('query')}}" placeholder="Search by SKU or Non returnable code" />
                <x-button type="secondary" tag="a" href="{{route('nrandsrproducts.nr_index')}}" >Clear</x-button>
                </div>
    
                    <x-table.table paneltitle="Non Returnable Products List">
                        <x-slot name="tbhead">
                            <tr>
                                <th class="px-4 py-2" scope="col">#</th>
                                <th class="px-4 py-2" scope="col">SKU</th>
                                <th class="px-4 py-2" scope="col">No returnable Code</th>
                                <th class="px-4 py-2" scope="col">Published</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbbody">
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{$index + $items->firstItem() }}</td>
                                    <td>{{$item->sku}}</td>
                                    <td>{{$item->non_returnable_code}}</td>
                                    <td>{{ $item->published ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table.table>
                    {{ $items->links() }}
                    </div>
            </x-panel>
</div>
</x-layouts.app>
