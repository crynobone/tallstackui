<?php

namespace TallStackUi\View\Components\Select;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use TallStackUi\Contracts\Customizable;
use TallStackUi\View\Components\Select\Traits\InteractsWithSelectOptions;

class Select extends Component implements Customizable
{
    use InteractsWithSelectOptions;

    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $hint = null,
        public Collection|array $options = [],
        public ?string $select = null,
        public ?array $selectable = [],
    ) {
        $this->options();
    }

    public function render(): View
    {
        return view('tallstack-ui::components.select.select');
    }

    public function customization(): array
    {
        return [
            ...$this->tallStackUiClasses(),
        ];
    }

    public function tallStackUiClasses(): array
    {
        return [
            'base' => Arr::toCssClasses([
                'block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 sm:text-sm',
                'ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-primary-600 sm:leading-6',
            ]),
            'error' => 'text-red-600 ring-1 ring-inset ring-red-300 placeholder:text-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500',
        ];
    }
}
