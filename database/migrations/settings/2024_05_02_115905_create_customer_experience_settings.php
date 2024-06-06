<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('customer-experience.enabled', false);
        $this->migrator->add('customer-experience.call_enabled', false);
        $this->migrator->add('customer-experience.chat_enabled', false);
        $this->migrator->add('customer-experience.faq_enabled', false);
    }

    public function down()
    {
        $this->migrator->delete('customer-experience.enabled');
        $this->migrator->delete('customer-experience.call_enabled');
        $this->migrator->delete('customer-experience.chat_enabled');
        $this->migrator->delete('customer-experience.faq_enabled');
    }
};
