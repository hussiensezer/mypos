

            <table class="table table-hover table-responsive ">
                <thead>
                <tr>
                    <th>@lang('site.product')</th>
                    <th>@lang('site.quantity')</th>
                    <th>@lang('site.price')</th>
                    <th>@lang('site.total')</th>

                </tr>
                </thead>
                <tbody class="order-list">
                        @foreach($products as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->pivot->quantity}}</td>
                                    <td>{{number_format($product->sale_price,2)}}</td>
                                    <td>{{number_format($product->pivot->quantity * $product->sale_price,2)}}</td>

                                </tr>
                        @endforeach
                </tbody>
            </table><!-- End Table -->


            <div>
                <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.total') :- {{ number_format($order->total_price, 2) }} <span class="products_total"></span></h3>

            </div>



