<?php 

class TestsController extends \HXPHP\System\Controller
{

	public function indexAction()
	{
		$user = User::find(22);
		$adviser = User::find(20);
		echo '<pre>';

		echo "Nome: {$user->username}<br>";
		echo "Imagem: {$adviser->image}<br>";

		foreach ($user->skills as $skill) {
			echo "{$skill->id} ({$skill->description})<br>";
		}

		foreach ($user->academics as $academic) {
			echo "{$academic->institution} ({$academic->level})<br>";
		}
 
		foreach ($user->recommendations as $recommendation) {
			echo "{$recommendation->adviser_id} ({$recommendation->relationship})<br>";
		}
		

		/*function idade ($birth_date) {
			$dn = new DateTime($birth_date);
			$agora = new DateTime();
			$idade = $agora->diff($dn);
			return $idade->y;
		}*/
		$idadeUsuario = User::idade($user->birth_date);
		echo '<h1>',$idadeUsuario, ' anos de idade! </h1> ';
		//var_dump($user->academics);
		die();
	}

}