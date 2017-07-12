var mysql      = require('mysql')
var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : 'root',
    database : 'teenadviissecret',
    socketPath: '/Applications/MAMP/tmp/mysql/mysql.sock',
    
    /*socketPath: '/var/run/mysqld/mysqld.sock',
    host     : '127.0.0.1',
    user     : 'root',
    password : '*Kurbys7*',
    database : 'kurbys',
    /*socketPath: '/Applications/MAMP/tmp/mysql/mysql.sock',*/
})

connection.connect(function(err){
    if(err){
        console.error('impossible de se connecter à la base de données', err);
    }
})

module.exports = connection