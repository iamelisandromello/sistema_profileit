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


  public static function experiencia() {
     echo "teste";
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

		$controle = Profile::defineProfile($candidato1);
		echo ('<h4> Profile: ' . $controle[1]. ' - Desvio Padrão: ' . round ($controle[0], 4) . '</h4>');

		die();
	}

}