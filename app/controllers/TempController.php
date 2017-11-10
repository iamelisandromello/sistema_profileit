<?php

class TempController extends \HXPHP\System\Controller
{

	public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);

		$user_id = $this->auth->getUserId();
	}


	public function indexAction()
	{
	$cep = '94025-260';
	$this->load(
		'Services\Correios',
		$cep // 00000-000
	);

	$retornoJSON = $this->correios->getDados();
	$enderecoObj = json_decode($retornoJSON);
	var_dump($enderecoObj);
	die();
	}

	public function atualizarAction($competency_id = null, $level = null)
	{

		if (is_numeric($competency_id) && is_numeric($level)) {
			$competency = Competency::find_by_id($competency_id);

			if (!is_null($competency)) {
				$competency->level = $level;
				$competency->save(false);

				$this->view->setVar('user', $user_id);
			}
		}
		else{

			var_dump('teste');
			die();
		}
	}

public function academicAction (){

/*Academic*/
	$post = $this->request->post();
	$academic_data = $_POST['academic'];// copiar um arrays de um POST
	$courses_data = $_POST['course'];// copiar um arrays de um POST
	$professional_data = $_POST['professional'];// copiar um arrays de um POST

	$qtd = count($_POST['academic']);

	$user_data = array(
		'name'			=> $post['name'],
		'last_name'		=> $post['last_name'],
		'username'		=> $post['username'],
		'birth_date'	=> $post['birth_date'],
		'email'			=> $post['email'],
		'password'		=> $post['password']
	);

	//array de informações adicionais para Novo Usuário (Registros)
	$registry_data = array(
		'about'		=> $post['about'],
		'celular'	=> $post['celular'],
		'scope'		=> $post['scope'],
		'address'	=> $post['address'],
		'zipcode'	=> $post['zipcode']
	);

	//array de informações adicionais para Novo Usuário (Redes Sociais)
	$network_data = array(
		'facebook'	=> $post['facebook'],
		'linkedin'	=> $post['linkedin'],
		'github'		=> $post['github'],
		'web'			=> $post['web'],
		'instagram' => $post['instagram'],
		'twitter'	=> $post['twitter']
	);

	$certification_data = array(
		'microsoft'		=> $post['microsoft'],
		'linux'			=> $post['linux'],
		'cisco'			=> $post['cisco'],
		'virtualizacao'=> $post['virtualizacao'],
		'pmi' 			=> $post['pmi'],
		'agile' 			=> $post['agile'],
		'itil'			=> $post['itil']
	);

	foreach ($user_data as $data) {
		echo $data, '<br/>';
	}

	foreach ($registry_data as $data) {
		echo $data, '<br/>';
	}

	foreach ($network_data as $data) {
		echo $data, '<br/>';
	}

	foreach ($certification_data as $data) {
		echo $data, '<br/>';
	}


	if (!empty($academic_data)) {
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
	}

	if (!empty($courses_data)) {
		foreach($courses_data as $data) {
			$livre_data = array();
			$colum = 0;
			if(is_array($data)) {
				foreach($data as $other_data) {
					$livre_data[$colum] = $other_data;
					$colum++;
				}
				echo('<pre>');
					var_dump($livre_data);
				echo('</pre>');
			}
			else {
				echo "teste", '<br/>';
				//echo "Imagem: {$data}<br>";
			}
		}
	}

	if (!empty($professional_data)) {
		foreach($professional_data as $data) {
			$work_data = array();
			$colum = 0;
			if(is_array($data)) {
				foreach($data as $other_data) {
					$work_data[$colum] = $other_data;
					$colum++;
				}
				echo('<pre>');
					var_dump($work_data);
				echo('</pre>');
			}
			else {
				echo "teste", '<br/>';
				//echo "Imagem: {$data}<br>";
			}
		}
	}


	die();


}


	public function registrarAction()
	{

	$POST = $this->request->post();
	echo '<pre>';
	var_dump($POST);
	echo '<pre>';

	$competencies_data = $POST;// copiar um arrays de um POST
	$qtd = count($POST);
var_dump($qtd);
foreach($competencies_data as $data)
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
	}

		die();
	}
	public function tempAction()
	{
		
		$post = $this->request->post();
$registry_id = 1;
$network_id = 2;
		$professional_group = $_POST['professional'];// copiar um arrays de um POST


		//Bloco Cadastro de Historico Profissional
		$user_id = 66;
		if (!empty($professional_group)) {
			foreach($professional_group as $data) {
				$colum = 0;
				$professional_data = array();
				if(is_array($data)) {
					foreach($data as $other_data) {
						$professional_data[$colum] = $other_data;
						$colum++;
					}
							$cadastrarProfessional = Professional::cadastrar($professional_data, $user_id);
							/*echo('<pre>');
								var_dump($professional_data);
							echo('</pre>');*/
				}
				else {
					echo "teste", '<br/>';
					//echo "Imagem: {$data}<br>";
				}
			}// final do array  multidimensional
		}//*/

		if ($cadastrarProfessional) {
			var_dump($professional_data);
			die();
		}
		else {
			echo "Erro";
			die();
		}
/*$registry_id = 1;
$network_id = 2;
		$user_data = array(
			'name'			=> $post['name'],
			'last_name'		=> $post['last_name'],
			'username'		=> $post['username'],
			'birth_date'	=> $post['birth_date'],
			'email'			=> $post['email'],
			'scope'			=> $post['scope'],
			'password'		=> $post['password']
		);

$cadastrarUsuario = User::cadastrar($user_data, $registry_id, $network_id);*/
die();
/*		echo('<pre>');
		var_dump($post);
		echo('</pre>');

		die();*/
	}

	public function cadastrarAction()
	{

		$post = $this->request->post();
		echo('<pre>');
		var_dump($post);
		echo('</pre>');
		$data = "";

	   if ($post['adddate_conclusion'] == "") {
	      $data = 'NULL';
	      echo("Data Null: ");
	   }
	   else {
	      echo('<pre>');
			$data = $_POST['adddate_conclusion'];
			echo date('d-m-Y', strtotime($data));
			echo ('<br>');
			$data = date("Y-m-d",strtotime(str_replace('/','-',$data)));
			echo date('Y-m-d', strtotime($data));
	      echo('</pre>');
	   }

	   $academic = array(
	      'institution' 		=> $post['addInstituicao'],
	      'local'       		=> $post['addLocal'],
	      'course'      		=> $post['addCurso'],
	      'level'       		=> $post['addLevel'],
	      'date_conclusion' => $data,
	      'status'      		=> $post['addAcademic']
	   );

		echo('<pre>');
		var_dump($academic);
		echo('</pre>');

		die();
	}


	public function experienciaAction() {
		$post = $this->request->post();

		echo ("acessando");
		$academic_data = $_POST;// copiar um arrays de um POST
		$qtd = count($_POST);

		echo('<pre>');
			print_r( $academic_data ); // exibirá o array
		echo('<pre>');

		echo('<pre>');
			print_r( $qtd ); // exibirá o array
		echo('<pre>');

		$academic_data = $_POST['academic'];// copiar um arrays de um POST
		$qtd = count($_POST['academic']);

		foreach($academic_data as $data)
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
		}

	die();

	}

	public function testarAction()
	{

		$user = User::find_by_id(20);
		var_dump($user->name);
		$questionnaire_data = array();

    	//Pergunta 2 - Formação Acadêmica
   	$graduacao = Academic::listFormations($user);

		echo ("<br>");
			echo($graduacao);
		echo ("<hr>");

   	$questionnaire_data[1] = $graduacao;

   	echo ("<br>");
			echo('Cod Formacao: ' . $questionnaire_data[1]);
		echo ("<hr>");



	   /*$controle = 0;
	   $opcao = 0;

		foreach ($user->academics as $academic):

			$curso = $academic->course;
			$nivel = $academic->level;
			$status = $academic->status;

			if ($nivel == "Bacharelado") {
			  $controle = 1;
			}
			else if ($nivel == "Tecnologo") {
			   $controle = 2;
			}
			else if ($nivel == "Tecnico") {
			   $controle = 3;
			}
			else if ($nivel == "Medio") {
			   $controle = 4;
			}
			else {
			   $controle = 5;
			}

			if ($opcao == 0) {
			  $opcao = $controle;
			}
			else if ( $opcao > $controle ) {
			  $ocpao = $controle;
			}

		endforeach;

		echo ("<br>");
			echo($opcao);
		echo ("<hr>");*/

			$post = $this->request->post();
			echo('<pre>');
				var_dump($post);
			echo('</pre>');
			die();

	}

	public function calculoAction()
	{

		$usuario = User::find_by_id(22);
		echo ('<h4>' . $usuario->name . '</h4>');
		$respostasusuario = Answer::find_by_user_id(22);
		$pesos_usuario = array();

		for ($i=1; $i < 16 ; $i++) {
			$questao = 'question_' . $i; //concatena a expresão com o contador, para formar o campo
			$valor = $respostasusuario->$questao; //recupera a opção selecionada pelo Usuario na Answers
			$quesito = Parameter::find_by_id($i); //Recupera o Atributo (Idioma, Experiencia...)
			$weigths = $quesito->weight_id; //ID do Atributo a ser recuperado o peso
			$pesosRecuperados = Weight::find_by_id($weigths);//Recupera os Pesos do Atributo
			$opcaoUser = 'option_' . $valor; //Concatena a expressao com a Opcao Selecionada p/Usuario
			$pesos_usuario[$i-1] = $pesosRecuperados->$opcaoUser; //Array com os Pesos do Usuario
			//echo ('Pesos: ' . $pesosRecuperados->$opcaoUser . '<br>');
			//echo ('Pesos Array: ' . $pesos_usuario[$i-1]);
		}

		echo ('<hr>');

		for ($i=0; $i < 15; $i++) {
			echo('Pesos array: ' . $pesos_usuario[$i]);
			echo ('<br>');
		}

		//Analista Junior
		$analistajr = Profile::find_by_id(1);
		echo ('<h4>' . $analistajr->profile . '</h4>');
		$pesos_junior = Profile::backProfile(1);

		for ($i=0; $i < 15; $i++) {
			echo('Pesos Junior: ' . $pesos_junior[$i]);
			echo ('<br>');
		}
		echo ('<hr>');

		//Analista Pleno
		$analistapl = Profile::find_by_id(2);
		echo ('<h4>' . $analistapl->profile . '</h4>');
		$pesos_pleno = Profile::backProfile(2);

		for ($i=0; $i < 15; $i++) {
			echo('Pesos Pleno: ' . $pesos_pleno[$i]);
			echo ('<br>');
		}
		echo ('<hr>');

		//Analista Senior
		$analistasr = Profile::find_by_id(3);
		echo ('<h4>' . $analistasr->profile . '</h4>');
		$pesos_senior = Profile::backProfile(3);

		for ($i=0; $i < 15; $i++) {
			echo('Pesos Senior: ' . $pesos_senior[$i]);
			echo ('<br>');
		}

		$candidato1 = array();
		$candidato1[0] = 0.30;
		$candidato1[1] = 0.25;
		$candidato1[2] = 0.15;
		$candidato1[3] = 0.25;
		$candidato1[4] = 0.50;
		$candidato1[5] = 0.10;
		$candidato1[6] = 0.10;
		$candidato1[7] = 0.30;
		$candidato1[8] = 0.35;
		$candidato1[9] = 0.25;
		$candidato1[10] = 0.35;
		$candidato1[11] = 0.20;
		$candidato1[12] = 0.35;
		$candidato1[13] = 0.20;
		$candidato1[14] = 0.35;


		$candidato2 = array();
		$candidato2[0] = 0.50;
		$candidato2[1] = 0.50;
		$candidato2[2] = 0.30;
		$candidato2[3] = 0.50;
		$candidato2[4] = 0.30;
		$candidato2[5] = 0.30;
		$candidato2[6] = 0.30;
		$candidato2[7] = 0.50;
		$candidato2[8] = 0.35;
		$candidato2[9] = 0.50;
		$candidato2[10] = 0.50;
		$candidato2[11] = 0.45;
		$candidato2[12] = 0.50;
		$candidato2[13] = 0.20;
		$candidato2[14] = 0.50;

		$calculoJunior = Profile::calculoFinal($pesos_usuario, $pesos_junior);
		$calculoPleno = Profile::calculoFinal($pesos_usuario, $pesos_pleno);
		$calculoSenior = Profile::calculoFinal($pesos_usuario, $pesos_senior);

		echo ('<br> Calculo Junior: ');
		echo round($calculoJunior, 5);
		echo ('<br> Calculo Pleno: ');
		echo round($calculoPleno, 5);
		echo ('<br> Calculo Senior: ');
		echo round($calculoSenior, 5);

		$controle = Profile::defineProfile($pesos_usuario);
		echo ('<h4> Profile: ' . $controle[1]. ' - Desvio Padrão: ' . round ($controle[0], 4) . '</h4>');

		die();
	}

	public function defineAction()
	{
		$usuario = User::find_by_id(63);
		echo ('<h4>' . $usuario->name . '</h4>');
		$pesos_backUser =	Profile::backUserWeights(63);

		echo ('<hr>');

		for ($i=0; $i < 15; $i++) {
			echo('Pesos array: ' . $pesos_backUser[$i]);
			echo ('<br>');
		}

		$controle = Profile::defineProfile($pesos_backUser);
		echo ('<h4> Profile: ' . $controle[1]. ' - Desvio Padrão: ' . round ($controle[0], 4) . '</h4>');

		die();
	}

	public function calcAction()
	{
		$usuario = User::find_by_id(63);
		$total = User::experiencia($usuario);
		$mes = ($total[1] == abs(1) ) ? 'mês' : 'meses' ;
		echo ('<h4> Experiencia: ' . $total[0] . ' anos e ' . $total[1]  . $mes);

		die();
	}

	public  function suggestionsAction()
	{
		$userSuggestions = array();
		$user_id = 64;
		$usuario = User::find_by_id($user_id);
		foreach ($usuario->certifications as $certification):
			echo '<br/>';
			$linux = $certification->linux;
			$microsoft = $certification->microsoft;
			if ($certification->virtualizacao == "Nao") {
				$userSuggestions["Virtualizacao"] = "Certificação Virtualização";
			} else { $userSuggestions["Virtualizacao"] = null; }
			if ($certification->cisco == "Nao") {
				$userSuggestions["Cisco"] = "Certificação Roteadores";
			} else { $userSuggestions["Cisco"] = null; }
			if ( $certification->itil == "Nao" &&  $certification->agile == "Nao" && $certification->pmi == "Nao" ) {
				$userSuggestions["Processos"] = "Certificação em Processos";
			} else {$userSuggestions["Processos"] = null;}
			if($certification->microsoft == "Nao") {
				$userSuggestions["Microsoft"] = "Certificação Microsoft";
			}
			else if ($certification->microsoft == "MCP" ) {
				$userSuggestions["Microsoft"] = "MCSA";
			}
			else if ($certification->microsoft == "MCTIP" ) {
				$userSuggestions["Microsoft"] = "MCSA";
			}
			else if ($certification->microsoft == "MCSA" ) {
				$userSuggestions["Microsoft"] = "MCSE";
			}
			else if ($certification->microsoft == "MCSE" ) {
				$userSuggestions["Microsoft"] = null;
			}
		endforeach;



		foreach ($userSuggestions as $suggestion):
			echo ($suggestion == NULL) ? null : $suggestion . "<br>";
		endforeach;

echo "<hr>";

echo ($userSuggestions["Microsoft"] == NULL) ? null : $userSuggestions["Microsoft"] . "<br>";
echo ($userSuggestions["Virtualizacao"] ==  NULL) ? null : $userSuggestions["Virtualizacao"] . "<br>";
echo ($userSuggestions["Processos"] ==  NULL) ? null : $userSuggestions["Processos"] . "<br>";
echo ($userSuggestions["Cisco"] ==  NULL) ? null : $userSuggestions["Cisco"] . "<br>";

echo "<hr>";

		die();

	}

	public static function analyzeSkillAction()
	{
		$userSkill;//Declara variável de Retorno
		$usuario = User::find_by_id(22);//localiza o objeto Usuário
		$skill = Skill::find_by_id(22);
		if (!$skill) {
			$userSkill = false;
		}
		else { $userSkill = true; }
	die();
		return $userSkill;
	}

	public static function returnAction()
	{

		//Function to check if the request is an AJAX request
		function is_ajax() {
			return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
		}

		if (is_ajax()) {
			if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
				$action = $_POST["action"];
				switch($action) { //Switch case for value of action
					case "test": test_function(); break;
				}
			}
		}


		function test_function(){
			$return = $_POST;

			//Do what you need to do with the info. The following are some examples.
			//if ($return["favorite_beverage"] == ""){
			//  $return["favorite_beverage"] = "Coke";
			//}
			//$return["favorite_restaurant"] = "McDonald's";

			$return["json"] = json_encode($return);
			var_dump($return);
			die();
			echo json_encode($return);
		}
	}
}