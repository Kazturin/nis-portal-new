<div>
    <h2>Запросы для продукта ID: {{ $productId }}</h2>
    @if($requests->isEmpty())
        <p>Запросов для этого продукта нет.</p>
    @else
        <ul>
            @foreach($requests as $request)
                <li>{{ $request->id }} - {{ $request->data }}</li> <!-- Замените 'data' на нужное поле -->
            @endforeach
        </ul>
    @endif
</div>
