<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function a_user_can_register()
    {
        Artisan::call('passport:install');

        $response= $this->withHeaders([
            'Accept' => 'application\json',
        ])->post( 'api/register', [
            'name'=>'someName',
            'email' =>'some@email.com',
            'password'=>'somePass',
            'c_password'=>'somePass']);

        $response->assertJson(["success" => true]);
    }
}
