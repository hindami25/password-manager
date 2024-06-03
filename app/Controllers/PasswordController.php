<?php

namespace App\Controllers;

use App\Models\PasswordModel;
use CodeIgniter\Controller;

class PasswordController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $passwordModel = new PasswordModel();
        $passwords = $passwordModel->where('user_id', session()->get('user_id'))->findAll();

        return view('dashboard', ['passwords' => $passwords]);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'website' => 'required',
            'username' => 'required',
            'password' => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('add_password', ['validation' => $validation]);
        }

        $passwordModel = new PasswordModel();
        $passwordEncrypted = encrypt($this->request->getVar('password'), session()->get('master_key'));

        $passwordModel->save([
            'user_id' => session()->get('user_id'),
            'website' => $this->request->getVar('website'),
            'username' => $this->request->getVar('username'),
            'password_encrypted' => $passwordEncrypted
        ]);

        return redirect()->to('/dashboard');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        helper(['form', 'url']);

        $passwordModel = new PasswordModel();
        $password = $passwordModel->find($id);

        if ($password['user_id'] != session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'website' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('edit_password', ['validation' => $validation, 'password' => $password]);
        }

        $passwordEncrypted = encrypt($this->request->getVar('password'), session()->get('master_key'));

        $passwordModel->update($id, [
            'website' => $this->request->getVar('website'),
            'username' => $this->request->getVar('username'),
            'password_encrypted' => $passwordEncrypted
        ]);

        return redirect()->to('/dashboard');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $passwordModel = new PasswordModel();
        $password = $passwordModel->find($id);

        if ($password['user_id'] != session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        $passwordModel->delete($id);

        return redirect()->to('/dashboard');
    }

    public function generate()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        helper('text');
        $generatedPassword = random_string('alnum', 16);

        return view('generate_password', ['generatedPassword' => $generatedPassword]);
    }
}
