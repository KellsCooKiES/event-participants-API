<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    /**
     * @test
     */
    public function auth_user_can_get_all_participants()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );
        $this->get('api/participants')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function auth_user_can_get_filtered_participants()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );
        $this->get('api/participants/?event=1')
            ->assertStatus(200);
    }
    /**
     * @test
     */
    public function auth_user_can_create_a_participants()
    {
        Passport::actingAs(
            factory(User::class)->create(),['participants']
        );

        $data = [
            'name' => 'someName',
            'surname' => 'someSurname',
            'email' => 'some@email.ru'
        ];
        $this->withoutExceptionHandling()->post('api/event/3/participants/', $data);

        $this->assertDatabaseHas('participants', [
            'name' => 'someName',
            'surname' => 'someSurname',
            'email' => 'some@email.ru'
        ]);

    }

    /**
     * @test
     */
    public function a_user_can_update_participant_data()
    {
        Passport::actingAs(
            factory(User::class)->create(), ['participants']
        );
        $participant = factory('App\Participant')->create();

        $this->put('api/participants/' . $participant->id . '?name=newName&surname=newSurname&email=new@email.com');

        $this->assertDatabaseHas('participants', [
            'name' => 'newName',
            'surname' => 'newSurname',
            'email' => 'new@email.com',
        ]);
    }
    /**
     * @test
     */
    public function auth_user_can_delete_a_participant()
    {
        Passport::actingAs(
            factory(User::class)->create(), ['participants']
        );

        $participant = factory('App\Participant')->create();
        $this->delete('api/participants/' . $participant->id)->assertStatus(200);
    }
}
