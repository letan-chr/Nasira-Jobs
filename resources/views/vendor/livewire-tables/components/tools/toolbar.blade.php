@aware(['tableName', 'isTailwind', 'isBootstrap'])
@props([])
@php($toolBarAttributes = $this->getToolBarAttributesBag)

<div
    {{
        $toolBarAttributes->merge()
        ->class([
            'lwt-toolbar nasira-table-toolbar' => $isBootstrap && ($toolBarAttributes['default-styling'] ?? true),
            'md:flex md:justify-between mb-4 px-4 md:p-0' => $isTailwind && ($toolBarAttributes['default-styling'] ?? true),
        ])
        ->except(['default', 'default-styling', 'default-colors'])
    }}
>
    @if ($this->hasConfigurableAreaFor('toolbar-left-start'))
        @include($this->getConfigurableAreaFor('toolbar-left-start'), $this->getParametersForConfigurableArea('toolbar-left-start'))
    @endif

    @if ($this->showReorderButton())
        <x-livewire-tables::tools.toolbar.items.reorder-buttons />
    @endif

    @if ($this->showSearchField())
        <div class="nasira-table-toolbar__search">
            <x-livewire-tables::tools.toolbar.items.search-field />
        </div>
    @endif

    {{-- Prefer Nasira custom filter UI; hide Livewire's stock Filters popover (tall/ugly). --}}
    @if (! empty($this->showFilterOnHeader) && ! empty($this->filterComponents[0] ?? null))
        <div class="nasira-table-toolbar__filters">
            @include($this->filterComponents[0], [
                'filterHeads' => [
                    $this->filterComponents[1] ?? '',
                    $this->filterComponents[2] ?? '',
                ],
            ])
        </div>
    @elseif ($this->showFiltersButton())
        <x-livewire-tables::tools.toolbar.items.filter-button />
    @endif

    @if ($this->showActionsInToolbarLeft() || $this->showActionsInToolbarRight())
        <x-livewire-tables::includes.actions/>
    @endif

    @if ($this->showBulkActionsDropdownAlpine() && $this->shouldAlwaysHideBulkActionsDropdownOption != true)
        <x-livewire-tables::tools.toolbar.items.bulk-actions />
    @endif

    @if ($this->columnSelectIsEnabled)
        <x-livewire-tables::tools.toolbar.items.column-select />
    @endif

    @if ($this->showPaginationDropdown())
        <div class="nasira-table-toolbar__perpage">
            <x-livewire-tables::tools.toolbar.items.pagination-dropdown />
        </div>
    @endif

    @if (! empty($this->showButtonOnHeader) && ! empty($this->buttonComponent))
        <div class="nasira-table-toolbar__actions">
            @include($this->buttonComponent)
        </div>
    @endif

    @if ($this->hasConfigurableAreaFor('toolbar-left-end'))
        @include($this->getConfigurableAreaFor('toolbar-left-end'), $this->getParametersForConfigurableArea('toolbar-left-end'))
    @endif

    @includeWhen($this->hasConfigurableAreaFor('toolbar-right-start'), $this->getConfigurableAreaFor('toolbar-right-start'), $this->getParametersForConfigurableArea('toolbar-right-start'))
    @includeWhen($this->hasConfigurableAreaFor('toolbar-right-end'), $this->getConfigurableAreaFor('toolbar-right-end'), $this->getParametersForConfigurableArea('toolbar-right-end'))
</div>
