@component('mail::message')
# Low Stock Alert

The ingredient **{{ $ingredient->name }}** has reached a low stock level.

## Stock Details:
- Current Stock: {{ $currentStock }} {{ $ingredient->unit }}
- Initial Stock: {{ $initialStock }} {{ $ingredient->unit }}

Please restock this ingredient as soon as possible to maintain proper inventory levels.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
