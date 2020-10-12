<?php

namespace App\Controller;

use App\Model\Author;
use \App\Model\Book;
use Respect\Validation\Validator as V;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Pagination;

use Illuminate\Pagination\Paginator;

class BooksController extends BaseController
{
    public function exportcsv($request, $response)
    {
        // return $response->write(Book::all());
        $data = Book::all()->toArray();
        // var_dump($list);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'Hello World !');
        $headers = ['a', 'b'];
        for ($i = 0, $l = sizeof($headers); $i < $l; $i++) {
            $sheet->setCellValueByColumnAndRow($i + 1, 1, $headers[$i]);
        }

        for ($i = 0, $l = sizeof($data); $i < $l; $i++) { // row $i
            $j = 0;
            foreach ($data[$i] as $k => $v) { // column $j
                $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $v);
                $j++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "export_.xlsx";
        $writer->save('php://output');
        header("Content-Disposition: attachment; filename=" . $filename);
        exit();
    }
    public function index($request, $response)
    {
        $params = $request->getQueryParam('page', 1);
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($params) {
            return $params;
        });
        return $response->withJson(
            Book::with('Author')
                ->orderBy('created_at', 'desc')->simplePaginate(15)
        );
    }
    public function create($request, $response, $args)
    {
        Book::beginTransaction();
        $this->validator()->validate($request, [
            'title' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],
            'author_id' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'sinopsis' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'cover' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        $parsedBody = $request->getParsedBody();
        try {
            // Book::beginTransaction();
            $this->logger()->addInfo("Create Books created: ");
            $result = Book::create($parsedBody);
            Book::commit();
            return $response->withJson($result);
            // Book::commit();
        } catch (\Illuminate\Database\QueryException $th) {
            Book::rollBack();
            return $response->withJson(["status" => false, "message" => $th]);
        } catch (\Exception $th) {
            Book::rollBack();
            return $response->withJson(["status" => false, "message" => $th]);
        }
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
        //add your logic here
        return $response->withJson(Book::with('author')->findOrFail($args['id']));
    }
    public function edit($request, $response, $args)
    {
        $this->validator()->validate($args['id'], V::NotEmpty(), "books_id is required");
        $this->validator()->validate($request, [
            'title' => ["rules" => V::notEmpty(), 'message' => "Tidak Boleh Kosong"],
            'author_id' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'sipnosis' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
            'cover' => ["rules" => V::notEmpty(), "message" => "Tidak Boleh Kosong"],
        ]);
        if (!$this->validator()->isValid()) {
            return $response->withJson(['status' => false, 'messages' => $this->validator()->getErrors(), "data" => []], 200);
        }
        //add your logic here
        return $response->withJson($args['id']);
    }
}
