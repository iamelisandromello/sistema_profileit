<?php 

class TempController extends \HXPHP\System\Controller
{
	
	public function indexAction()
	{
		
		
		$user = User::find(22);
		$adviser = User::find(20);
		echo '<pre>';
		echo "Nome: {$user->username}<br>";
		echo '<hr>';
		echo($user->skills[0]->description); # will print an array of User object
		
		echo '<hr>';
		$question = Answer::find_by_user_id(22);
		//array de informações para Novo Usuário
		$teste = $question->id;
		echo "{$question->id} ({$question->question_1}) ({$question->user_id})<br>";
		echo '<hr>';

		foreach ($user->skills as $skill) {
			echo "{$skill->id} ({$skill->description})<br>";
		}

		foreach ($user->academics as $academic) {
			echo "{$academic->institution} ({$academic->level})<br>";
		}
 
		foreach ($user->recommendations as $recommendation) {
			echo "{$recommendation->adviser_id} ({$recommendation->relationship})<br>";
		}
		echo '<pre>';
		echo '<hr>';		

		/*function idade ($birth_date) {
			$dn = new DateTime($birth_date);
			$agora = new DateTime();
			$idade = $agora->diff($dn);
			return $idade->y;
		}*/

		$idadeUsuario = User::idade($user->birth_date);
		echo '<h1>',$idadeUsuario, ' anos de idade! </h1> ';

		$temp = 0;
		foreach ($user->professionals as $professional) {
			//$d1 = "2011-01-01";
			//$d2 = "2013-02-01";
			$d1 =  date_format($professional->date_entry, 'y-m-d');
			$d2 =  date_format($professional->date_out, 'y-m-d');

			$date = User::diffDate($d1,$d2,'D');
			$temp += (int) $date;
			//echo $temp . "\n";
			var_dump( $date ); // int(0
			var_dump( $temp ); // int(0

		}

		$teste = User::experiencia($user);
		var_dump( round($teste, 2) );
		$teste2 = intval($teste);
		var_dump($teste2);

		//var_dump($total);
		//var_dump($user->academics);
		die();
	}
}