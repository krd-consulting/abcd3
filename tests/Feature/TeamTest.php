<?php

namespace Tests\Feature;

use App\Permission;
use App\Role;
use App\Scope;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function user_with_write_teams_permission_can_create_a_team()
    {
        $this->withoutExceptionHandling();

        $permission = Permission::create(config('auth.permissions.write-teams'));
        $scope = Scope::create(config('auth.scopes.universal'));
        $role = Role::create([
            'name' => 'write teams',
            'guard_name' => 'web',
            'scope_id' => $scope->id
        ])->givePermissionTo($permission);

        $user = factory(User::class)->create()->assignRole($role);

        $attributes = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence
        ];

        $this->actingAs($user)->post('/api/teams', $attributes);

        $this->assertDatabaseHas('teams', $attributes);
    }
}
