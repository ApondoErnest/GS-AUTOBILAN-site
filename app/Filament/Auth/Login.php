<?php

namespace App\Filament\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Component;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected string $view = 'filament.auth.login';

    protected array $extraBodyAttributes = [
        'class' => 'gs-admin-auth-body',
    ];

    public function getTitle(): string|Htmlable
    {
        return __('admin_login.title');
    }

    public function getHeading(): string|Htmlable|null
    {
        return null;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return null;
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->label(__('admin_login.form.email.label'))
            ->placeholder(__('admin_login.form.email.placeholder'))
            ->prefixIcon('heroicon-m-envelope');
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label(__('admin_login.form.password.label'))
            ->placeholder(__('admin_login.form.password.placeholder'))
            ->prefixIcon('heroicon-m-key');
    }

    protected function getRememberFormComponent(): Checkbox
    {
        return parent::getRememberFormComponent()
            ->label(__('admin_login.form.remember'));
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label(__('admin_login.form.submit'))
            ->icon('heroicon-m-arrow-right-end-on-rectangle');
    }
}
