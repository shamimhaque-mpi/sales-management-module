
const calculateItemWiseTotalPrice = ()=>{

    var grand_total = 0;
    var total_discount_amount = 0;
    $('#itemsContainer .item-row').each((index, ele)=>{
        const price     = +$(ele).find('.price-input').val();
        const quantity  = +$(ele).find('.quantity-input').val();
        const discount  = +$(ele).find('.discount-input').val();

        const subtotal = price * quantity;
        const discountAmount = subtotal * ((discount||0) / 100);
        const total = subtotal - discountAmount;

        total_discount_amount += discountAmount;
        grand_total += total;

        $(ele).find('.sub-total-input').val(total)
    })

    $('#total_discount').text(total_discount_amount);
    $('#grand_total').text(grand_total);
}






$('#addItem').on('click', function () {
    const $container = $('#itemsContainer');
    const template = $('#productRowTemplate')[0].content.cloneNode(true);
    $container.append(template);
});

$(document).on('change', '.product-select', function () {
    const price = $(this).find('option:selected').data('price');
    $(this).closest('.item-row').find('.price-input').val(price);
    calculateItemWiseTotalPrice();
});

$(document).on('click', '.removeItem', function () {
    $(this).closest('.item-row').remove();
});







$('#saleForm').on('submit', async function(e) {
    
    e.preventDefault();


    $('#globalErrors').addClass('hidden');
    const formData = new FormData(this);

    let response = await fetch($('#saleForm').attr('action'), {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    });



    let data = await response.json();

    if (response.ok) {
        alert('Success:', data);
        window.location.reload();
    } 
    else {
        const errors = data.errors;
        const $errorList = $('#errorList');

        $errorList.empty();
        $('#globalErrors').addClass('hidden');

        $.each(errors, function(_, messages) {
            $.each(messages, function(_, msg) {
                $('<li>').text(msg).appendTo($errorList);
            });
        });

        $('#globalErrors').removeClass('hidden');
    }
});