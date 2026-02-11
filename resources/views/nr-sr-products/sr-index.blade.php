<x-layouts.app :title="__('State Restricted Products List')">

<div class="container">
        <div class="flex items-center gap-2 mb-4">
            <x-button type="primary" href="{{route('nrandsrproducts.publish')}}" tag="a" class="ml-2" target="_blank">Publish</x-button>
            <x-button type="primary" href="{{route('nrandsrproducts.re_publish')}}" tag="a" class="ml-2" target="_blank">Re-publish</x-button>
        </div>

            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <x-panel paneltitle="Data Import" >
            <form action="{{ route('nrandsrproducts.sr_import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} 
                <x-forms.input label=" " name="file" accept=".csv" type="file" class="w-[500px] mb-4"/>
                <x-button type="primary" class="mb-2" buttontype="submit">Import CSV</x-button>
            </form>
        </x-panel>

        <x-panel paneltitle="State Restricted Products List  ( Total : {{$items->total()}} )" active>
                <div class="panel-body">
                    <div class="flex items-center gap-2 mb-4">
                    <x-forms.search class="w-[500px]" action="{{route('nrandsrproducts.sr_index')}}" name="query" value="{{request('query')}}" placeholder="Search by SKU" />
                    <x-button type="secondary" tag="a" href="{{route('nrandsrproducts.sr_index')}}" >Clear</x-button>
                    </div>
                    <x-table.table>
                        <x-slot name="tbhead">
                            <tr>
                                <th class="px-4 py-2" scope="col">#</th>
                                <th class="px-4 py-2" scope="col">SKU</th>
                                <th class="px-4 py-2" scope="col">State Code</th>
                                <th class="px-4 py-2" scope="col">Published</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbbody">
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{$index + $items->firstItem() }}</td>
                                    <td>{{$item->sku}}</td>
                                    <td>{{$item->state_code}}</td>
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
