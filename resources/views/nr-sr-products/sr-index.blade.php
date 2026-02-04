<x-layouts.app :title="__('State Restricted Products List')">

<div class="container">
    <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
            <li class="active"><a href="{{route('nrandsrproducts.sr_index')}}">State Restricted Products</a></li>
            <li><a href="{{route('nrandsrproducts.nr_index')}}">Non - Returnable Products</a></li>
            <li><a href="{{route('nrandsrproducts.publish')}}" target="_blank">Publish</a></li>
            <li class=""><a href="{{route('nrandsrproducts.re_publish')}}" target="_blank">Re-publish</a></li>
        </ul>
    </nav>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif  
            @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif    

        <div class="panel panel-default">
            <div class="panel-heading">Data Import</div>
            <div class="panel-body">
            <form action="{{ route('nrandsrproducts.sr_import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}  
                <input type="file" name="file" accept=".csv">
                <br/>
                <button type="submit" class="btn btn-primary">Import CSV</button>
            </form>
            </div>
        </div>

        <div class="panel panel-default">
                <div class="panel-heading">State Restricted Products List  ( Total : {{$items->total()}} )</div>
                
                <div class="panel-body">
                <form action="{{route('nrandsrproducts.sr_index')}}" method="get">
                    <div class="form-group">    
                        <label for="inputSearch">Search</label>
                        <input type="text" value="{{request('query')}}" class="form-control" name="query" />
                    </div> 
                    <p class="text-right">   
                        <a href="{{route('nrandsrproducts.sr_index')}}" class="btn btn-default">Clear</a> 
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </p>
                </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">SKU</th>
                                <th scope="col">State Code</th>
                                <th scope="col">Published</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{$index + $items->firstItem() }}</td>
                                    <td>{{$item->sku}}</td>
                                    <td>{{$item->state_code}}</td>
                                    <td>{{ $item->published ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $items->links() }}
                    </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
