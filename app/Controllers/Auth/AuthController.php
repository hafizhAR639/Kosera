<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Auth\UserAuthModel;

class AuthController extends Controller
{
    public function welcome(): void
    {
        if (Auth::isLoggedIn()) {
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        $this->render('auth/welcome', [
            'title' => 'Beranda',
            'message' => Helpers::getMessage(),
        ], 'public');
    }

    public function showLogin(): void
    {
        if (Auth::isLoggedIn()) {
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        $this->render('auth/login', [
            'title' => 'Login',
            'message' => Helpers::getMessage(),
        ], 'public');
    }

    public function login(): void
    {
        if (Auth::isLoggedIn()) {
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        $email = Helpers::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            Helpers::setMessage('error', 'Email dan password wajib diisi.');
            $this->redirect(Helpers::routePath('/login'));
        }

        $user = (new UserAuthModel())->findByEmail($email);
        if ($user && $user['password'] === md5($password)) {
            $_SESSION['user_id'] = (int)$user['id'];
            Helpers::setMessage('success', 'Login berhasil. Selamat datang, ' . $user['nama'] . '!');
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        Helpers::setMessage('error', 'Email atau password tidak valid.');
        $this->redirect(Helpers::routePath('/login'));
    }

    public function showRegister(): void
    {
        if (Auth::isLoggedIn()) {
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        $this->render('auth/register', [
            'title' => 'Daftar',
            'message' => Helpers::getMessage(),
        ], 'public');
    }

    public function register(): void
    {
        if (Auth::isLoggedIn()) {
            $this->redirect(Helpers::routePath('/mitra/dashboard'));
        }

        $nama = Helpers::sanitize($_POST['nama'] ?? '');
        $email = Helpers::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if ($nama === '' || $email === '' || $password === '' || $passwordConfirm === '') {
            Helpers::setMessage('error', 'Semua field wajib diisi.');
            $this->redirect(Helpers::routePath('/register'));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helpers::setMessage('error', 'Format email tidak valid.');
            $this->redirect(Helpers::routePath('/register'));
        }

        if (strlen($password) < 8) {
            Helpers::setMessage('error', 'Password minimal 8 karakter.');
            $this->redirect(Helpers::routePath('/register'));
        }

        if ($password !== $passwordConfirm) {
            Helpers::setMessage('error', 'Konfirmasi password tidak sama.');
            $this->redirect(Helpers::routePath('/register'));
        }

        $authModel = new UserAuthModel();
        if ($authModel->findByEmail($email) !== null) {
            Helpers::setMessage('error', 'Email sudah terdaftar. Silakan login.');
            $this->redirect(Helpers::routePath('/login'));
        }

        $ok = $authModel->createUser($nama, $email, md5($password));
        if ($ok) {
            Helpers::setMessage('success', 'Pendaftaran berhasil. Silakan login.');
            $this->redirect(Helpers::routePath('/login'));
        }

        Helpers::setMessage('error', 'Pendaftaran gagal. Coba lagi.');
        $this->redirect(Helpers::routePath('/register'));
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        $this->redirect(Helpers::routePath('/'));
    }
}
