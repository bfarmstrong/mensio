<?php

use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(UserService::class);
    }

    public function testGetUsers()
    {
        $response = $this->service->all();
        $this->assertEquals(get_class($response), 'Illuminate\Database\Eloquent\Collection');
    }

    public function testGetUser()
    {
        $user = factory(App\Models\User::class)->create();
        $response = $this->service->find($user->id);

        $this->assertTrue(is_object($response));
        $this->assertEquals($user->name, $response->name);
    }

    public function testCreateUser()
    {
        $role = factory(App\Models\Role::class)->create();
        $user = factory(App\Models\User::class)->create();
        $response = $this->service->create($user, 'password');

        $this->assertTrue(is_object($response));
        $this->assertEquals($user->name, $response->name);
    }

    public function testUpdateUser()
    {
        $user = factory(App\Models\User::class)->create();

        $response = $this->service->update($user->id, [
            'email' => $user->email,
            'marketing' => 1,
            'name' => 'jim',
            'phone' => '666',
            'role' => 'member',
            'terms_and_cond' => 1,
        ]);

        $this->assertDatabaseHas('users', ['name' => 'jim']);
    }

    public function testAssignRole()
    {
        $role = factory(App\Models\Role::class)->create();
        $user = factory(App\Models\User::class)->create();
        $this->service->assignRole('member', $user->id);
        $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
        $this->assertEquals($user->roles->first()->label, 'Member');
    }

    public function testHasRole()
    {
        $role = factory(App\Models\Role::class)->create();
        $user = factory(App\Models\User::class)->create();
        $this->service->assignRole('member', $user->id);
        $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
        $this->assertTrue($user->hasRole('member'));
    }

    public function testUnassignRole()
    {
        $role = factory(App\Models\Role::class)->create();
        $user = factory(App\Models\User::class)->create();
        $this->service->assignRole('member', $user->id);
        $this->service->unassignRole('member', $user->id);
        $this->assertEquals(0, count($user->roles));
    }

    public function testUnassignAllRole()
    {
        $role = factory(App\Models\Role::class)->create();
        $user = factory(App\Models\User::class)->create();
        $this->service->assignRole('member', $user->id);
        $this->service->unassignAllRoles($user->id);
        $this->assertEquals(0, count($user->roles));
    }
}
