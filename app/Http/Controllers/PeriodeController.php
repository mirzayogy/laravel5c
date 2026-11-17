<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_periode = Periode::all();
        return view('periode.index', compact('semua_periode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'periode' => ['required', 'string', 'max:16', 'min:15', 'unique:periode,periode'],
            'singkatan' => ['required', 'string', 'min:3', 'max:3', 'unique:periode,singkatan'],
        ], [
            'periode.required' => 'Nama periode wajib diisi.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'periode.unique' => 'Periode ini sudah ada.',
            'singkatan.unique' => 'Singkatan sudah dipakai periode lain.',
            'periode.min' => 'Periode minimal 15 karakter.',
            'periode.max' => 'Periode maksimal 16 karakter.',
            'singkatan.min' => 'Singkatan harus 3 karakter.',
            'singkatan.max' => 'Singkatan harus 3 karakter.',
        ]);

        $data['status'] = $request->boolean('status');

        Periode::create($data);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periode $periode)
    {
        return view('periode.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periode $periode)
    {
        $data = $request->validate([
            'periode' => ['required', 'string', 'max:16', 'min:15', 'unique:periode,periode,' . $periode->id],
            'singkatan' => ['required', 'string', 'min:3', 'max:3', 'unique:periode,singkatan,' . $periode->id],
        ], [
            'periode.required' => 'Nama periode wajib diisi.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'periode.unique' => 'Periode ini sudah ada.',
            'singkatan.unique' => 'Singkatan sudah dipakai periode lain.',
            'periode.min' => 'Periode minimal 15 karakter.',
            'periode.max' => 'Periode maksimal 16 karakter.',
            'singkatan.min' => 'Singkatan harus 3 karakter.',
            'singkatan.max' => 'Singkatan harus 3 karakter.',
        ]);

        $data['status'] = $request->boolean('status');

        $periode->update($data);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }

    public function cetak()
    {
        $semua_periode = Periode::all();
        return view('periode.laporan', compact('semua_periode'));
    }
}
