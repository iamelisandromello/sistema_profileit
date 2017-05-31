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

		echo($user->skills[0]->description); # will print an array of User object

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
		foreach ($user->professionals as $professional) {
			echo "{$professional->id} ({$professional->date_out})<br>";
			echo "{$professional->id} ({$professional->date_entry})<br>";
			$intervalo= User::experiencia($professional->date_out, $professional->date_entry);
		echo "Intervalo é de {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias"; 

		}

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

		//var_dump($total);
		//var_dump($user->academics);
		die();
	}

}