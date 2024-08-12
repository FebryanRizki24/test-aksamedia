<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Repositories\KaryawanRepository;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    private $karyawanRepository;

    public function __construct(KaryawanRepository $karyawanRepository)
    {
        $this->karyawanRepository = $karyawanRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->karyawanRepository->getData($request);
    }

    public function store(Request $request)
    {
        return $this->karyawanRepository->create($request);
    }

    public function update(Request $request, $id)
    {
        return $this->karyawanRepository->edit($request, $id);
    }

    public function destroy($id)
    {
        return $this->karyawanRepository->delete($id);
    }
}
