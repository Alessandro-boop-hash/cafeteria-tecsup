<?php

namespace App\Http\Controllers;

use App\Models\Bebida;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BebidaController extends Controller
{
    public function index()
    {
        // Traemos las bebidas con su categoría asignada
        $bebidas = Bebida::with('categoria')->get();
        $categorias = Categoria::all();
        return Inertia::render('Bebidas/Index', [
            'bebidas' => $bebidas,
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Lógica de 3 puntos: Subir imagen
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('bebidas', 'public');
        }

        Bebida::create($data);
        return redirect()->back();
    }
    
    public function destroy(Bebida $bebida)
    {
        $bebida->delete();
        return redirect()->back();
    }
}