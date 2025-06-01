<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePoolTableRequest;
use App\Http\Requests\UpdatePoolTableRequest;
use App\Models\PoolTableModel;
use Illuminate\Http\Request;

class PoolTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pool_tables.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getPoolTables()
    {
        return response()->json(PoolTableModel::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePoolTableRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['price_per_hour'] = (int) str_replace('.', '', $request->price_per_hour);

        $poolTable = PoolTableModel::create($validatedData);

        return response()->json(['message' => 'Berhasil disimpan', 'id' => $poolTable->id], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoolTableRequest $request, $id)
    {
        $validatedData = $request->validated();

        $validatedData['price_per_hour'] = (int) str_replace('.', '', $request->price_per_hour);

        $poolTable = PoolTableModel::findOrFail($id);

        $poolTable->update([
            'name' => $validatedData['name'],
            'price_per_hour' => $validatedData['price_per_hour'],
            'status' => $validatedData['status'],
            'x' => $validatedData['x'],
            'y' => $validatedData['y'],
            'orientation' => $validatedData['orientation'],
        ]);

        return response()->json(['message' => 'Berhasil diupdate', 'id' => $poolTable->id], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $poolTable = PoolTableModel::findOrFail($id);
        $poolTable->delete();

        return response()->json(['message' => 'Meja biliar berhasil dihapus.'], 201);
    }
}
