{{-- relationships with pivot table (n-n) --}}
@php
    $column['escaped'] = $column['escaped'] ?? true;
    $column['limit'] = $column['limit'] ?? 40;
    $column['attribute'] = $column['attribute'] ?? (new $column['model'])->identifiableAttribute();

    $results = data_get($entry, $column['name']);
    $results_array = [];

    if(!$results->isEmpty()) {
        $related_key = $results->first()->getKeyName();
        $results_array = $results->pluck($column['attribute'],$related_key)->toArray();
        $lastKey = array_key_last($results_array);
    }

    foreach ($results_array as $key => $text) {
        $text = Str::limit($text, $column['limit'], '[...]');
    }
@endphp

<span>
    @if (!empty($results_array))
        @foreach ($results_array as $key => $text)
            @php
                $related_key = $key;
            @endphp

            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
                @if($column['escaped'])
                    {{ $text }}
                @else
                    {!! $text !!}
                @endif
            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

            @if($lastKey != $key), @endif
        @endforeach
    @else
        -
    @endif
</span>
