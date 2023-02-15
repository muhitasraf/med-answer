@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>

    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-3">
                    <select name="variant" id="" class="form-control">
                        <option class="test-bold">--Select A Varian--</option>
                        @foreach ($all_variants as $variant)
                            <optgroup label="&nbsp;&nbsp;{{$variant->title}}">
                                @foreach ($all_variant_tags as $variant_tag)
                                    @if ($variant->id==$variant_tag->variant_id)
                                        <option value="{{$variant_tag->variant_id}}">&nbsp;&nbsp;&nbsp;{{$variant_tag->variant}}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" value="{{old('price_from')}}" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th width="150px">Description</th>
                            <th>Variant</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key=>$product)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $product->title }} <br> Created at : <br>{{ $product->created_at->format('d-F-Y') }}</td>
                                <td>{{ Str::limit(strip_tags($product->description),100,'......')  }}</td>
                                <td>
                                    @foreach ($product->product_variant_price as $variant)
                                        <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                            <dt class="col-sm-4 pb-0">
                                                {{ $variant->varients_one->variant??'' }}/{{ $variant->varients_two->variant??'' }}/{{ $variant->varients_three->variant??''  }}
                                            </dt>
                                            <dd class="col-sm-8">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-6 pb-0">Price : {{ $variant->price }}</dt>
                                                    <dd class="col-sm-6 pb-0">InStock : {{ $variant->stock }}</dd>
                                                </dl>
                                            </dd>
                                        </dl>
                                    @endforeach
                                    <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}</p>
                </div>
                <div class="col-md-6 d-flex flex-row-reverse">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>

    <style>
        .test-bold{
            font-weight:bold !important;
        }
    </style>

@endsection
