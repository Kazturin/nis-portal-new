<div class="p-2">
    @foreach ($cards as $card)
    <div class="rounded-2xl overflow-hidden shadow-md mb-2">
        <div>
            {{ $card["text"] }}
        </div>   
        <h1>{{ $card["number"] .' '. $card["title"] }}</h1>    
    </div>
    @endforeach
</div>
