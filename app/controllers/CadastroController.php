<?php

class CadastroController extends \HXPHP\System\Controller
{
	public function indexAction()
	{
	   //$this->view->setAssets('css', $this->configs->baseURI . 'public/css/register.css');
	   $this->view->setHeader('cadastro/header')
	              ->setFooter('cadastro/footer');
	}

   public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			$configs->auth->answer_login,
			true
		);

		$this->auth->redirectCheck(true);
	}

	public function voltarAction(){
		var_dump('teste2');
		die();
	}

	public function cadastrarAction(){
	   $this->view->setHeader('cadastro/header')
	              ->setFooter('cadastro/footer');
		$this->view->setFile('index');

		/*$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
		));*/

		$post = $this->request->post();
		//array de informações para Novo Usuário
		$user_data = array(
			'name'			=> $post['name'],
			'last_name'		=> $post['last_name'],
			'username'		=> $post['username'],
			'birth_date'	=> $post['birth_date'],
			'email'			=> $post['email'],
			'scope'			=> $post['scope'],
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

		$professional_group = $_POST['professional'];// copiar um arrays de um POST
		$academic_group = $_POST['academic'];
		$course_group = $_POST['course'];// copiar um arrays de um POST

		$connection = Professional::connection();
		$connection->transaction();

		if (!empty($registry_data)) {
			$cadastrarRegistry = Registry::cadastrar($registry_data);

			if ($cadastrarRegistry->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarRegistry->errors
				));
			}
			else {
				$registry_id = $cadastrarRegistry->registry->id;
			}
		}

		if (!empty($network_data)) {
			$cadastrarNetwork = Network::cadastrar($network_data);

			if ($cadastrarNetwork->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarNetwork->errors
				));
			}
			else {
				$network_id = $cadastrarNetwork->network->id;
			}
		}

		if (!empty($user_data)) {

			$cadastrarUsuario = User::cadastrar($user_data, $registry_id, $network_id);
			if ($cadastrarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarUsuario->errors
				));
			}
		}

		//Bloco Cadastro Histórico Acadêmico
		if (!empty($academic_group)) {
			$user_id = $cadastrarUsuario->user->id;
			foreach($academic_group as $data) {
				$colum = 0;
				$academic_data = array();
				if(is_array($data)) {
					foreach($data as $other_data) {
						$academic_data[$colum] = $other_data;
						$colum++;
					}
					$cadastrarAcademic = Academic::cadastrar($academic_data, $user_id);
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
				}
			}// final do array  multidimensional
		}

		//Bloco Cadastro de Cursos Livres
		if (!empty($course_group)) {
			$user_id = $cadastrarUsuario->user->id;
			foreach($course_group as $data) {
				$colum = 0;
				$course_data = array();
				if(is_array($data)) {
					foreach($data as $other_data) {
						$course_data[$colum] = $other_data;
						$colum++;
					}
					$cadastrarCourse = Course::cadastrar($course_data, $user_id);
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
				}
			}// final do array  multidimensional
		}

		//Bloco Cadastro de Historico Profissional
		if (!empty($professional_group)) {
			$user_id = $cadastrarUsuario->user->id;
			foreach($professional_group as $data) {
				$colum = 0;
				$professional_data = array();
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
		}//

		//Cadastro de Certificações
		if (!empty($certification_data)) {
			$user_id = $cadastrarUsuario->user->id;
			$cadastrarCertification = Certification::cadastrar($certification_data, $user_id);

			if ($cadastrarCertification->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarCertification->errors
				));
			}
			else {
				if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
					$uploadUserImage = new upload($_FILES['image']);

					if ($uploadUserImage->uploaded) {
						$image_name = md5(uniqid()); //Cria nome Unico e converte em um Hash
						$uploadUserImage->file_new_name_body = $image_name; //altera nome do arquivo
						$uploadUserImage->file_new_name_ext = 'png'; //define extensão PNG
						$uploadUserImage->resize = true;  //Habilita Resize da Imagem
						$uploadUserImage->image_x = 500;  //Eixo x
						$uploadUserImage->image_ratio_y = true; //redefine Eixo Y Proporcional a X

						$dir_path = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'users' . DS . $cadastrarUsuario->user->id . DS;
						$uploadUserImage->process($dir_path); //Executa o Processo de Upload para o diretório definido

						if ($uploadUserImage->processed) { //valida se imagem foi processada c/ êxito
							$uploadUserImage->clean();
							$this->load('Helpers\Alert', array(
								'success',
								'Uhuul! Perfil atualizado com sucesso!'
							));

							if (!is_null($cadastrarUsuario->user->image)) {
								unlink($dir_path . $cadastrarUsuario->user->image);//caso Imagem já exista apaga
							}

							$cadastrarUsuario->user->image = $image_name . '.png';
							$cadastrarUsuario->user->save(false);
						}
						else {
							$this->load('Helpers\Alert', array(
								'error',
								'Oops! Não foi possível atualizar a sua imagem de perfil',
								$uploadUserImage->error
							));
						}
					}
				}
				else {
					$this->load('Helpers\Alert', array(
						'success',
						'Uhuul! Perfil atualizado com sucesso!'
					));
				}

				$this->view->setVar('user', $atualizarUsuario->user);

			}//else Carregamento Imagem

			try
			{
				$connection->commit();
			}
			catch (\Exception $e)
			{
				$connection->rollback();
				throw $e;
			}

		}//Final Inclusão Certificações


		if ($cadastrarHistoric->status === true) {
			$this->auth->loginTemp($cadastrarUsuario->user->id, $cadastrarUsuario->user->username, $cadastrarUsuario->user->role->role);
			//$this->auth->loginTemp($cadastrarUsuario->user->id, $cadastrarUsuario->user->username, $cadastrarUsuario->user->role->role);
		}


	}//cadastrarAction
}//CadastroController