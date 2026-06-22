<?php

namespace app\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;
use App\Models\CartModel; 

class AuthController extends BaseController
{
    protected $userModel;

    function __construct()
    {
        helper('form');
        $this->userModel = new UserModel();
    }
    public function login()
{
    if ($this->request->getPost()) {
        $rules = [
            'username' => 'required|min_length[6]',
            'password' => 'required|min_length[7]|numeric',
        ];

    if ($this->validate($rules)) {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $dataUser = $this->userModel->where(['username' => $username])->first();

        if ($dataUser) {
	        if (password_verify($password, $dataUser['password'])) {
                session()->set([
                    'id'         => $dataUser['id'],
                    'username'   => $dataUser['username'],
                    'role'       => $dataUser['role'],
                    'isLoggedIn' => TRUE
                ]);

                $userId = $dataUser['id'];
                $cartModel = new CartModel();
                $guestCart = service('cart')->contents();

                foreach ($guestCart as $item) {
                    $cartModel->addOrUpdateItem($userId, $item['id'], $item['qty']);
                }

                service('cart')->destroy();

                $dbCart = $cartModel->getCartByUser($userId);
                foreach ($dbCart as $item) {
                    service('cart')->insert([
                        'id'      => $item['product_id'],
                        'qty'     => $item['qty'],
                        'price'   => $item['harga'],
                        'name'    => $item['nama'],
                        'options' => ['foto' => $item['foto']],
                    ]);
                }

                return redirect()->to(base_url('/'));
            } else {
                return redirect()->to('login')->with('failed', 'Username & Password Salah');
            }
        } else {
            return redirect()->to('login')->with('failed', 'Username Tidak Ditemukan');
        }
    } else {
        return redirect()->to('login')->with('failed', 'Username & Password Salah');
    }
    } else {
        return view('v_login');
    }
}
public function logout()
{
    session()->destroy();
    return redirect()->to('login');
}
}
