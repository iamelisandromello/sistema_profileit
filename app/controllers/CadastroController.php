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
			true
		);

		$this->auth->redirectCheck(true);
	}

	public function cadastrarAction()
	{
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
			'password'		=> $post['password']
		);
	
		//array de informações adicionais para Novo Usuário (Registros)
		$registry_data = array(
			'about'		=> $post['about'],
			'celular'	=> $post['celular'],
			'phone'		=> $post['phone'],
			'address'	=> $post['address'],
			'number'		=> $post['number'],
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

		$historic_data = $_POST['historic'];// copiar um arrays de um POST

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

		if (!empty($historic_data)) {
			$user_id = $cadastrarUsuario->user->id;
			foreach($historic_data as $data) {
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

			if ($cadastrarHistoric->status === true) {
				$this->auth->login($cadastrarUsuario->user->id, $cadastrarUsuario->user->username);
			}
		}

	}
}