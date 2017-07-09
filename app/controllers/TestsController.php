<?php 

class TestsController extends \HXPHP\System\Controller
{
	
	public function indexAction()
	{
		
		$this->load(
		    'Services\Correios'
		);
		
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
	/*$historic_data = $_POST['historic'];// copiar um arrays de um POST
	$qtd = count($_POST['historic']);*/

	//$academic_data = $_POST['academic'];// copiar um arrays de um POST
	//$qtd = count($_POST['academic']);

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

		/*if (!empty($historic_data)) {
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
		}*/


/*Academic*/

	/*if (!empty($academic_data)) {		
		foreach($academic_data as $data) {
			$course_data = array();
			$colum = 0;
			if(is_array($data)) {
				foreach($data as $other_data) {
					$course_data[$colum] = $other_data;
					$colum++;
				}
				echo('<pre>');
					var_dump($course_data);
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

/*if (!empty($academic_data)) {
			$user_id = 20;
			foreach($academic_data as $data) {
				$course_data = array();
				$colum = 0;
				if(is_array($data)) {
					foreach($data as $other_data) {
						$course_data[$colum] = $other_data;
						$colum++;
					}
					$cadastrarAcademic = Academic::cadastrar($course_data, $user_id);
					if ($cadastrarAcademic->status === false) {
						$this->load('Helpers\Alert', array(
										'danger',
										'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
										$cadastrarAcademic->errors
										));
					}
				}
				else {
					echo "teste", '<br/>';
					//echo "Imagem: {$data}<br>";
				}
			}// final do array  multidimensional
		}*/

	//Courses
	//$courses_data = $_POST['courses'];// copiar um arrays de um POST
	//$qtd = count($_POST['courses']);
	/*$POST = $this->request->post();
	var_dump($POST);

	$this->load(
		'Services\Correios',
		$this->request->post('cep') // 00000-000
	);

	$retornoJSON = $this->correios->getDados();
	$enderecoObj = json_decode($retornoJSON);
	var_dump($enderecoObj);

	die();*/
	/*if (!empty($courses_data)) {		
		foreach($courses_data as $data) {
			$complementary_courses = array();
			$colum = 0;
			if(is_array($data)) {
				foreach($data as $other_data) {
					$complementary_courses[$colum] = $other_data;
					$colum++;
				}
				echo('<pre>');
					var_dump($complementary_courses);
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

		/*if (!empty($courses_data)) {
			$user_id = 20;
			foreach($courses_data as $data) {
				$complementary_courses = array();
				$colum = 0;
				if(is_array($data)) {
					foreach($data as $other_data) {
						$complementary_courses[$colum] = $other_data;
						$colum++;
					}
					$cadastrarCourse = Course::cadastrar($complementary_courses, $user_id);
					if ($cadastrarCourse->status === false) {
						$this->load('Helpers\Alert', array(
										'danger',
										'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
										$cadastrarCourse->errors
										));
					}
				}
				else {
					echo "teste", '<br/>';
					//echo "Imagem: {$data}<br>";
				}
			}// final do array  multidimensional
		}*/

	//Profesional
/*	$professional_data = $_POST['professional-group'];// copiar um arrays de um POST
	$academic_data = $_POST['academic-group'];
	$course_data = $_POST['course-group'];// copiar um arrays de um POSTcourse-group
	User::recursive_show_array($academic_data);
	User::recursive_show_array($course_data);
	User::recursive_show_array($professional_data);*/
	$POST = $this->request->post();
	echo '<pre>';
	var_dump($POST);
	echo '<pre>';
	$this->redirectTo('/profileit/perfil/editar/');
	//die();



	}
	
}