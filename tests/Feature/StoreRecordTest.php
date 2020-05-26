<?php

namespace Tests\Feature;

use App\Permission;
use App\Record;
use App\RecordType;
use App\Role;
use App\Scope;
use App\Team;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreRecordTest extends TestCase
{
    private function create_authorized_user()
    {
        $scope = Scope::where('name', config('auth.scopes.universal.name'))->first();

        $role = Role::create([
            'name' => 'write records',
            'guard_name' => 'web',
            'scope_id' => $scope->id
        ])->givePermissionTo(config('auth.permissions.write-records.name'));

        $user = factory(User::class)->create()->assignRole($role);

        $record = factory(Record::class)->create();
        $user->records()->save($record);

        $team = factory(Team::class)->create();
        $team->records()->attach($record);

        return $user;
    }

    /**
     * @test storing a record with client identity.
     *
     * @return void
     */

    public function store_client_record()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_authorized_user();

        $record = [
            'field_1_value' => 'Jake',
            'field_2_value' => 'Peralta',
            'field_3_value' => '1979-05-21',
            'record_type_id' => 1,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $response = $this->actingAs($user)->postJson('/api/records/participants', $input);
        $response->assertStatus(201);

        $this->assertDatabaseHas('records', $record);
    }

    /**
     * @test storing a record with client identity
     * but missing field_1_value.
     *
     * @return void
     */

    public function store_client_record_missing_field_1_value()
    {
        $user = $this->create_authorized_user();

        $record = [
            'field_1_value' => '',
            'field_2_value' => 'Peralta',
            'field_3_value' => '1979-05-21',
            'record_type_id' => 1,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $response = $this->actingAs($user)->postJson('/api/records/participants', $input);
        echo 'store_client_record_missing_field_1_value:';
        var_dump($response->json());
        $response->assertStatus(422);
    }

    /**
     * @test storing a record with other identity.
     *
     * @return void
     */

    public function store_other_record()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_authorized_user();

        $record = [
            'field_1_value' => 'Rice',
            'record_type_id' => 4,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $response = $this->actingAs($user)->postJson('/api/records/meals', $input);
        $response->assertStatus(201);

        $this->assertDatabaseHas('records', $record);
    }

    /**
     * @test storing a record with other identity
     * but missing field_1_value.
     *
     * @return void
     */

    public function store_other_record_missing_field_1_value()
    {
        $user = $this->create_authorized_user();

        $record = [
            'field_1_value' => '',
            'record_type_id' => 4,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $response = $this->actingAs($user)->postJson('/api/records/meals', $input);
        $response->assertStatus(422);
    }
}
