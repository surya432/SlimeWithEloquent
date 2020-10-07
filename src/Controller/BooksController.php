<?php

namespace App\Controller;

use \App\Model\Book as BookModel;
use Respect\Validation\Validator as V;

class BooksController extends BaseController
{
    public function index($request, $response)
    {
        $this->logger()->addInfo('Request: Books->all');
        return $response->withJson(BookModel::orderBy('book_id', 'desc')->get());
    }
    public function create($request, $response, $args)
    {
        $this->validator()->validate($request, [
            'title' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],
            'author' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'sipnosis' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'cover' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        $this->logger()->addInfo("Create Books Show: " . $args['id']);
        return $response->withJson(BookModel::getBook($args['id'], 'book_id'));
    }
    public function show($request, $response, $args)
    {
        $this->validator()->value(
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
        $this->logger()->addInfo("Request Books Show: " . $args['id']);
        //add your logic here
        return $response->withJson(BookModel::getBook($args['id'], 'book_id'));
    }
    public function edit($request, $response, $args)
    {
        $this->validator()->validate($args['id'], V::NotEmpty(), "books_id is required");
        $this->validator()->validate($request, [
            'title' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],
            'author' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'sipnosis' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'cover' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        $this->logger()->addInfo('Request: Books->edit: ' . $args['id']);
        //add your logic here
        return $response->withJson($args['id']);
    }
}
