// Tout d'abbord on initialise notre application avec le framework Express
// et la bibliothèque http integrée à node.
var fs = require('fs');
var express = require('express');
var app = express();


var https = require('https');


/*var http = require('http').createServer(app);*/


var options = {
  key: fs.readFileSync("/etc/letsencrypt/archive/kurbys.com/privkey1.pem"),
        cert: fs.readFileSync("/etc/letsencrypt/archive/kurbys.com/fullchain1.pem"),
        ca: fs.readFileSync("/etc/letsencrypt/archive/kurbys.com/chain1.pem")
};

var serverPort = 3001;

var server = https.createServer(options, app);
var io = require('socket.io')(server);





/*var io = require('socket.io')(https, {path:'/socket.io'});*/


/*var io = require('socket.io')(http, {path:'/socket.io'}); NON*/








var connection = require ('./db')
/*io = io.listen(http);*/

// On gère les requêtes HTTP des utilisateurs en leur renvoyant les fichiers du dossier 'public'
/*app.use("/", express.static(__dirname + "/public"));*/

io.on('connection', function(socket){
    console.log('a user connected');
    socket.on('disconnect', function(){

        console.log('user disconnected');
    });

    //on affiche tous les messags entre les deux utilisateurs
    socket.on('login', function(data){

        var user = data.user_id;
        var user_send = data.user_send;


        var query = 'SELECT content, user_id, user_send, created_at FROM message_chat WHERE user_id = ? && user_send = ? || user_id = ? && user_send = ? ORDER BY created_at ASC';
        connection.query(query,[user,user_send,user_send,user], function(err, rows){
            if (err) throw err;
            for (var i in rows) {
                    console.log('Post Titles: ', rows[i].content);


                socket.emit('chat-message', {
                        msg: rows[i].content,
                        user: rows[i].user_id,
                        user_send : rows[i].user_send,
                        date: rows[i].created_at,
                    });
                }

        })
    })


    //on insert les message dans la base de données et on les affiche
    socket.on('join', function (data) {
        var msg = data.msg;
        var user = data.user_id;
        var user_send = data.user_send;
        var id1 = user_send+user+1;
        console.log(msg+user);
        connection.query('INSERT INTO message_chat SET content = ? , created_at = ?, user_id = ?, user_send = ? ', [msg, new Date(), user,user_send]);
        connection.query('UPDATE contact_chat SET last_message = ? , date_ = ? WHERE from_id = ? AND to_id = ?', [msg, new Date(), user,user_send]);
        connection.query('UPDATE contact_chat SET last_message = ? , date_ = ? WHERE from_id = ? AND to_id = ?', [msg, new Date(), user_send,user]);
       
       io.emit(id1, data);
       io.emit(user_send, data); // notification d'un message non lu
    });
});


server.listen(serverPort, function() {
  console.log('server up and running at %s port', serverPort);
});

// On lance le serveur en écoutant les connexions arrivant sur le port 3000
/*http.listen(3000, function(){
    console.log('Server is listening on :3000');
});*/