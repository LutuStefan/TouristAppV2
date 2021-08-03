var _start, _end;

$(function() {
    $('input[name="daterange"]').daterangepicker({
        drops: 'down',
        minDate: Today()
    }, function(start, end, label) {
        _start = start.format('YYYY-MM-DD');
        _end = end.format('YYYY-MM-DD');
    });
});

function Today() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    return today = mm + '-' + dd + '-' + yyyy;
}

$('.sort-by-rating').on('click', function () {
    var stars = $('.sort-by-rating');
    selectedStar = $(this).index('.fa-star') + 1;

    for(let i=0; i<stars.length; i++) {
        if(i < selectedStar) {
            $(stars[i]).addClass('checked');
        } else {
            $(stars[i]).removeClass('checked');
        }
    }
});

$('#filter').on('click', function () {
    // console.log(_start, _end, $('#filter-by-name').val());
    let nameOrAddress = $('#filter-by-name').val(),
        nrOfStars = $('.filter-rating-container .checked').length,
        price = $('#filter-by-price').val();


    var url = new URL(window.location.origin);
    if(_start && _end) {
        url.searchParams.set('start', _start);
        url.searchParams.set('end', _end);
    }
    if(nameOrAddress) {
        url.searchParams.set('nameOrAddress', nameOrAddress);
    }
    if(nrOfStars) {
        url.searchParams.set('nrOfStars', nrOfStars);
    }
    if(price) {
        url.searchParams.set('price', price);
    }


    // console.log(_start, _end, nameOrAddress, nrOfStars);
    window.location.href = url.href;
});
