<?php

namespace Astrogoat\CustomerExperience\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Media\HasMedia;
use Helix\Lego\Media\Mediable;
use Helix\Lego\Media\MediaCollection;
use Helix\Lego\Models\Contracts\Metafieldable;
use Helix\Lego\Models\Contracts\Searchable;
use Helix\Lego\Models\Model as LegoModel;
use Helix\Lego\Models\Traits\HasMetafields;

class Faq extends LegoModel implements Searchable, Mediable, Metafieldable
{
    use HasMetafields;
    use HasMedia;
    protected $table = 'customer_experience_faqs';

    public static function icon(): string
    {
        return Icon::DOCUMENT_TEXT;
    }

    public static function searchableFields(): array
    {
        return [
            'faq_question' => 'Question',
            'faq_answer' => 'Answer',
        ];
    }

    public function searchableName(): string
    {
        return $this->faq_question;
    }

    public function searchableDescription(): string
    {
        return $this->faq_answer;
    }

    public function searchableRoute(): string
    {
        return route('lego.customer-experience.faqs.edit', $this);
    }

    public function scopeGlobalSearch($query, $value)
    {
        // TODO: Implement scopeGlobalSearch() method.
    }

    public static function searchableIndexRoute(): string
    {
        return route('lego.customer-experience.faqs.index');
    }

    public static function searchableIcon(): string
    {
        return static::icon();
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
