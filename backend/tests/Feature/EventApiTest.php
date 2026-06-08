<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event()
    {
        $response = $this->postJson('/api/events', [
            'title' => 'Laravel Meetup',
            'date' => '2026-06-30',
            'location' => 'Budapest'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('events', [
            'title' => 'Laravel Meetup'
        ]);
    }

    public function test_event_creation_requires_title_and_date()
    {
        $response = $this->postJson('/api/events', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
                'date'
            ]);
    }

    public function test_can_register_attendee()
    {
        $event = Event::factory()->create();

        $response = $this->postJson("/api/events/{$event->id}/register", [
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('attendees', [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'event_id' => $event->id
        ]);
    }

    public function test_registration_requires_name()
    {
        $event = Event::factory()->create();

        $response = $this->postJson("/api/events/{$event->id}/register", [
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_registration_requires_valid_email()
    {
        $event = Event::factory()->create();

        $response = $this->postJson("/api/events/{$event->id}/register", [
            'name' => 'John Doe',
            'email' => 'invalid-email'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_email_can_only_register_once_per_event()
    {
        $event = Event::factory()->create();

        Attendee::create([
            'event_id' => $event->id,
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response = $this->postJson("/api/events/{$event->id}/register", [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(422);
    }
}