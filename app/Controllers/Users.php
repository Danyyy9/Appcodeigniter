<?php namespace App\Controllers;

use App\Models\UserModel;


class Users extends BaseController
{
	public function index()
	{

		$data = [];
		helper(['form']);


		echo view('template/header', $data);
		echo view('login');
		echo view('template/footer');
	}
	public function register()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//Let's do some validation rules
			$rules = [
				'firstname' => 'required|min_lenght[3]|max_lenght[20]',
				'lastname' => 'required|min_lenght[3]|max_lenght[20]',
				'email' => 'required|min_lenght[6]|max_lenght[50]|valid_mail|is_unique[users.email]',
				'password' => 'required|min_lenght[8]|max_lenght[255]',
				'password_confirm' => 'matches[password]',
			];
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$newdata = [
					'firstname' => $this->request->getVar('firstname'),
					'lastname' => $this->request->getVar('lastname'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($newdata);
				$session = session();
				$session->setFlashdata('success', 'Inregistrat cu Succes');
				return redirect()->to('/');
			}
		}



		echo view('template/header', $data);
		echo view('register');
		echo view('template/footer');
	}
	//--------------------------------------------------------------------

}
