<x-mail::message>
# Nuova prenotazione!

Ciao! Il libro "{{ $titolo }}" è stato prenotato da {{ $name }}.
Click sul bottone qui sotto per visualizzare le prenotazioni.

<x-mail::button :url="config('app.url').'/admin/prenota'">
Visualizza prenotazioni
</x-mail::button>

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
