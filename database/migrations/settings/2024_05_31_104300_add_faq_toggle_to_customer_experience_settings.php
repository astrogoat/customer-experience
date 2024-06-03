<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('customer-experience.faq_enabled', false);
    }

    public function down()
    {
        $this->migrator->delete('customer-experience.faq_enabled');
    }
};
