<?php

namespace Machacekmartin\FilamentCameraInput;

use Closure;
use Filament\Forms\Components\Field;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class FilamentCameraInput extends Field
{
    use WithFileUploads;

    protected string $view = 'filament-camera-input::filament-camera-input';

    protected string | Closure | null $directory = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->beforeStateDehydrated(function (TemporaryUploadedFile $state): void {
            $state->storeAs('public/' . $this->getDirectory() . '/camera-inputs', $state->getFilename());
        });

        $this->dehydrateStateUsing(function (TemporaryUploadedFile $state): string {
            return 'camera-inputs/' . $this->getDirectory() . '/' . $state->getFilename();
        });
    }

    public function directory(string | Closure | null $directory): static
    {
        $this->directory = $directory;

        return $this;
    }

    public function getDirectory(): ?string
    {
        return $this->evaluate($this->directory);
    }
}
