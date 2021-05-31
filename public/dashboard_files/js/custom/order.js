$(document).ready(function(){

    // Add Product Btn
    $('.add-product-btn').on('click',function(e){
        e.preventDefault();

       var name = $(this).data('name');
        var  price = parseFloat($.number($(this).data('price'),2).replace(/,/g,'')) ;
        var   id = $(this).data('id');
        var button = $(this).attr('id');

        $(this).removeClass('btn-primary').addClass('btn-default disabled')
        var html = `
                <tr id="product-row">
                <td>${name}</td>
                <td><input type="number"  name="quanities[]" class="form-control product_quantity" min="1" value="1" style="width:75px"></td>
                <td class="product_price" data-price="${price}">${price}</td>
                <td class="product_total_price">${price}</td>
                <td><button class="btn btn-danger btn-sm remove-product " data-nameid="product-${id}"><i class="fa fa-trash" ></i></button></td>
                </tr>
        `;
        $('.order-list').append(html);
        calculate_total();
    });// end of create table

    // Disabled Btn
    $('body').on('click','.btn-default',function(e){
       e.preventDefault();
    });// End Of Disabled
    //Remove Product BTN
    $('body').on('click','.remove-product',function(e){
        e.preventDefault();
        var id = $(this).data('nameid');
        $(this).closest('tr').remove();
        $('#' + id).removeClass('btn-default disabled').addClass('btn-primary');
        calculate_total();

    });// end of remove product
    //Change Product Quantity
    $('body').on('change','.product_quantity',function(){

        var quantity = parseFloat($(this).val());
        var productPrice = parseFloat($(this).closest('tr').find('.product_price').html());
        $(this).closest('tr').find('.product_total_price').html(quantity * productPrice);
        calculate_total();
    });// end product quantity
    calculate_total();
});
// Calculate Total Price
function calculate_total() {
    var price = 0 ;
    var total = $('.order-list .product_total_price');
    var row = $('tbody.order-list');

    // Check If The Tbody Have Child  Or Not
    if(row.children().length < 1) {
        $('.products_total').html(price);

    }else {
        total.each(function(index){

            price += parseFloat($(this).html().replace(/,/g,''));
            $('.products_total').html($.number(price,2));
        });
    }

   if(price > 0) {

       $('.btn-orders ').removeClass('disabled');
   }else {
       $('.btn-orders ').addClass('disabled');

   }


}

