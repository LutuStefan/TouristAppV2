// $('#save-hotel').on('click', function () {
//     var hotelName = $('#hotel-name').val(),
//         hotelDescription = $('textarea').val(),
//         country = $('#country').val(),
//         city = $('#city').val(),
//         address = $('#address').val(),
//         price = $('#price').val();
//
//     $.ajax({
//         url: "/save-hotel",
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {
//             name: hotelName,
//             description: hotelDescription,
//             stars: selectedStar,
//             country: country,
//             city: city,
//             address: address,
//             price: price
//         },
//         success: function(result){
//             if(result !== 'error') {
//                 if(!result.fail) {
//                     hotelId = result;
//                     $('#error-section').html('').hide();
//                     $('.alert.alert-success').show().hide(1000);
//                 } else {
//                     let errors = Object.keys(result.errors).map(function(key) {
//                         return [key, result.errors[key][0]];
//                     });
//                     $('#error-section').html('');
//                     for(let i=0; i<errors.length; i++) {
//                         $('#error-section').append('<li>' + errors[i][1] + '</li>');
//                     }
//                 }
//             }
//         },
//         error: function (e) {
//             // console.log(e);
//         }
//     });
// });

$('#add-picture').on('click', function ()
{
    var fd = new FormData();
    var image = $('#hotel-img')[0].files[0];

    fd.append('image', image);
    fd.append('hotelId', hotelId);

    $.ajax({
        url: "/accommodation-store-img",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: fd,
        contentType: false,
        processData: false,
        success: function(result){
            let img = document.createElement("DIV");
            img.innerHTML = result;
            $("#added-images-section")[0].appendChild(img);
        },
        error: function (e) {
            // console.log(e);
        }
    });
});

$('.fa-star').on('click', function () {
    var stars = $('.fa-star');
    selectedStar = $(this).index('.fa-star') + 1;

    for(let i=0; i<stars.length; i++) {
        if(i < selectedStar) {
            $(stars[i]).addClass('checked');
        } else {
            $(stars[i]).removeClass('checked');
        }
    }
    $('#stars').val(selectedStar);
});
