<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    # Affiche la vue de la page de connexion
    public function login()
    {
        return view('auth.login');
    }

    # Déconnecte l'utilisateur et le redirige vers la page de connexion
    public function logout()
    {
        Auth::logout(); # Déconnexion de l'utilisateur
        return to_route('auth.login'); # Redirection vers la page de connexion
    }

    # Gère la tentative de connexion de l'utilisateur après soumission du formulaire
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated(); # Récupération des informations authentifiées (email & mot de passe validés)
        if (Auth::attempt($credentials)) { # Tentative d'authentification
            $request->session()->regenerate(); # Régénère la session pour des raisons de sécurité
            return redirect()->intended(route('blog.index')); # Redirection vers la page d'accueil du blog
        }
        
        return to_route('auth.login')->withErrors([
            'email' => 'Email invalide' # En cas d'échec, retourne à la page de connexion avec un message d'erreur spécifique à l'email
        ])->onlyInput('email');
    }
}

// https://www.linkedin.com/in/ny-aina-razanakoto-b8832a293/
// https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-polymorphic-relations
// https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-polymorphic-relations
// https://github.com/miew-miew/introduction_laravel