<x-filament-panels::page>
    @if ($this->hasInfolist())
    {{ $this->infolist }}
    @else
        <p></p>
        {{ $this->form }}
    @endif

</x-filament-panels::page>
