<?php

namespace Tests\Feature;

use App\Permission;
use App\Record;
use App\RecordIdentity;
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

    private function other_record_type()
    {
        $identity = RecordIdentity::where('name', 'Other')->first();

        $recordType = $identity->types()->first();

        return $recordType;
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

        $response = $this->actingAs($user)->postJson("/api/records/participants", $input);
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
            'record_type_id' => $this->other_record_type()->id,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $slug = $this->other_record_type()->slug;
        $response = $this->actingAs($user)->postJson("/api/records/$slug", $input);
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
            'record_type_id' => $this->other_record_type()->id,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $slug = $this->other_record_type()->slug;
        $response = $this->actingAs($user)->postJson("/api/records/$slug", $input);
        $response->assertStatus(422);
    }

    /**
     * @test storing an existing record.
     * Records of the same type and field values should be deduped.
     * When the user creates an existing record but in a different team,
     * the record should be added to the team.
     *
     *
     * @return void
     */

    public function store_existing_record()
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

        // Create same record, again.
        $response = $this->actingAs($user)->postJson('/api/records/participants', $input);
        // Should be 200 since, record is not recreated on the backend.
        $response->assertStatus(200);

        $query = Record::where('field_1_value', $record['field_1_value'])
            ->where('field_2_value', $record['field_2_value'])
            ->where('field_3_value', $record['field_3_value'])
            ->where('record_type_id', $record['record_type_id']);

        $this->assertEquals(1, $query->count());
        $this->assertEquals(1, $query->first()->teams->count());

        // Create same record but in different team.
        $team = factory(Team::class)->create();
        $input['team_id'] = $team->id;
        $response = $this->actingAs($user)->postJson('/api/records/participants', $input);
        $response->assertStatus(200);

        $this->assertEquals(1, $query->count());
        $this->assertEquals(2, $query->first()->teams->count());
    }

    /**
     * @test storing an existing record of other identity.
     *
     *
     * @return void
     */

    public function store_existing_other_record()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_authorized_user();

        $record = [
            'field_1_value' => 'Other',
            'field_2_value' => null,
            'field_3_value' => null,
            'record_type_id' => $this->other_record_type()->id,
        ];

        $input = $record;
        $input['team_id'] = 1;

        $slug = $this->other_record_type()->slug;
        $response = $this->actingAs($user)->postJson("/api/records/$slug", $input);
        $response->assertStatus(201);

        // Create same record, again.
        $response = $this->actingAs($user)->postJson("/api/records/$slug", $input);
        // Should be 200 since, record is not recreated on the backend.
        $response->assertStatus(200);

        $query = Record::where('field_1_value', $record['field_1_value'])
            ->where('field_2_value', $record['field_2_value'])
            ->where('field_3_value', $record['field_3_value'])
            ->where('record_type_id', $record['record_type_id']);

        $this->assertEquals(1, $query->count());
        $this->assertEquals(1, $query->first()->teams->count());

        // Create same record but in different team.
        $team = factory(Team::class)->create();
        $input['team_id'] = $team->id;
        $response = $this->actingAs($user)->postJson("/api/records/$slug", $input);
        $response->assertStatus(200);

        $this->assertEquals(1, $query->count());
        $this->assertEquals(2, $query->first()->teams->count());
    }
}
