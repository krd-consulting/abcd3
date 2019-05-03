<?php

namespace Tests\Feature;

use App\Permission;
use App\Record;
use App\RecordType;
use App\Role;
use App\Scope;
use App\Team;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function user_with_write_teams_permission_can_create_a_team()
    {
        $this->withoutExceptionHandling();

        $scope = Scope::where('name', config('auth.scopes.universal.name'))->first();

        $role = Role::create([
            'name' => 'write teams',
            'guard_name' => 'web',
            'scope_id' => $scope->id
        ])->givePermissionTo(config('auth.permissions.write-teams.name'));

        $user = factory(User::class)->create()->assignRole($role);

        $attributes = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence
        ];

        $response = $this->actingAs($user)->post('/api/teams', $attributes);

        $response->assertStatus(201);

        $this->assertDatabaseHas('teams', $attributes);
    }

    /** @test */
    public function user_without_write_teams_permission_cant_create_a_team()
    {
        $user = factory(User::class)->create();

        $attributes = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence
        ];

        $response = $this->actingAs($user)->post('/api/teams', $attributes);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('teams', $attributes);
    }

    /** @test */
    public function user_with_write_teams_permission_and_owns_team_can_delete_team()
    {
        $this->withoutExceptionHandling();

        $scope = Scope::where('name', config('auth.scopes.universal.name'))->first();

        $role = Role::create([
            'name' => 'write teams',
            'guard_name' => 'web',
            'scope_id' => $scope->id
        ])->givePermissionTo(config('auth.permissions.write-teams.name'));;

        $record = factory(Record::class)->create();

        $user = factory(User::class)->create()->assignRole($role);

        $user->records()->save($record);

        $team = factory(Team::class)->create();

        $team->records()->attach($user->records->pluck('id'));

        $response = $this->actingAs($user)->delete('/api/teams/' . $team->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('teams', $team->toArray());
    }
}
