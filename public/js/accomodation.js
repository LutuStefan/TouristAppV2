var _start, _end;

$('.carousel').carousel({
    interval: 5000
});

$(function() {
    $('input[name="daterange"]').daterangepicker({
        drops: 'up',
        minDate: Today(),
        isInvalidDate: function (date) {
            let dd = String(date._d.getDate()).padStart(2, '0'),
                mm = String(date._d.getMonth() + 1).padStart(2, '0'),
                yyyy = date._d.getFullYear();

            for(let i=0; i<bookings.length; i++) {
                if(yyyy+'-'+mm+'-'+dd <= bookings[i].b_end_date && yyyy+'-'+mm+'-'+dd >= bookings[i].b_start_date) {
                    return true
                }
            }

            return false;
        }
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

$('#confirm-reservation').on('click', function () {
    var userId = $('#userID').val(), hotelId;

    var url_string = window.location.href;
    var url = new URL(url_string);
    hotelId = url.searchParams.get("hotel");

    $.ajax({
        method: "POST",
        url: '/make-booking',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            start: _start,
            end: _end,
            userId: userId,
            hotelId: hotelId
        },
        success: function(response){
            if(response !== 'error') {
                $('.booking-success').show();
                setTimeout(function(){ $('.booking-success').hide(); }, 3000);
            } else {
                $('.booking-fail').show();
                setTimeout(function(){ $('.booking-fail').hide(); }, 3000);
            }
        }
    });
});
