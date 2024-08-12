<?php

namespace App\Http\Repository;

use App\Models\Rekening;

class RekeningRepo
{
    protected $rekening;
    public function __construct(Rekening $rekening)
    {
        $this->rekening = $rekening;
    }

    public function getAll($req)
    {
        $column = $req['order'][0]['column'] ?? null;
        $dir = $req['order'][0]['dir'] ?? 'asc';
        $search = $req['search']['value'] ?? null;

        $q = $this->rekening->query();

        $q->when($req['status'] ?? null, function ($q) use ($req) {
            $q->where('status', $req['status']);
        });

        $q->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'ilike', '%' . $search . '%')
                    ->orWhere('pekerjaan', 'ilike', '%' . $search . '%')
                    ->orWhere('nominal', 'ilike', '%' . $search . '%')
                    ->orWhere('tempat_lahir', 'ilike', '%' . $search . '%');
            });
        });

        $q->when($column, function ($q) use ($column, $dir) {
            if ($column == 1) {
                $q->orderBy('nama_lengkap', $dir);
            } elseif ($column == 2) {
                $q->orderBy('tempat_lahir', $dir);
            } elseif ($column == 3) {
                $q->orderBy('tgl_lahir', $dir);
            } elseif ($column == 4) {
                $q->orderBy('jk', $dir);
            } elseif ($column == 5) {
                $q->orderBy('pekerjaan', $dir);
            } elseif ($column == 6) {
                $q->orderBy('nominal', $dir);
            } elseif ($column == 7) {
                $q->orderBy('updated_at', $dir);
            } elseif ($column == 8) {
                $q->orderBy('status', $dir);
            }
        });

        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 10;

        return $q->paginate($length, ['*'], 'page', $start / $length + 1);
    }

    public function store(array $data)
    {
        $data['status'] = 'pending';
        $data['nominal'] = preg_replace('/[^0-9]/', '', $data['nominal']);
        $this->rekening->create($data);
        return response()->json(['message' => 'Data berhasil ditambahkan', 'status' => 'success'], 200);
    }

    public function getById($id)
    {
        return $this->rekening->find($id);
    }

    public function update(array $data, $id)
    {
        $statusRek = $this->rekening->find($id);
        $data['nama_lengkap'] = preg_replace('/[^a-zA-Z ]/', '', $data['nama_lengkap']);
        $data['status'] = $statusRek->status;
        $data['nominal'] = preg_replace('/[^0-9]/', '', $data['nominal']);
        if ($data['status'] == 'approved') {
            return response()->json(['message' => 'Data yang sudah diapprove tidak bisa diubah', 'status' => 'error'], 422);
        } else {
            $this->rekening->find($id)->update($data);
            return response()->json(['message' => 'Data berhasil diupdate', 'status' => 'success'], 200);
        }
    }

    public function approve($id)
    {
        $data = $this->rekening->find($id);
        if ($data->status == 'approved') {
            return response()->json(['message' => 'Data ini telah diapprove', 'status' => 'error'], 422);
        } else {
            $data->status = 'approved';
            $this->rekening->find($id)->update($data->toArray());
            return response()->json(['message' => 'Data berhasil diapprove', 'status' => 'success'], 200);
        }
    }
}
