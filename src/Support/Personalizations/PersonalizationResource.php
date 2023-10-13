<?php

namespace TallStackUi\Support\Personalizations;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View as FacadeView;
use Illuminate\View\View;
use InvalidArgumentException;
use RuntimeException;
use TallStackUi\Contracts\Personalizable as PersonalizableClass;
use TallStackUi\Support\Personalization;

/** @property-read Personalization $and */
abstract class PersonalizationResource
{
    public function __construct(
        private ?string $view = null,
        private ?Collection $parts = new Collection(),
        private readonly ?Personalization $personalization = null,
    ) {
        // The [ignoreValidations => true] used here is a way to ignore possible validations
        // that may exist in the component class. This is necessary because the component
        // class is not instantiated with the parameters that were passed to it.
        $this->view = app($this->component(), ['ignoreValidations' => true])
            ->render()
            ->name();
    }

    public function __get(string $name): Personalization
    {
        if ($name === 'and') {
            return $this->and();
        }

        throw new RuntimeException("Property [{$name}] does not exist.");
    }

    public function and(): Personalization
    {
        return $this->personalization;
    }

    public function block(string|array $name, string|Closure|PersonalizableClass $code = null): static
    {
        if (is_string($name) && ! $code) {
            throw new InvalidArgumentException('The second argument must be set when the first is a string');
        }

        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->factory($key, $value);
            }
        } else {
            $this->factory($name, $code);
        }

        return $this;
    }

    public function get(string $block): ?string
    {
        return data_get($this->parts, $block);
    }

    public function toArray(): array
    {
        return $this->parts->toArray();
    }

    protected function blocks(): array
    {
        return array_keys(app($this->component(), ['ignoreValidations' => true])->tallStackUiClasses());
    }

    abstract protected function component(): string;

    protected function set(string $block, string $content): void
    {
        $this->parts[$block] = $content;
    }

    private function factory(string $block, string|Closure|PersonalizableClass $code): void
    {
        if (! in_array($block, array_values($blocks = $this->blocks()))) {
            $component = str_replace('tallstack-ui::personalizations.', '', $this->view);

            throw new InvalidArgumentException("Component [$component] does not have the block [$block] to be personalized. Alloweds: ".implode(', ', $blocks));
        }

        FacadeView::composer($this->view, fn (View $view) => $this->set($block, is_callable($code) ? $code($view->getData()) : $code));
    }
}
