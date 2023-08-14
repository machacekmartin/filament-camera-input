<?php

namespace Machacekmartin\FilamentCameraInput;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Support\Concerns\HasColor;
use Illuminate\Contracts\Support\Htmlable;

class FilamentCameraInput extends Component
{
    use HasColor;

    protected string | Closure $content = '';

    protected string $view = 'filament-camera-input::filament-camera-input';

    final public function __construct(string | Htmlable | Closure $label)
    {
        $this->label($label);
    }

    public static function make(string | Htmlable | Closure $label): static
    {
        return app(static::class, ['label' => $label]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public function content(string | Closure $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->evaluate($this->content);
    }
}
