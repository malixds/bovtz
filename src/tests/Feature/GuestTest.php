<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_be_created()
{
    $data = [
        'name' => 'John',
        'email' => 'john.doe@example.com',
        'phone' => '+79991234567',
        'country' => 'Russia',
    ];
    $response = $this->postJson("api/guests", $data);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'name',
        'email',
        'phone',
        'country',
    ]);
    $this->assertDatabaseHas('guests', $data);
}

    public function test_guest_can_be_retrieved()
{
    $guest = Guest::factory()->create();
    $response = $this->getJson("/api/guests/{$guest->id}");
    $response->assertStatus(200)
        ->assertJson([
            'name' => $guest->name,
            'email' => $guest->email,
            'phone' => $guest->phone,
            'country' => $guest->country,
        ]);
}

    /**
     * Тест обновления информации о госте
     */
    public function test_guest_can_be_updated()
{
    $guest = Guest::factory()->create();
    $updateData = [
        'name' => 'Jane',
        'email' => 'jane.doe@example.com',
        'phone' => '+79991234568',
        'country' => 'Russia',
    ];
    $response = $this->putJson("/api/guests/{$guest->id}", $updateData);
    $response->assertStatus(200)
        ->assertJson($updateData);
    $this->assertDatabaseHas('guests', $updateData);
}
    /**
     * Тест удаления гостя
     */
    public function test_guest_can_be_deleted()
{
    $guest = Guest::factory()->create();
    $response = $this->deleteJson("/api/guests/{$guest->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('guests', ['id' => $guest->id]);
}
}
