<?php

namespace App\Controller;

use App\Model\Author;
use Respect\Validation\Validator as V;
use Illuminate\Support\Facades\DB;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorController extends BaseController
{
    public function index($request, $response)
    {
        return $response->withJson(["status" => true, "data" => Author::with('book')->orderBy('id', 'desc')->get()], 200);
    }
    public function create($request, $response, $args)
    {

        $this->validator()->validate($request, [
            'nama' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],

        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        $parsedBody = $request->getParsedBody();
        try {
            $this->logger()->addInfo("Create Books created: ");
            $result = Author::create($parsedBody);
            return $response->withJson($result);
        } catch (\Illuminate\Database\QueryException $th) {
            return $response->withJson(["status" => false, "message" => $th]);
        } catch (\Throwable $th) {
            return $response->withJson(["status" => false, "message" => $th]);
        }
    }
    public function show($request, $response, $args)
    {
        $this->validator()->validate(
            $args['id'],
            V::numeric(),
            "required Book ID and numeric only"
        );
        if (!$this->validator()->isValid()) {
            return $response->withJson([
                'status' => false,
                'messages' => "required book ID and only numeric",
                'data' => []
            ]);
        }
        //add your logic here
        return $response->withJson(Author::getBook($args['id'], 'book_id'));
    }
    public function edit($request, $response, $args)
    {
        $this->validator()->validate($args['id'], V::NotEmpty(), "books_id is required");
        $this->validator()->validate($request, [
            'nama' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],
        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        //add your logic here
        return $response->withJson($args['id']);
    }
}
