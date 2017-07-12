<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php";


if(isset($_GET['motclef'])){
	$motclef = $_GET['motclef'];
	$q = array('motclef' => $motclef.'%' );
	$req = $pdo->prepare('SELECT COUNT(user_login)  FROM wp_cendrillon_6239_users WHERE user_login LIKE "Cendrillon%" ');
	$req->execute([$q]);
	
	if($req == 1){
		while ($result = $req->fetch()){
			echo "nam : ".$result ->user_login;
		}
	}else { echo "pas de resultat";}

}

?>