<x-mail::message>
# Promemoria prestito scaduto

Gentile {{ $name }},<br>

ti ricordiamo che il prestito per il libro "{{ $titolo }}" è scaduto.

Per favore, provveda a consegnare il libro alla biblioteca il prima possibile.

Grazie per la collaborazione.

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
