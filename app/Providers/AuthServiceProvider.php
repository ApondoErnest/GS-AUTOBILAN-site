<?php

namespace App\Providers;

use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DocumentReadiness;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\Testimonial;
use App\Models\User;
use App\Policies\AgencyPolicy;
use App\Policies\BookingPolicy;
use App\Policies\ContactMessagePolicy;
use App\Policies\ContentPolicy;
use App\Policies\DocumentReadinessPolicy;
use App\Policies\RolePolicy;
use App\Policies\ServicePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TariffPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Agency::class => AgencyPolicy::class,
        Article::class => ContentPolicy::class,
        ArticleCategory::class => ContentPolicy::class,
        Booking::class => BookingPolicy::class,
        ContactMessage::class => ContactMessagePolicy::class,
        DocumentReadiness::class => DocumentReadinessPolicy::class,
        Faq::class => ContentPolicy::class,
        GalleryItem::class => ContentPolicy::class,
        Role::class => RolePolicy::class,
        Service::class => ServicePolicy::class,
        Setting::class => SettingPolicy::class,
        Tariff::class => TariffPolicy::class,
        Testimonial::class => ContentPolicy::class,
        User::class => UserPolicy::class,
    ];
}
