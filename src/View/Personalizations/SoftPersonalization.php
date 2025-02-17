<?php

namespace TallStackUi\View\Personalizations;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SoftPersonalization
{
    public function __construct(protected string $key)
    {
        //
    }

    public function get(): string
    {
        return 'tallstack-ui::personalizations.'.$this->key;
    }
}
