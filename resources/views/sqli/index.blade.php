<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>SQLi Demo - Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: system-ui, Arial; margin: 24px; }
        .row { display: flex; gap: 12px; align-items: end; flex-wrap: wrap; }
        label { display:block; font-size: 14px; margin-bottom: 6px; }
        input { padding: 10px; min-width: 320px; }
        button { padding: 10px 14px; cursor: pointer; }
        .hint { color: #555; font-size: 13px; margin-top: 8px; }
        .box { margin-top: 18px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; }
        .error { color: #b00020; }
        table { border-collapse: collapse; width: 100%; margin-top: 14px; }
        th, td { border: 1px solid #ddd; padding: 10px; font-size: 14px; }
        th { background: #f7f7f7; text-align: left; }
        .badge { display:inline-block; padding: 4px 8px; border-radius: 999px; font-size: 12px; background:#eee; }
    </style>
</head>
<body>
    <h1>SQL Injection Demo (Products)</h1>

    <div class="box">
        <form method="POST" action="{{ route('sqli.secure') }}">
            @csrf
            <div class="row">
                <div>
                    <label for="term">Buscar por nombre</label>
                    <input id="term" name="term" value="{{ old('term', $term) }}" placeholder="Ej: manzana, uva, pera..." />
                    <div class="hint">Esto consulta la tabla <b>products_demo</b>.</div>
                </div>

                <button type="submit" formaction="{{ route('sqli.vulnerable') }}">
                    Buscar (Vulnerable)
                </button>

                <button type="submit">
                    Buscar (Seguro)
                </button>
            </div>
        </form>

        <div style="margin-top: 10px;">
            <span class="badge">Modo: {{ $mode ?? '—' }}</span>
            @if($term !== '')
                <span class="badge">Término: {{ $term }}</span>
            @endif
        </div>

        @if($error)
            <p class="error" style="margin-top: 10px;">{{ $error }}</p>
        @endif
    </div>

    <h2>Resultados</h2>

    @if($products->count() === 0)
        <p>No hay resultados aún.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->sku }}</td>
                        <td>{{ $p->price }}</td>
                        <td>{{ $p->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>