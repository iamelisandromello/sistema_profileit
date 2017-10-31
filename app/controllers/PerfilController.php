<?php

class PerfilController extends \HXPHP\System\Controller
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

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));

		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$this->auth->getUserRole()
		);

		$user_id = $this->auth->getUserId();

		$this->view->setTitle('HXPHP - Editar perfil')
					->setVar('user', User::find($user_id));
	}

	/*
	* Métodos Controller's de Atualização de Informaçoes
	* de Informações de Usuário
	*/
	public function editarAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));

		$user_id = $this->auth->getUserId();

		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
		));

		$post = $this->request->post();

		if (!empty($post)) {
			$atualizarUsuario = User::atualizar($user_id, $post);

			if ($atualizarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível atualizar seu perfil. <br> Verifique os erros abaixo:',
					$atualizarUsuario->errors
				));
			}
			else {
				if (isset($_FILES['file-1']) && !empty($_FILES['file-1']['tmp_name'])) {
					$uploadUserImage = new upload($_FILES['file-1']);

					if ($uploadUserImage->uploaded) {
						$image_name = md5(uniqid()); //Cria nome Unico e converte em um Hash
						$uploadUserImage->file_new_name_body = $image_name; //altera nome do arquivo
						$uploadUserImage->file_new_name_ext = 'png'; //define extensão PNG
						$uploadUserImage->resize = true;  //Habilita Resize da Imagem
						$uploadUserImage->image_x = 500;  //Eixo x
						$uploadUserImage->image_ratio_y = true; //redefine Eixo Y Proporcional a X

						$dir_path = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'users' . DS . $atualizarUsuario->user->id . DS;
						$uploadUserImage->process($dir_path); //Executa o Processo de Upload para o diretório definido

						if ($uploadUserImage->processed) { //valida se imagem foi processada c/ êxito
							$uploadUserImage->clean();
							$this->load('Helpers\Alert', array(
								'success',
								'Uhuul! Perfil atualizado com sucesso!'
							));

							if (!is_null($atualizarUsuario->user->image)) {
								unlink($dir_path . $atualizarUsuario->user->image);//caso Imagem já exista apaga
							}

							$atualizarUsuario->user->image = $image_name . '.png';
							$atualizarUsuario->user->save(false);
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

			}
		}
	}


	/*
	* Método Controller's de Cadastrar Skill
	* de Competências e Resumo Profissional
	*/
	public function cadastrarskillAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$cadastrarSkill = Competency::cadastrar($post, $user_id);

		if ($cadastrarSkill->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$cadastrarSkill->errors
			));
		}

		$this->view->setVar('user', $user);
	}

	/*
	* Método Controller's de Cadastrar Preferências
	* e areas de atuação
	*/
	public function addpreferenceAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		if (!empty($post)) {
			$cadastrarPreference = Preference::cadastrar($post, $user_id);
			if ($cadastrarPreference->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar suas preferências. <br> Verifique os erros abaixo:',
					$cadastrarPreference->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

	/*
	* Métodos Controller's de Atualização de Informaçoes
	* do Skill de COmpetências
	*/
	public function upcompetencyAction($competency_id = null, $level = null)
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$atualizarCompetency = Competency::atualizar($competency_id, $level, $user_id);

		if ($atualizarCompetency->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$atualizarCompetency->errors
			));
		}

		$this->view->setVar('user', $user);
	}

	public function delcompetencyAction($competency_id = null)
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$excluirCompetency = Competency::excluir($competency_id, $user_id);

		if ($excluirCompetency->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$excluirCompetency->errors
			));
		}

		$this->view->setVar('user', $user);
	}


	public function addcompetencyAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		if (!empty($post)) {
			$competencies_group = $_POST['competencies-group'];// copiar um arrays de um POST

			//Bloco Cadastro Competências
			if (!empty($competencies_group)) {
				foreach($competencies_group as $data) {
					$colum = 0;
					$competencies_data = array();
					if(is_array($data)) {
						foreach($data as $other_data) {
							$competencies_data[$colum] = $other_data;
							$colum++;
						}
						$adicionarCompetency = Competency::adicionar($competencies_data, $user_id);
						if ($adicionarCompetency->status === false) {
							$this->load('Helpers\Alert', array(
											'error',
											'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
											$adicionarCompetency->errors
											));
						}
					}
					else {
						echo "teste", '<br/>';
					}
				}// final do array  multidimensional
			}
			$this->view->setVar('user', $user);
		}
	}

	/*
	* Métodos Controller's de Atualização de Informaçoes
	* do Histórico Acadêmico
	*/
	public function upconclusionAction()
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$atualizarAcademic = Academic::atualizar($post, $user_id);

		if ($atualizarAcademic->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$atualizarAcademic->errors
			));
		}

		$this->view->setVar('user', $user);
	}

	public function delAcademicAction($academic_id = null)
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$excluirAcademic = Academic::excluir($academic_id, $user_id);

		if ($excluirAcademic->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$excluirAcademic->errors
			));
		}

		$this->view->setVar('user', $user);
	}

	public function addAcademicAction()
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$post = $this->request->post();

		$academic = [];
		$academic[] = $post['addInstituicao'];
		$academic[] = $post['addLocal'];
		$academic[] = $post['addCurso'];
		$academic[] = $post['addLevel'];
		$academic[] = $post['date_conclusion'];
		$academic[] = $post['addAcademic'];

		$addAcademic = Academic::cadastrar($academic, $user_id);

		if ($addAcademic->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$addAcademic->errors
			));
		}

		$this->view->setVar('user', $user);
	}

}