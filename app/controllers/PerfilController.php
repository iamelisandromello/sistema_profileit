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
		//$qualificacoes = Qualification::all();
		$qualificacoes = Qualification::find('all', array('order' => 'qualification asc'));
		$preference = preference::find_by_user_id($user_id);

		$this->view->setTitle('HXPHP - Administrativo')
					->setFile('editar')
					->setVars([
						'user'				=> User::find($user_id),
						'preference'		=> $preference,
						'qualificacoes'	=> $qualificacoes
					]);
	}
    public function indexAction()
    {
        $this->view->setHeader('perfil/header')
               ->setFooter('perfil/footer');
    }


	/*
	* Métodos Controller's de Atualização
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
	* Métodos Controller's de Atualização
	* de Informações de Usuário
	*/
	public function upSocialAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));

		$user_id = $this->auth->getUserId();
		$post = $this->request->post();

		if (!empty($post)) {
			$atualizarSocial = Network::atualizar($user_id, $post);

			if ($atualizarSocial->status === false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu perfil. <br> Verifique os erros abaixo:',
					$atualizarSocial->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'; ) Processo Executado. <br> Verifique mensagens abaixo:',
					$atualizarSocial->errors
				));
			}

			$this->view->setVar('user', $atualizarSocial->user);
		}/*Verificação de Atualização com Sucesso*/
	}

		/*
	* Métodos Controller's de Atualização
	* de Informações de Registros Pessoais
	*/
	public function upRegistryAction()
	{
		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));

		$user_id = $this->auth->getUserId();
		$post = $this->request->post();

		if (!empty($post)) {
			$atualizarRegistry = Registry::atualizar($user_id, $post);

			if ($atualizarRegistry->status === false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu perfil. <br> Verifique os erros abaixo:',
					$atualizarRegistry->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'; ) Processo Executado. <br> Verifique mensagens abaixo:',
					$atualizarRegistry->errors
				));
			}

			$this->view->setVar('user', $atualizarRegistry->user);
		}/*Verificação de Atualização com Sucesso*/
	}

	/*
	* Métodos Controller's de Atualização de Informaçoes
	* do Skill de Competências
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
			$competencies_group = $_POST['competency'];// copiar um arrays de um POST
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
		else {
	 		$graduacao = Academic::listFormations($user);
	 		$academic = array(
         'question_4' => $graduacao[0],
         'question_5' => $graduacao[1],
         'question_6' => $graduacao[2],
         'question_7' => $graduacao[3]
      	);

	      $upGraduation = Answer::upAcademic($academic, $user_id);
			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$atualizarAcademic->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$atualizarAcademic->errors
				));
			}

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
		else {
	 		$graduacao = Academic::listFormations($user);
	 		$academic = array(
         'question_4' => $graduacao[0],
         'question_5' => $graduacao[1],
         'question_6' => $graduacao[2],
         'question_7' => $graduacao[3]
      	);

	      $upGraduation = Answer::upAcademic($academic, $user_id);
			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$excluirAcademic->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$excluirAcademic->errors
				));
			}
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

		$academic_data = array();
		$academic_data[0] = $post['addInstituicao'];
		$academic_data[1] = $post['addLocal'];
		$academic_data[2] = $post['addCurso'];
		$academic_data[3] = $post['addLevel'];
		$academic_data[4] = $post['adddate_conclusion'];
		$academic_data[5] = $post['addAcademic'];

		$addAcademic = Academic::cadastrar($academic_data, $user_id);

		if ($addAcademic->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$addAcademic->errors
			));
		}
		else {
	 		$graduacao = Academic::listFormations($user);
	 		$academic = array(
         'question_4' => $graduacao[0],
         'question_5' => $graduacao[1],
         'question_6' => $graduacao[2],
         'question_7' => $graduacao[3]
      	);

	      $upGraduation = Answer::upAcademic($academic, $user_id);
			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$addAcademic->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$addAcademic->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

	/*
	* Métodos Controller's de Atualização de Informaçoes
	* do Histórico Profissional
	*/
	public function addProfessionalAction()
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$post = $this->request->post();

		$professional_data = array();
		$professional_data[0] = $post['addCompany'];
		$professional_data[1] = $post['addFunction'];
		$professional_data[2] = $post['adddate_entry'];
		$professional_data[3] = $post['adddate_out'];
		$professional_data[4] = $post['addAssignments'];

		$addProfessional = Professional::cadastrar($professional_data, $user_id);

		if ($addProfessional->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Profissional. <br> Verifique os erros abaixo:',
				$addProfessional->errors
			));
		}
		else {
	 		//Pergunta 2 - Experiência
	      $total = User::experiencia($user);
	      $experiencia = 0;

	      if ($total[0] >= 8) {
	         $experiencia = 5;
	      }
	      else if ( $total[0] < 8 && $total[0] >= 5 ) {
	         $experiencia = 4;
	      }
	      else if ( $total[0] < 5 && $total[0] >= 3 ) {
	         $experiencia = 3;
	      }
	      else if ( $total[0] < 3 && $total[0] >= 1 ) {
	         $experiencia = 2;
	      }
	      else if ( $total[0] < 1) {
	         $experiencia = 1;
	      }

	 		$professional = array(
         'question_2' => $experiencia
      	);
	      $addExperiencia = Answer::upProfessional($professional, $user_id);
			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$addProfessional->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$addProfessional->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

	public function upprofessionalAction()
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$atualizarProfessional = Professional::atualizar($post, $user_id);

		if ($atualizarProfessional->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$atualizarProfessional->errors
			));
		}
		else {
	      //Pergunta 2 - Experiência
	      $total = User::experiencia($user);
	      $experiencia = 0;

	      if ($total[0] >= 8) {
	         $experiencia = 5;
	      }
	      else if ( $total[0] < 8 && $total[0] >= 5 ) {
	         $experiencia = 4;
	      }
	      else if ( $total[0] < 5 && $total[0] >= 3 ) {
	         $experiencia = 3;
	      }
	      else if ( $total[0] < 3 && $total[0] >= 1 ) {
	         $experiencia = 2;
	      }
	      else if ( $total[0] < 1) {
	         $experiencia = 1;
	      }

	 		$professional = array(
         'question_2' => $experiencia
      	);
	      $upExperiencia = Answer::upProfessional($professional, $user_id);

			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$atualizarProfessional->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$atualizarProfessional->errors
				));
			}

		}

		$this->view->setVar('user', $user);
	}


	public function delProfessionalAction($professional_id = null)
	{

		$this->view->setFile('editar');
         $this->view->setHeader('perfil/header')
            ->setFooter('perfil/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$excluirProfessional = Professional::excluir($professional_id, $user_id);

		if ($excluirProfessional->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
				$excluirProfessional->errors
			));
		}
		else {
	      //Pergunta 2 - Experiência
	      $total = User::experiencia($user);
	      $experiencia = 0;

	      if ($total[0] >= 8) {
	         $experiencia = 5;
	      }
	      else if ( $total[0] < 8 && $total[0] >= 5 ) {
	         $experiencia = 4;
	      }
	      else if ( $total[0] < 5 && $total[0] >= 3 ) {
	         $experiencia = 3;
	      }
	      else if ( $total[0] < 3 && $total[0] >= 1 ) {
	         $experiencia = 2;
	      }
	      else if ( $total[0] < 1) {
	         $experiencia = 1;
	      }

	 		$professional = array(
         'question_2' => $experiencia
      	);
	      $delExperiencia = Answer::upProfessional($professional, $user_id);

			$upProfile = Profile::recalculateProfile($user_id);
			if ($upProfile->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar seu Histórico Acadêmico. <br> Verifique os erros abaixo:',
					$excluirProfessional->errors
				));
			}
			else {
				$this->load('Helpers\Alert', array(
					'error',
					'Uuuu! Foi atualizado seu Histórico Acadêmico. <br> Recalculado seu Perfil Profissional:',
					$excluirProfessional->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

}