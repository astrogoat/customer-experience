<?php

namespace Astrogoat\CustomerExperience\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Media\HasMedia;
use Helix\Lego\Media\Mediable;
use Helix\Lego\Media\MediaCollection;
use Helix\Lego\Models\Contracts\Metafieldable;
use Helix\Lego\Models\Model as LegoModel;
use Helix\Lego\Models\Traits\HasMetafields;

class Faq extends LegoModel implements Mediable, Metafieldable
{
    use HasMetafields;
    use HasMedia;
    protected $table = 'customer_experience_faqs';

    public static function icon(): string
    {
        return Icon::DOCUMENT_TEXT;
    }

    public function getCreateRoute(array $parameters = []): string
    {
        return route('lego.customer-experience.faqs.create', $parameters);
    }

    public function getEditRoute(): string
    {
        return route('lego.customer-experience.faqs.edit', $this);
    }

    public function mediaCollections(): array
    {
        return [
            MediaCollection::name('Icon')->maxFiles(1),
        ];
    }
}
