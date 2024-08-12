<?php

namespace App\Http\Controllers;

use App\Http\Repository\RekeningRepo;
use App\Http\Requests\RekeningRequest;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    protected $repo;
    public function __construct(RekeningRepo $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(session('role'));
        return view('rekening.index');
    }

    public function dataRekening(Request $request)
    {
        $data = $this->repo->getAll($request->all());
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RekeningRequest $request)
    {
        $data = $this->repo->store($request->all());
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repo->getById($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RekeningRequest $request)
    {
        $id = $request->id;
        $data = $this->repo->update($request->all(), $id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Request $request)
    {
        $data = $this->repo->approve($request->id);
        return response()->json($data);
    }
}
