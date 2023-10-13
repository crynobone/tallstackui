<?php

namespace TallStackUi\View\Components\Avatar;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use TallStackUi\Contracts\Customizable;
use TallStackUi\Facades\TallStackUi;

class Index extends Component implements Customizable
{
    public function __construct(
        public ?string $text = null,
        public ?string $color = 'primary',
        public ?string $sm = null,
        public ?string $md = null,
        public ?string $lg = null,
        public bool $square = false,
        public bool $modelable = false,
        public ?string $size = null,
    ) {
        $this->size = $this->sm ? 'sm' : ($this->lg ? 'lg' : 'md');
    }

    public function customization(): array
    {
        return [
            ...$this->tallStackUiClasses(),
        ];
    }

    public function render(): View
    {
        return view('tallstack-ui::components.avatar');
    }

    public function tallStackUiClasses(): array
    {
        return Arr::dot([
            'wrapper' => Arr::toCssClasses([
                'inline-flex shrink-0 items-center justify-center overflow-hidden text-xl',
                'w-8 h-8 text-xs' => $this->size === 'sm',
                'w-12 h-12 text-xl' => $this->size === 'md',
                'w-14 h-14 text-2xl' => $this->size === 'lg',
                'rounded-full' => ! $this->square,
                'border-2' => ! $this->modelable,
            ]),
            'content' => [
                'image' => Arr::toCssClasses([
                    'shrink-0 object-cover object-center text-xl',
                    'w-8 h-8 text-sm' => $this->size === 'sm',
                    'w-12 h-12 text-xl' => $this->size === 'md',
                    'w-14 h-14 text-2xl' => $this->size === 'lg',
                    'rounded-full' => ! $this->square,
                ]),
                'text' => Arr::toCssClasses([
                    'font-semibold',
                    'text-white' => $this->color !== 'white',
                    'text-neutral' => $this->color === 'white' || $this->color === 'black',
                ]),
            ],
            /* Internal Usage Only */
            'internal' => [
                'wrapper.color' => Arr::toCssClasses([
                    TallStackUi::colors()
                        ->set('bg', $this->color, $this->color === 'black' ? null : 500)
                        ->merge('border', $this->color, $this->color === 'black' ? null : 500)
                        ->get() => ! $this->modelable,
                ]),
            ],
        ]);
    }
}
