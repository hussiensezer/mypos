$(document).ready(function(){

    // Add Product Btn
    $('.add-product-btn').on('click',function(e){
        e.preventDefault();

       var name = $(this).data('name');
        var  price = parseFloat($.number($(this).data('price'),2).replace(/,/g,'')) ;
        var   id = $(this).data('id');
        var stock = $(this).data('stock');
        var button = $(this).attr('id');

        $(this).removeClass('btn-primary').addClass('btn-default disabled');
        var html = `
                <tr id="product-row">
              
                <td>${name}</td>
                <td><input type="number"  name="products[${id}][quantity]" class="form-control product_quantity" min="1" max="${stock}" value="1" style="width:75px"></td>
                <td class="product_price" data-price="${price}">${$.number(price,2).replace(/,/g,'')}</td>
                <td class="product_total_price">${$.number(price,2).replace(/,/g,'')}</td>
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
        $(this).closest('tr').find('.product_total_price').html($.number(quantity * productPrice, 2));
        calculate_total();
    });// end product quantity
    calculate_total();

$('.order-products').on('click',function(e){
    e.preventDefault();

    $('#order-product-list').empty();
    $('#loading').css('display', 'flex');

    var link = $(this).data('link');
    var method = $(this).data('method');
    var button = $(this);
    var otherButton = $('.order-products');
   $.ajax({
        url:link,
        method:method,
       success(data) {
           $('#order-product-list').empty();
           $('#loading').css('display', 'none');
           $('#order-product-list').append(data);

            // otherButton.removeClass('disabled');
       }
   });
});// Show Details Of Order By Ajax Request

    $(document).on('click','.print',function (e) {
            e.preventDefault();
        $('#print_area').printThis({
            importCSS: true,            // import parent page css
            importStyle: false,         // import style tags
            printContainer: true,
            pageTitle: "فاتورة شراء منتجات" ,
            header: null,
            footer: null,
        });
    });

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

