$(function(){

    // show menu bar on mobiles
    $('#but').click(function(){
        $('#lst').toggle();
    });

    function getCookie(cookieName) {
        var cookies = document.cookie.split("; ");
            for (var i = 0; i < cookies.length; i++) {
            if (cookies[i].split("=")[0] === cookieName)
                return cookies[i].split("=")[1];
        }
    }

    function tgOption(event) {
        var cldID = event.target.id;
        switch (cldID) {
            case 'login' :
                var sd = '#login-o-b';
                var conId = '#login-con';
                break;
            case 'register' :
                var conId = '#register-con';
                var sd = '#register-o-b';
                break;
            case 'login-o-b' :
                var sd = '#login-o-b';
                var conId = '#login-con';
                break;
            case 'register-o-b' :
                var conId = '#register-con';
                var sd = '#register-o-b';
                break;
        }
        $(sd).addClass('selected').siblings().removeClass('selected');
        $(conId).css('display', 'block').siblings().css('display', 'none');
        $(conId+' input:first').focus();
        $(conId+' form').trigger('reset');
        $('.callback-info').text('');
    }

    // hide login wrapper
    $('#login_wrapper').click(function(event){
        if (event.target.id=='login_wrapper'){
            $('#login_wrapper').fadeOut('slow');
            $('#login-box').slideUp('fast');
            $('[name="regi"], [name="logi"]').trigger('reset');
            $('.callback-info').text('');
        }
    });

    // login/register header button
    $('.lr-btn').click(function(event){
        $('#login_wrapper').fadeIn(600);
        $('#login-box').slideDown(250);
        tgOption(event);
    });

    // .
    $('#login, #register, #login-o-b, #register-o-b').click(function (event) {
        tgOption(event);
    });

    // episodes browsing, submit selected values;
    $('#eps-sons-submit').click(function(){
        $('#eps-brws').submit();
    });

    // login/inscription AJAX
    $('.login-but[type=submit]').click(function(event){
        event.preventDefault();
    });


    $('#regibut').click(function(){
        $('#register-con').toggle();
        $('#login-box .loading-wr').toggle();
        $.post('system/set.php', {Uname: $('[name="Uname"]').val(), Umail: $('[name="Umail"]').val(), Upass: $('[name="Upass"]').val()}, function(data){
            $('#register-con').toggle();
            $('#login-box .loading-wr').toggle();
            $('#register-con .callback-info').html(data);
        })
    });

    $('#logibut').click(function(){
        $('#login-con').toggle();
        $('#login-box .loading-wr').toggle();
        $.post('system/do.php', {Uusername: $('[name="Uusername"]').val(), Upassword: $('[name="Upassword"]').val()}, function(data){
            $('#login-con').toggle();
            $('#login-box .loading-wr').toggle();
            $('#login-con .callback-info').text(data);
            if(data=='connection succeeded')
                location.reload(true);
        });
    });

    // logout
    $('#logout').click(function(event){
        event.preventDefault();
        $.get('system/do.php', {logout: getCookie("token")}, function(data){
            alert(data)
            location.reload(true);
        });
    });

    // submit comment

        // prevent default actions
    $('#d-cs-f input').click(function(event) {
        event.preventDefault();
    });

    $('#addc').click(function(){
        var comTxt = $('[name="comm-text"]').val();
        if (comTxt.length >= 10) {
            $.post('system/set.php', {comment: comTxt, ep: window.location.href.split('?e=')[1], token: getCookie("token")}, function(data){
                $('.add-comm .callback-info').html(data);
                if (data=='added') {
                    var elm = $('.comm-box:first').clone();
                    $(elm).find('.comadav').attr('src', '');
                    $(elm).find('.comadna').text('you');
                    $(elm).find('.comadna').attr('href', 'user');
                    $(elm).find('.comdaad').text(new Date());
                    $(elm).find('.comm-body p').html(comTxt);
                    $(elm).insertBefore("#moco");
                    elm.find('.comm-elements').css('background', 'rgb(234, 228, 240)').delay(500).queue(function() {
                        $(this).css('background', 'inherit');
                    });
                    $('#d-cs-f').trigger('reset');
                };
            });
        } else
            $('.add-comm .callback-info').html('comment is too short!');
    });

    // load comments
    var n = 1;
    $('#moco').click(function(){
        $('#moco').text('loading comments...');
        $.get('', {moco: null, n: n++}, function(data){
            if (data != '') {
                for (var i = 0; i < data.length; i++) {
                    var elm = $('.comm-box:first').clone();
                    $(elm).find('.comadav').attr('src', data[i].avatar);
                    $(elm).find('.comadna').text(data[i].name);
                    $(elm).find('.comadna').attr('href', 'user?who='+data[i].name);
                    $(elm).find('.comdaad').text(data[i].date_add);
                    $(elm).find('.comm-body p').html(data[i].comment_txt);
                    $(elm).insertBefore("#moco");
                }
                $('#moco').text('load more comments');
            }

            else
                $('#moco').text('all comments loaded, click to try to find new').css({"background": "darkred", "color": "#fff"}).delay(6000).queue(function() {
                    $(this).css({"background": "white", "color": "black"});
                });
                // setTimeout(function() {$('#moco').css('background', '#fff').css('color', '#000')}, 6000);
        });
    });

    $('.uprw').hover(function(){$(this).find(':first').css('display', 'block');}, function(){$(this).find(':first').css('display', 'none')})


});