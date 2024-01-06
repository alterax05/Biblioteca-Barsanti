<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Google\Client;
use Google\Service\Directory;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Strings;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function index() {
        return view('auth.login');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     *
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')
        ->scopes(['https://www.googleapis.com/auth/admin.directory.user', 'https://www.googleapis.com/auth/admin.directory.user.readonly'])
        ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     *
     */
    public function handleProviderCallback()
    {
        //Connect to Google
        try {
            $userOAuth = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['email' => "Errore di connessione con Google!"]);
        }

        //Check if the email is from the school
        if(explode("@", $userOAuth->email)[1] !== 'barsanti.edu.it'){
            return redirect()->to('/login')->withErrors(['email' => "L'email deve essere dell'istituto! (@barsanti.edu.it)"]);
        }

        //Prepare the Google Client
        $client = new Client();
        $client->setAccessToken($userOAuth->token);
        $client->addScope(['https://www.googleapis.com/auth/admin.directory.user', 'https://www.googleapis.com/auth/admin.directory.user.readonly']);
        $service = new Directory($client);

        // Get the user's class
        try {
            $googleUser = $service->users->get($userOAuth->getId(),['projection' => 'full', 'viewType' => 'domain_public']);
            try {
                $classe = explode(" ", $googleUser->getOrganizations()[1]['department'])[0];
            } catch (Exception $e) {
                $classe = "scuola";
            }

            if ($classe == "Dipartimento") {
                $classe = "Professore";
            }

            $existingUser = User::updateOrCreate([
                'email' => $userOAuth->email,
            ], [
                'name' => $userOAuth->user['given_name'],
                'surname' => $userOAuth->user['family_name'] ?? $userOAuth->user['given_name'],
                'class' => $classe,
            ]);

        } catch (Exception $e) {
            return redirect('/login')->withErrors(['class' => "Impossibile trovare la classe dell'utente!"]);
        }
        
        //Login the user
        if($existingUser) {
            auth()->login($existingUser, true);
        }
        return redirect()->to('/profile');
    }
}
