<?php

namespace TallStackUi\View\Components\Select\Traits;

trait InteractsWithSelectOptions
{
    private function options(): void
    {
        if (! $this->select || (filled($this->options) && ! is_array($this->options[0]))) {
            return;
        }

        $select = explode('|', $this->select);
        $label = explode(':', $select[0])[1];
        $value = explode(':', $select[1])[1];

        $this->options = collect($this->options)->map(fn (array $item) => [$label => $item[$label], $value => $item[$value]])->toArray();

        $this->selectable = [
            'label' => $label,
            'value' => $value,
        ];
    }
}
