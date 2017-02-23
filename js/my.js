$(document).ready(function () {
    $(".chosen").chosen();
    $("#region").on("change", "select", function () {
        var id = $(this).attr("id");
        var value = $("#" + id + " option:selected").val();
        var data = {
            id: id,
            val: value
        };
        $("#" + id).next().nextAll().remove();
        $("#listmsg").text('');
        $.post("/user/region", JSON.stringify(data)).done(function (data) {
            if (data.length > 0) {
                var newData = JSON.parse(data);
                $('#region').append('<br>');
                $('#region').append(newData.list);
                $(".chosen").chosen();
            }
        });
    });
    $("#submit").on("click", function () {
        var ok = 0;
        var email = $('#email').val();
        var name = $('#name').val();
        var list = $('#region select').last().val();
        var emailval = /^(\w+([\.\w+])*)@\w+(\.\w+)?\.\w{2,3}$/i;
        var nameval = /^[a-zA-Zа-яА-Я\s]+$/i;
        if (emailval.test(email)) {
            $('#emailmsg').text('ok');
            ok++;
        } else {
            $('#emailmsg').append().text('nope');
        }
        if (nameval.test(name)) {
            $('#namemsg').text('ok');
            ok++;
        } else {
            $('#namemsg').append().text('nope');
        }
        if (list !== '0') {
            $('#listmsg').text('ok');
            ok++;
        } else {
            $('#listmsg').append().text('nope');
        }
        if (ok === 3) {
            var data = $('#regform').serializeArray();
            $.post("/user/save", JSON.stringify(data)).done(function (data) {
                if (data.length > 0) {
                    var newData = JSON.parse(data);
                    $('#registration').empty();
                    $('#registration').append($('<p></p>').text(newData.name),
                            $('<p></p>').text(newData.email),
                            $('<p></p>').text(newData.address),
                            $('<p></p>').text(newData.msg));
                }
            });
        }

    });

});