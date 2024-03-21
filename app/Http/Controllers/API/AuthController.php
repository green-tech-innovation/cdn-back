<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterVerifyRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\CommonResource;
use App\Mail\MailSender;
use App\Models\Entity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authapi:api', ['except' => ['login', 'register', 'forgot_password', 'seed', 'unauthentized']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input("email"))->first();

        if ($user) {
            if (Hash::check($request->input("password"), $user->password)) {

                if(Entity::where('user_id', $user->id)->where('type', strtoupper($request->input("type")))->count() == 1) {
                    $token = auth()->guard("api")->fromUser($user);

                    $entity = Entity::where('user_id', $user->id)->where('type', strtoupper($request->input("type")))->first();

                    return $this->respondWithToken($token, $user, $entity);
                } else {
                    return response()->json([
                        "status" => false,
                        'error' => 'Unauthorized',
                        "message" => "Identifiant ou mot de passe incorrect"
                    ], 401);
                }
            } else {
                return response()->json([
                    "status" => false,
                    'error' => 'Unauthorized',
                    "message" => "Identifiant ou mot de passe incorrect"
                ], 401);
            }
        } else {
            return response()->json([
                "status" => false,
                'error' => 'Unauthorized',
                "message" => "Identifiant ou mot de passe incorrect"
            ], 401);
        }
    }

    public function register(RegisterVerifyRequest $request) {
        User::where('email', $request->email)->delete();

        $user = User::create([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "lastname" => $request->lastname,
            "firstname" => $request->firstname,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "email_verified_at" => Carbon::now()
        ]);


        return response()->json([
            "status" => true,
            "data" => $user,
            // "token" => auth()->guard('api')->login($user)
        ]);
    }



    public function forgot_password(ForgotPasswordRequest $request) {
        $user = User::where('email', $request->input("email"))->first();

        if ($user) {
            $password = generateRandomString();

            User::where('email', $request->input("email"))->update([
                "password" => Hash::make($password)
            ]);

            $details = [
                "subject" => "Réinitialisation Mot de passe",
                "type" => "forgot-password",
                "title" => "Réinitialisation Mot de passe",
                "password" => $password
            ];

            Mail::to($request->input("email"))->queue(new MailSender($details));

            return response()->json([
                "status" => true,
                "message" => "Félicitation. Nous venons de vous envoyer votre nouveau mot de passe."
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Désolé. Nous ne retrouvons pas votre compte, vérifiez le mail. Merci"
            ]);
        }
    }


    public function update_password(UpdatePasswordRequest $request) {
        $user = auth()->guard('api')->user();

        if (Hash::check($request->input("last_password"), $user->password)) {

            User::where('id', $user->id)->update([
                "password" => Hash::make($request->input("new_password"))
            ]);

            return response()->json([
                "status" => true,
                "message" => "Félicitation votre mot de passe a été bien changé."
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Mot de passe incorrect"
            ]);
        }
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = auth()->guard('api')->user();
            $entity = Entity::where('user_id', $user->id)->with(['category', 'user'])->first();
            $user['entity'] = $entity;
            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(["error" => $e->getMessage()])->setStatusCode(401);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user, $entity)
    {
        return response()->json([
            "status" => true,
            'user' => $user,
            'entity' => $entity,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60*24*355
        ]);
    }


    public function seed() {
        if(User::where('email', "emailagentcdn@gmail.com")->count() == 0) {
            $user = User::create([
                "email" => "emailagentcdn@gmail.com",
                "password" => Hash::make("123456"),
                "lastname" => "Nom de Famille",
                "firstname" => "Prénom",
                "phone" => "+229970000000",
                "sex" => "Masculin",
                "email_verified_at" => Carbon::now()
            ]);

            Entity::create([
                "email" => "cdn@gmail.com",
                "phone" => "+22996000000",
                "address" => "BP 22 Cotonou",
                "name" => "CDN",
                "type" => "CDN",
                "user_id" => $user->id,
                "slug" => slug("cdn"),
                "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt, facilis! Laboriosam quis iure exercitationem dolore aliquid doloribus excepturi! Et corrupti illo aliquam officia ab pariatur sequi, ad sint tempore sed."
            ]);
        }

        return response()->json("Le CDN a été bien créé");
    }

    public function unauthentized() {
        return response()->json([
            "error" => "unauthentized"
        ])->setStatusCode(401);
    }
}
