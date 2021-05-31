@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.add_orders')</h1>

            <ol class="breadcrumb">

                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
                <li class="active">@lang('site.orders')</li>
                <li class="active">@lang('site.add')</li>
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
                                                            <td>@lang('site.name')</td>
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
                                                            <td>{{$product->sale_price}}</td>
                                                            <td>
                                                                <a class="btn btn-primary btn-sm add-product-btn"
                                                                    id="product-{{$product->id}}"
                                                                   data-name="{{$product->name}}"
                                                                   data-id="{{$product->id}}"
                                                                   data-price="{{$product->sale_price}}"
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
                            <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.orders')</h3>

                        </div>
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

                            </tbody>
                        </table><!-- End Table -->


                            <div>
                                <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.total') :- <span class="products_total"></span></h3>
                                <button class="btn btn-primary btn-bitbucket btn-orders "><i class="fa fa-plus"></i>  @lang('site.add_orders')</button>
                            </div>


                    </div>
                </div>
            </div>
        </section>



    </div><!-- end of content wrapper -->


@endsection

@push('scripts')



@endpush
