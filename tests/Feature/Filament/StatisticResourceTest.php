<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Statistics\Pages\ManageStatistics;
use App\Filament\Resources\Statistics\StatisticResource;
use App\Models\Statistic;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StatisticResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    #[DataProvider('editorRoles')]
    public function test_editors_can_manage_statistics_and_invalidate_homepage_cache(string $role): void
    {
        $this->signInWithRole($role);

        $this->get(StatisticResource::getUrl())->assertOk();

        $data = [
            'value' => '5 985 / 38,4%',
            'sort' => 3,
            'description_kk' => '<p>Көрсеткіш</p>',
            'description_ru' => '<p>Описание <strong>показателя</strong></p>',
            'description_en' => '<p>Statistic description</p>',
        ];

        $this->primeHomepageCache();

        Livewire::test(ManageStatistics::class)
            ->callAction('create', data: $data)
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('statistics', $data);
        $this->assertHomepageCacheWasCleared();

        $statistic = Statistic::query()->sole();
        $this->primeHomepageCache();

        Livewire::test(ManageStatistics::class)
            ->assertCanSeeTableRecords([$statistic])
            ->callTableAction('edit', $statistic, data: [
                ...$data,
                'sort' => 1,
                'description_ru' => '<p>Обновлённое описание</p>',
            ])
            ->assertHasNoActionErrors();

        $this->assertSame('<p>Обновлённое описание</p>', $statistic->fresh()->description_ru);
        $this->assertSame(1, $statistic->fresh()->sort);
        $this->assertHomepageCacheWasCleared();
        $this->primeHomepageCache();

        Livewire::test(ManageStatistics::class)
            ->callTableAction('delete', $statistic)
            ->assertHasNoActionErrors();

        $this->assertModelMissing($statistic);
        $this->assertHomepageCacheWasCleared();
    }

    public static function editorRoles(): iterable
    {
        yield 'administrator' => ['admin'];
        yield 'manager' => ['manager'];
    }

    public function test_bulk_deletion_invalidates_homepage_cache(): void
    {
        $this->signInWithRole('admin');
        $statistics = Statistic::factory()->count(2)->create();
        $this->primeHomepageCache();

        Livewire::test(ManageStatistics::class)
            ->callTableBulkAction('delete', $statistics)
            ->assertHasNoActionErrors();

        $this->assertDatabaseCount('statistics', 0);
        $this->assertHomepageCacheWasCleared();
    }

    public function test_form_requires_descriptions_and_limits_value_length(): void
    {
        $this->signInWithRole('manager');

        Livewire::test(ManageStatistics::class)
            ->callAction('create', data: [
                'value' => '',
                'description_kk' => '',
                'description_ru' => '',
                'description_en' => '',
            ])
            ->assertHasActionErrors([
                'description_kk',
                'description_ru',
                'description_en',
            ]);

        Livewire::test(ManageStatistics::class)
            ->callAction('create', data: [
                'value' => str_repeat('1', 21),
                'description_kk' => 'Көрсеткіш',
                'description_ru' => 'Описание',
                'description_en' => 'Description',
            ])
            ->assertHasActionErrors(['value' => 'max']);

        $this->assertDatabaseCount('statistics', 0);
    }

    public function test_value_is_optional_and_clearing_it_stores_null_without_losing_zero(): void
    {
        $this->signInWithRole('manager');
        $data = [
            'description_kk' => '<p>Көрсеткіш</p>',
            'description_ru' => '<p>Описание</p>',
            'description_en' => '<p>Description</p>',
        ];

        Livewire::test(ManageStatistics::class)
            ->callAction('create', data: $data)
            ->assertHasNoActionErrors();

        $statistic = Statistic::query()->sole();
        $this->assertNull($statistic->value);

        foreach (['0', '', null] as $value) {
            Livewire::test(ManageStatistics::class)
                ->callTableAction('edit', $statistic, data: [...$data, 'value' => $value])
                ->assertHasNoActionErrors();

            $this->assertSame($value === '0' ? '0' : null, $statistic->fresh()->value);
        }
    }

    public function test_order_cannot_be_negative_or_fractional(): void
    {
        $this->signInWithRole('manager');

        foreach ([-1, 1.5] as $sort) {
            Livewire::test(ManageStatistics::class)
                ->callAction('create', data: [
                    'value' => '100',
                    'sort' => $sort,
                    'description_kk' => 'Көрсеткіш',
                    'description_ru' => 'Описание',
                    'description_en' => 'Description',
                ])
                ->assertHasActionErrors(['sort']);
        }

        $this->assertDatabaseCount('statistics', 0);
    }

    #[DataProvider('restrictedRoles')]
    public function test_other_users_cannot_access_or_modify_statistics(?string $role): void
    {
        $this->signInWithRole($role);
        $statistic = Statistic::factory()->create();

        $this->get(StatisticResource::getUrl())->assertForbidden();
        $this->assertFalse(StatisticResource::canViewAny());
        $this->assertFalse(StatisticResource::canCreate());
        $this->assertFalse(StatisticResource::canEdit($statistic));
        $this->assertFalse(StatisticResource::canDelete($statistic));
        $this->assertFalse(StatisticResource::canDeleteAny());
    }

    public static function restrictedRoles(): iterable
    {
        yield 'media' => ['media'];
        yield 'alumni' => ['alumni'];
        yield 'without a role' => [null];
    }

    private function signInWithRole(?string $role): void
    {
        $user = User::factory()->create();

        if ($role !== null) {
            $user->assignRole(Role::findOrCreate($role, 'web'));
        }

        $this->actingAs($user);
    }

    private function primeHomepageCache(): void
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            Cache::put("statistics_{$locale}", ['stale']);
            Cache::put("homepage_html_{$locale}", 'stale');
        }
    }

    private function assertHomepageCacheWasCleared(): void
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            $this->assertFalse(Cache::has("statistics_{$locale}"));
            $this->assertFalse(Cache::has("homepage_html_{$locale}"));
        }
    }
}
