<?php

namespace Spatie\Multitenancy\Tests\Feature\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tests\TestCase;

class TenantTest extends TestCase
{
    private Tenant $tenant;

    public function setUp(): void
    {
        parent::setUp();

        $this->tenant = factory(Tenant::class)->create(['database' => 'laravel_mt_tenant_1']);
    }

    /** @test */
    public function when_making_a_tenant_current_it_will_set_the_right_database_name_on_the_tenant_connection()
    {
        $this->assertNull(DB::connection('tenant')->getDatabaseName());

        $this->tenant->makeCurrent();

        $this->assertEquals('laravel_mt_tenant_1', DB::connection('tenant')->getDatabaseName());
    }

    /** @test */
    public function it_can_get_the_current_tenant()
    {
        $this->assertNull(Tenant::current());

        $this->tenant->makeCurrent();

        $this->assertEquals($this->tenant->id, Tenant::current()->id);
    }
}