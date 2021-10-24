$('#user-profile-picture, #add-user-img').hover( function () {
    $('#user-profile-picture').css('opacity', 0.2);
    $('#add-user-img').show().css('opacity', 0.7);
});

$('#user-profile-picture, #add-user-img').mouseout( function () {
    $(this).css('opacity', 'unset');
    $('#add-user-img').hide().css('opacity', 'unset');
});

$('#add-user-img-input').on('change', function () {
    var fd = new FormData();
    var image = $(this)[0].files[0];
    console.log(image);
    fd.append('image', image);
    fd.append('userId', $('#userId').val());
    $.ajax({
        url: "/save-profile-picture",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: fd,
        // cache:false,
        contentType: false,
        processData: false,
        success: function(result){
            let img = document.createElement("IMG");
            $('#user-profile-picture')[0].src = result;
            $('#add-user-img').hide().css('opacity', 'unset');
            $('#user-profile-picture, #add-user-img').css('opacity', 'unset');
        },
        error: function (e) {
            // console.log(e);
        }
    });
});

$('#save-user-data').on('click', function () {
    var userName =  $('#username').val(),
        userEmail = $('#email').val(),
        userPhone = $('#phone').val(),
        userId = $('#userId').val();

    $.ajax({
        url: "/update-user-data",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            userName: userName,
            userEmail: userEmail,
            userPhone: userPhone,
            userId: userId
        },
        success: function(result){
            console.log(result);
            $('#change-status').text(result).show();
            setTimeout(function () {
                $('#change-status').hide().text('');
            }, 3000);
        },
        error: function (e) {
            // console.log(e);
        }
    });
});
