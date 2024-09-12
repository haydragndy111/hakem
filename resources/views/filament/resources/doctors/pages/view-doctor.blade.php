@php
    $relationManagers = $this->getRelationManagers();
    // dd($relationManagers);
@endphp
<x-filament-panels::page>
    @if ($this->hasInfolist())
        {{ $this->infolist }}
    @endif
    <livewire:Doctor />
    <x-filament-panels::resources.relation-managers
        :active-locale="null"
        active-manager="0"
        :content-tab-label="'Tab'"
        :managers="$relationManagers"
        :owner-record="$record"
        :page-class="static::class">
    </x-filament-panels::resources.relation-managers>
</x-filament-panels::page>
