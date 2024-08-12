<?php

namespace App\Http\Controllers;

use App\Repositories\DivisionRepository;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    private $divisionRepository;

    public function __construct(DivisionRepository $divisionRepository)
    {
        $this->divisionRepository = $divisionRepository;
    }

    public function index(Request $request)
    {
        return $this->divisionRepository->getData($request);
    }
}
