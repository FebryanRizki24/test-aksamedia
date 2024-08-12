<?php

namespace App\Repositories;

use App\Helper\Response;
use App\Models\Karyawan;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class KaryawanRepository
{
    protected $karyawan, $response;

    public function __construct(Karyawan $karyawan, Response $response)
    {
        $this->karyawan = $karyawan;
        $this->response = $response;
    }

    public function getData($request)
    {
        try {
            $query = $this->karyawan->with(['division' => function ($query) {
                $query->select('id', 'name');
            }])->select('id', 'name', 'image', 'phone', 'position', 'division_id');

            if ($request->has('name')) {
                $query->where('name', 'like', "%{$request->name}%");
            }

            if ($request->has('division_id')) {
                $query->where('division_id', $request->division_id);
            }

            $karyawan = $query->paginate(10);

            if ($karyawan->isEmpty()) {
                return $this->response->empty('Karyawan yang dicari tidak ada');
            }

            return $this->response->index($karyawan, 'employees');
        } catch (Exception $e) {
            return $this->response->empty($e->getMessage());
        }
    }

    protected function validateRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:9,13',
            'division_id' => 'required|exists:divisions,id',
            'position' => 'required|string|max:255'
        ]);

        return $validator;
    }

    public function create($request)
    {
        try {
            $validator = $this->validateRequest($request);

            if ($validator->fails()) {
                return $this->response->storeError($validator->errors());
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' .  $request->name . '.' . $extension;
                $image->move(app()->basePath('public') . '/images/karyawans', $imageName);
            }

            $karyawan = $this->karyawan->create([
                'name' => $request->name,
                'image' => $imageName,
                'phone' => $request->phone,
                'position' => $request->position,
                'division_id' => $request->division_id,
            ]);

            return $this->response->store($karyawan);
        } catch (Exception $e) {
            return $this->response->empty($e->getMessage());
        }
    }

    public function findById($id)
    {
        return $this->karyawan->find($id);
    }

    public function edit($request, $id)
    {
        try {
            $karyawan = $this->findById($id);

            if (!$karyawan) {
                return $this->response->notFound();
            }

            $validator = $this->validateRequest($request);

            if ($validator->fails()) {
                return $this->response->updateError($validator->errors());
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . $request->name  . '.' . $extension;
                $image->move(app()->basePath('public') . '/images/karyawans', $imageName);

                if ($karyawan->image && File::exists(app()->basePath('public') . '/images/karyawans/' . $karyawan->image)) {
                    File::delete(app()->basePath('public') . '/images/karyawans/' . $karyawan->image);
                }
            }

            $karyawan->update([
                'name' => $request->name,
                'image' => $imageName,
                'phone' => $request->phone,
                'position' => $request->position,
                'division_id' => $request->division_id,
            ]);

            return $this->response->update($karyawan);
        } catch (Exception $e) {
            return $this->response->empty($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $karyawan = $this->findById($id);

            if (!$karyawan) {
                return $this->response->notFound();
            }

            File::delete(app()->basePath('public') . '/images/karyawans/' . $karyawan->image);

            $karyawan->delete();

            return $this->response->destroy($karyawan);
        } catch (Exception $e) {
            return $this->response->empty($e->getMessage());
        }
    }
}
