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
	

	public function cadastrarAction(){

		/*$post = $this->request->post();
		date('d/m/Y', strtotime($data_sql));
		$data_aniver = date('Y-m-d',strtotime($post['birth_date']));
		$user_data = array(
			'name'			=> $post['name'],
			'last_name'		=> $post['last_name'],
			'username'		=> $post['username'],
			'birth_date'	=> $data_aniver,
			'email'			=> $post['email'],
			'password'		=> $post['password']
		);
		echo "Data1: {$post['birth_date']}<br>";
		echo "Data2: {$data_aniver}<br>";*/

/*	echo('<pre>');
		print_r( $_POST['historic'] ); // exibirá o array 
	echo('<pre>');*/
	$historic_data = $_POST['historic'];// copiar um arrays de um POST

	$qtd = count($_POST['historic']);

	/*foreach($historic_data as $data)
	{
	     if(is_array($data))
	     {
	          foreach($data as $other_data)
	          {
	               echo $other_data, '<br/>';
	          }
	     }
	     else
	     {
	          echo "teste", '<br/>';
	          //echo "Imagem: {$data}<br>";
	     }
	}*/


	/*if (!empty($historic_data)) {		
		foreach($historic_data as $data) {
			$professional_data = array();
			$colum = 0;
			if(is_array($data)) {
				foreach($data as $other_data) {
					$professional_data[$colum] = $other_data;
					$colum++;
				}
				echo('<pre>');
					var_dump($professional_data);
				echo('</pre>');
			}
			else {
				echo "teste", '<br/>';
				//echo "Imagem: {$data}<br>";
			}
		}
	}*/


	//User::recursive_show_array($dados);

		//die();

		if (!empty($historic_data)) {
			$user_id = 20;
			foreach($historic_data as $data) {
				$professional_data = array();
				$colum = 0;
				if(is_array($data)) {
					foreach($data as $other_data) {
						$professional_data[$colum] = $other_data;
						$colum++;
					}
					$cadastrarHistoric = Professional::cadastrar($professional_data, $user_id);
					if ($cadastrarHistoric->status === false) {
						$this->load('Helpers\Alert', array(
										'danger',
										'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
										$cadastrarHistoric->errors
										));
					}
				}
				else {
					echo "teste", '<br/>';
					//echo "Imagem: {$data}<br>";
				}
			}// final do array  multidimensional
		}


	}
	
}