<?php
namespace   App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class ComponentService {
    private $validator;
    private $repository;

    public function __construct( $validator,  $repository) {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(Request $request) {
        try {
            $data = $this->validator->validate($request);
            $component = $this->repository->create($data);
            return response()->json($component, 201);
        }catch (\Throwable $th) {
            return response()->json([
                $component,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}