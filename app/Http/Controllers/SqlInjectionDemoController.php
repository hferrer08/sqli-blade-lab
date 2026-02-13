<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlInjectionDemoController extends Controller
{
     public function index()
    {
        // Vista inicial sin resultados
        return view('sqli.index', [
            'mode' => null,
            'term' => '',
            'products' => collect(),
            'error' => null,
        ]);
    }

    /**
     * Plantilla "Vulnerable".
     */
    public function vulnerable(Request $request)
    {
        $term = (string) $request->input('term', '');

        return view('sqli.index', [
            'mode' => 'vulnerable',
            'term' => $term,
            'products' => collect(),
            'error' => 'Modo vulnerable: agrega aquí el ejemplo inseguro (concatenación SQL) SOLO para laboratorio local.',
        ]);
    }

    /**
     * Versión segura:
     */
    public function secure(Request $request)
    {
        $term = trim((string) $request->input('term', ''));

        // Validación simple para la demo
        if ($term === '') {
            return view('sqli.index', [
                'mode' => 'secure',
                'term' => $term,
                'products' => collect(),
                'error' => 'Escribe algo para buscar.',
            ]);
        }

        // Búsqueda segura (parametrizada)
        $products = DB::table('products_demo')
            ->select('id', 'name', 'sku', 'price', 'stock')
            ->where('name', 'like', '%' . $term . '%')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();

        return view('sqli.index', [
            'mode' => 'secure',
            'term' => $term,
            'products' => $products,
            'error' => null,
        ]);
    }
}
