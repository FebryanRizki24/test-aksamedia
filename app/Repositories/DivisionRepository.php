<?php

namespace App\Repositories;

use App\Helper\Response;
use App\Models\Division;
use Exception;

class DivisionRepository
{
    protected $division, $response;

    public function __construct(Division $division, Response $response)
    {
        $this->division = $division;
        $this->response = $response;
    }

    public function getData($request)
    {
        try {
            $query = $this->division->select('id', 'name');
            if ($request->has('name')) {
                $query->where('name', 'like', "%{$request->name}%");
            }
            
            $division = $query->paginate(10);
            
            if ($division->isEmpty()) {
                return $this->response->empty('Divisi yang dicari tidak ada');
            }
            
            return $this->response->index($division, 'divisions');
        } catch (Exception $e) {
            return $this->response->empty($e->getMessage());
        }
    }
}
