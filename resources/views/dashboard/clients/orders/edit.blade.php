@extends('layouts.dashboard.app')

@section('content')


    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.edit_orders')</h1>

            <ol class="breadcrumb">

                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
                <li class="active"><a href="{{route('dashboard.orders.index')}}">@lang('site.orders')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>
        <section class="content">

            <div class="row">
                <!-- general form elements -->
                <div class=" col-md-6">
                    <div class="box  box-primary px-3 with-border " style="padding: 15px 5px;">
                        <div class=" box-header ">
                            <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.categories')</h3>
                        </div>
                        <div class="box-body">
                            @foreach($categories  as $category)

                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="title">
                                                <a href="#{{str_replace(' ','-',$category->name)}}" data-toggle="collapse"> {{$category->name}}</a>
                                            </h4><!--End H4 -->
                                        </div><!--End Panel Heading -->
                                        <div class="panel-collapse collapse" id="{{str_replace(' ','-',$category->name)}}">
                                            <div class="panel-body">
                                                @if($category->products->count() > 0)


                                                    <table class="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <td>@lang('site.product')</td>
                                                            <td>@lang('site.stock')</td>
                                                            <td>@lang('site.price')</td>
                                                            <td>@lang('site.add')</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($category->products as $product)
                                                            <tr>
                                                                <td>{{$product->name}}</td>
                                                                <td>{{$product->stock}}</td>
                                                                <td class="">{{number_format($product->sale_price,2)}}</td>
                                                                <td>
                                                                    <a
                                                                       id="product-{{$product->id}}"
                                                                       data-name="{{$product->name}}"
                                                                       data-id="{{$product->id}}"
                                                                       data-price="{{$product->sale_price}}"
                                                                       data-stock = "{{$product->stock}}"
                                                                       class="btn {{in_array($product->id , $order->products->pluck('id')->toArray()) ? 'btn-default disabled' :'btn-primary' }} btn-sm add-product-btn"
                                                                    >@lang('site.add')</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    @lang('site.no_record')
                                                @endif
                                            </div>

                                        </div>
                                    </div><!-- end Panel Info-->
                                </div><!--End Panel Group -->
                            @endforeach
                        </div>
                    </div><!-- End Boxs-->
                </div>
                <div class=" col-md-6">
                    <div class="box box-primary" style="padding: 15px 5px;">
                        <div class=" box-header with-border ">
                            <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.edit_orders')</h3>

                        </div>
                        <form action="{{ route('dashboard.clients.orders.update', ['order' => $order->id, 'client' => $client->id]) }}" method="post">

                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            @include('partials._errors')
                            <table class="table table-hover table-responsive ">
                                <thead>
                                <tr>
                                    <th>@lang('site.product')</th>
                                    <th>@lang('site.quantity')</th>
                                    <th>@lang('site.price')</th>
                                    <th>@lang('site.total')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody class="order-list">
                                    @foreach($order->products as $product)

                                        <tr>
                                        <tr id="product-row">

                                            <td>{{$product->name}}</td>
                                            <td><input type="number"  name="products[{{$product->id}}][quantity]" class="form-control product_quantity" min="1" max="{{$product->stock + $product->pivot->quantity}}" value="{{$product->pivot->quantity}}" style="width:75px"></td>
                                            <td class="product_price" data-price="${price}">{{number_format($product->sale_price,2)}}</td>
                                            <td class="product_total_price">{{number_format($product->sale_price * $product->pivot->quantity,2)}}</td>
                                            <td><button class="btn btn-danger btn-sm remove-product " data-nameid="product-${id}"><i class="fa fa-trash" ></i></button></td>
                                        </tr>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table><!-- End Table -->


                            <div>
                                <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.total') :- <span class="products_total"></span></h3>
                                <button class="btn btn-primary btn-bitbucket btn-orders btn-block" type="submit"><i class="fa fa-edit"></i>  @lang('site.edit_orders')</button>
                            </div>

                        </form>

                    </div>
                    @if($client->orders->count() > 0)
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title" style="margin-bottom :10px">
                                    @lang('site.previous_orders')
                                    <small>{{$orders->count()}}</small>
                                </h3>
                            </div>{{--End Box Header--}}
                            <div class="box-body">

                                @foreach($orders as $order)
                                    <div class="panel-group">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="#order{{$order->id}}" data-toggle="collapse">{{$order->created_at}}</a>
                                                </h4>
                                            </div>{{--End Panel Heading--}}
                                            <div class="panel-collapse  collapse" id="order{{$order->id}}">
                                                <div class="panel-body">
                                                    <ul class="list-group">
                                                        @foreach($order->products as $product)
                                                            <li class="list-group-item">{{$product->name}}</li>

                                                        @endforeach
                                                    </ul>{{--End uL--}}

                                                </div>{{--End Panel-Body--}}
                                            </div>{{--End Panel-collapse--}}
                                        </div>{{--End Panel-Success--}}
                                    </div>{{--End Panel-Group --}}
                                @endforeach
                            </div>
                        </div>{{--End Box-Primary--}}
                    @else
                        <h2>@lang('site.no_previous_orders')</h2>
                    @endif

                </div>
            </div>
        </section>



    </div><!-- end of content wrapper -->


@endsection

@push('scripts')



@endpush
