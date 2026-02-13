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
            'unsafeSql' => null,
        ]);
    }

    /**
     * Plantilla "Vulnerable".
     */
    public function vulnerable(Request $request)
{
    $term = trim((string) $request->input('term', ''));

    // Construir SQL concatenando input
    // NO lo ejecutamos; solo se muestra para evidencia académica
    $unsafeSql = "SELECT id, name, sku, price, stock
FROM products_demo
WHERE name LIKE '%{$term}%'
ORDER BY id DESC
LIMIT 50;";

    // Para poder comparar resultados en pantalla, usamos una búsqueda segura real
    $products = collect();
    $error = null;

    if ($term === '') {
        $error = 'Escribe algo para buscar.';
    } else {
        $products = DB::table('products_demo')
            ->select('id', 'name', 'sku', 'price', 'stock')
            ->where('name', 'like', '%' . $term . '%')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();
    }

    return view('sqli.index', [
        'mode' => 'vulnerable',
        'term' => $term,
        'products' => $products,
        'error' => $error,
        'unsafeSql' => $unsafeSql,
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
            'unsafeSql' => null,
        ]);
    }
}
