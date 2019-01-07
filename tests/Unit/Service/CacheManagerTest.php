<?php

namespace Tests\Unit\Service;

use App\Models\Menu;
use App\Models\Submenu;
use App\Models\User;
use App\Services\CacheManager;
use App\Services\MenuService;
use iEducar\Support\Repositories\MenuRepository;
use iEducar\Support\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheManagerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Cache::swap(new CacheManager(app()));
    }

    public function testFlushedTagsShouldReturnsEmpty()
    {
        Cache::tags(['testTag'])->put('test-key', 'Test value', 10);

        Cache::invalidateByTags(['testTag']);

        $this->assertFalse(Cache::has('test-key'));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDriverNotSupportTagsDoesNotThrowExxception()
    {
        Cache::store('file')->put('test-key', 'Test value', 10);
        Cache::invalidateByTags(['testTag']);
    }

}
