<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Services\AuthService;
use Respect\Validation\Validator as V;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{

    public function changePassword($request, $response, $args)
    {
        try {
            $parsedBody = $request->getParsedBody();
            $this->validator()->value($args['id'], V::notEmpty(), "User id required");
            $this->validator()->validate($request, [
                'password' => [
                    "rules" => V::notEmpty(),
                    'message' => "Password Tidak Boleh Kosong"
                ],
                'repassword' => [
                    "rules" => V::equals($parsedBody['password']),
                    'message' => "Password Tidak sama"
                ]
            ]);
            if (!$this->validator()->isValid()) {
                return $response->withJson([
                    'status' => false,
                    'messages' => $this->validator()->getErrors(), "data" => []
                ], 200);
            }
            $accountService = new AuthService();
            $isLogin = $accountService->changePassword($parsedBody, $args['id']);
            return $response->withJson($isLogin);
        } catch (\Exception $th) {
            return $response->withJson(["status" => false, "message" => $th]);
        }
    }
    public function signup(Request $request, Response $response, $args)
    {
        // return $response->withJson($parsedBody);
        try {
            $parsedBody = $request->getParsedBody();
            $this->validator()->validate($request, [
                'password' => [
                    "rules" => V::notEmpty(),
                    'message' => "Password Tidak Boleh Kosong"
                ],
                'email' => [
                    "rules" => V::notEmpty(),
                    'message' => "Email Tidak Boleh Kosong"
                ],
                'nama' => [
                    "rules" => V::notEmpty(),
                    'message' => "nama Tidak Boleh Kosong"
                ],
                'repassword' => [
                    "rules" => V::equals($parsedBody['password']),
                    'message' => "Password Tidak sama"
                ]
            ]);
            if (!$this->validator()->isValid()) {
                return $response->withJson([
                    'status' => false,
                    'messages' => $this->validator()->getErrors(), "data" => []
                ], 200);
            }
            $accountService = new AuthService();
            $isLogin = $accountService->signUp($parsedBody);
            if (!$isLogin['status']) {
                return $response->withJson($isLogin);
            } else {
                return $response->withJson($isLogin);
            }
        } catch (\Exception $th) {
            return $response->withJson(["status" => false, "message" => $th]);
        }
    }
    public function login($request, $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        // return $response->withJson($parsedBody);
        try {
            $this->validator()->validate($request, [
                'password' => [
                    "rules" => V::notEmpty(),
                    'message' => "Password Tidak Boleh Kosong"
                ],
                'email' => [
                    "rules" => V::notEmpty(),
                    'message' => "Email Tidak Boleh Kosong"
                ],

            ]);
            if (!$this->validator()->isValid()) {
                return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
            }

            $accountService = new AuthService();
            $isLogin = $accountService->login($parsedBody);
            if (!$isLogin['status']) {
                return $response->withJson($isLogin);
            } else {
                return $response->withJson($isLogin);
            }
        } catch (\Exception $th) {
            return $response->withJson(["status" => false, "message" => $th]);
        }
    }
}
