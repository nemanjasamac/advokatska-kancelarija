<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AppointmentController
 */
final class AppointmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $appointments = Appointment::factory()->count(3)->create();

        $response = $this->get(route('appointments.index'));

        $response->assertOk();
        $response->assertViewIs('appointment.index');
        $response->assertViewHas('appointments', $appointments);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('appointments.create'));

        $response->assertOk();
        $response->assertViewIs('appointment.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AppointmentController::class,
            'store',
            \App\Http\Requests\AppointmentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $date_time = Carbon::parse(fake()->dateTime());
        $type = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('appointments.store'), [
            'date_time' => $date_time->toDateTimeString(),
            'type' => $type,
            'user_id' => $user->id,
        ]);

        $appointments = Appointment::query()
            ->where('date_time', $date_time)
            ->where('type', $type)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $appointments);
        $appointment = $appointments->first();

        $response->assertRedirect(route('appointments.index'));
        $response->assertSessionHas('appointment.id', $appointment->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $appointment = Appointment::factory()->create();

        $response = $this->get(route('appointments.show', $appointment));

        $response->assertOk();
        $response->assertViewIs('appointment.show');
        $response->assertViewHas('appointment', $appointment);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $appointment = Appointment::factory()->create();

        $response = $this->get(route('appointments.edit', $appointment));

        $response->assertOk();
        $response->assertViewIs('appointment.edit');
        $response->assertViewHas('appointment', $appointment);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AppointmentController::class,
            'update',
            \App\Http\Requests\AppointmentUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $appointment = Appointment::factory()->create();
        $date_time = Carbon::parse(fake()->dateTime());
        $type = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('appointments.update', $appointment), [
            'date_time' => $date_time->toDateTimeString(),
            'type' => $type,
            'user_id' => $user->id,
        ]);

        $appointment->refresh();

        $response->assertRedirect(route('appointments.index'));
        $response->assertSessionHas('appointment.id', $appointment->id);

        $this->assertEquals($date_time, $appointment->date_time);
        $this->assertEquals($type, $appointment->type);
        $this->assertEquals($user->id, $appointment->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $appointment = Appointment::factory()->create();

        $response = $this->delete(route('appointments.destroy', $appointment));

        $response->assertRedirect(route('appointments.index'));

        $this->assertModelMissing($appointment);
    }
}
