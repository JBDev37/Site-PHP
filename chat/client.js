/*var socket = io();*/
var socket = io.connect('http://localhost:3000');

function scrollToBottom() {
        $('#msgbox').animate({ scrollTop: $(document).height() }, 0);
}

function sendMessage(user_id, user_send) {
$('form').submit(function(e) {
    e.preventDefault();
    var message = {
        text : $('#m').val()
    }
    socket.emit('chat-message', {
        msg: msg,
        user_id: user_id,
        user_send: user_send
    });
    $('#m').val('');
    $('#chat input').focus();
});
}
sendMessage(<?= $my_id; ?>,<?= $user_send;?> );



socket.on('chat-message', function (message) {
    $('#messages').append($('<li>').html( message.text));
    scrollToBottom();
});


