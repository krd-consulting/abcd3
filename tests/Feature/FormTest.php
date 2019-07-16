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

class FormTest extends TestCase
{
    use WithFaker;

    private function create_authorized_user()
    {
        $scope = Scope::where('name', config('auth.scopes.universal.name'))->first();

        $role = Role::create([
            'name' => 'write forms',
            'guard_name' => 'web',
            'scope_id' => $scope->id
        ])->givePermissionTo(config('auth.permissions.write-forms.name'));

        $user = factory(User::class)->create()->assignRole($role);
        
        $record = factory(Record::class)->create();
        $user->records()->save($record);

        $team = factory(Team::class)->create();
        $team->records()->attach($record);

        return $user;
    }

    /** @test */
    public function authorized_user_can_store_a_form_with_matrix()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_authorized_user();
        $scope = $user->roles()->first()->scope;
        $team = $user->teams()->first();

        $name = $this->faker->word;
        $description = $this->faker->sentence;

        $fields = [
            [
                'type' => 'MatrixField',
                'label' => 'Test Matrix',
                'description' => 'Test Matrix Field',
                'target_type_id' => NULL,
                'target_id' => NULL,
                'questions' => [
                    [
                        'text' => 'question 1'
                    ],
                    [
                        'text' => 'question 2'
                    ]
                ],
                'choices' => [
                    [
                        'text' => 'choice 1',
                        'value ' => 1
                    ],
                    [
                        'text' => 'choice 2',
                        'value ' => 2
                    ],
                    [
                        'text' => 'choice 3',
                        'value ' => 3
                    ]
                ]
            ]
        ];

        $form = [
            'name' => $name,
            'description' => $description,
            'type' => 'static',
            'target_type_id' => 3,
            'target_id' => '',
            'scope_id' => $scope->id,
            'team_id' => $team->id,
            'fields' => $fields
        ];

        $response = $this->actingAs($user)->post('/api/forms', $form);

        $response->assertStatus(201);

        $form = [
            'name' => $name,
            'description' => $description,
            'type' => 'static',
            'target_type_id' => 3,
            'target_id' => NULL,
            'scope_id' => $scope->id
        ];

        $this->assertDatabaseHas('forms', $form);
        $this->assertDatabaseHas('form_team', [
            'form_id' => $response->decodeResponseJson()['id'],
            'team_id' => $team->id,
        ]);

        $fields = [
            [
                'type' => 'MatrixField',
                'label' => 'Test Matrix',
                'description' => 'Test Matrix Field',
                'target_type_id' => NULL,
                'target_id' => NULL,
                'form_id' => $response->decodeResponseJson()['id']
            ]
        ];

        foreach($fields as $field) {
            $this->assertDatabaseHas('form_fields', $field);
        }
    }

    /** @test */
    public function authorized_user_can_store_a_form_with_text()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_authorized_user();
        $scope = $user->roles()->first()->scope;
        $team = $user->teams()->first();

        $name = $this->faker->word;
        $description = $this->faker->sentence;

        $fields = [
            [
                'type' => 'TextField',
                'label' => 'Test Text',
                'description' => 'Test Text Field',
                'target_type_id' => NULL,
                'target_id' => NULL,
            ]
        ];

        $form = [
            'name' => $name,
            'description' => $description,
            'type' => 'static',
            'target_type_id' => 3,
            'target_id' => '',
            'scope_id' => $scope->id,
            'team_id' => $team->id,
            'fields' => $fields
        ];

        $response = $this->actingAs($user)->post('/api/forms', $form);

        $response->assertStatus(201);

        $form = [
            'name' => $name,
            'description' => $description,
            'type' => 'static',
            'target_type_id' => 3,
            'target_id' => NULL,
            'scope_id' => $scope->id
        ];

        $this->assertDatabaseHas('forms', $form);
        $this->assertDatabaseHas('form_team', [
            'form_id' => $response->decodeResponseJson()['id'],
            'team_id' => $team->id,
        ]);

        $fields = [
            [
                'type' => 'TextField',
                'label' => 'Test Text',
                'description' => 'Test Text Field',
                'target_type_id' => NULL,
                'target_id' => NULL,
                'form_id' => $response->decodeResponseJson()['id']
            ]
        ];

        foreach($fields as $field) {
            $this->assertDatabaseHas('form_fields', $field);
        }
    }
}
