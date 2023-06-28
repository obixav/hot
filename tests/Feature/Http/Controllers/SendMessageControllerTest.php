<?php

namespace Tests\Feature\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Listing;
use App\Models\Message;
use Database\Factories\ListingFactory;
use App\Enums\ListingPlatform;

class SendMessageControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_valid_listing_must_be_provided()
    {
        // Given we have a random listing uuid
        $uuid = Uuid::uuid4()->toString();

        // When we call the endpoint with a random uuid
        $response = $this->postJson("/api/listings/$uuid", [
            'message' => "Hello friendly guest",
        ]);

        // Then we see a 404 response
        $response->assertStatus(404);
    }

    public function test_a_message_should_be_provided_in_the_request()
    {
        // Give we have a listing
        $listing = Listing::factory()->create([
            'platform' => ListingPlatform::AIRBNB
        ]);

        // When we call the endpoint for the listing
        $response = $this->postJson("/api/listings/{$listing->uuid->toString()}", [
            //
        ]);

        // Then we see a 422 response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'message' => 'You must provide a message body',
        ]);
    }

    public function test_a_message_can_be_sent_successfully()
    {
        // Give we have a listing
        $listing = Listing::factory()->create([
            'platform' => ListingPlatform::AIRBNB
        ]);

        // And we are spying on the service
        $service = $this->spy(MessageSendingService::class);

        // When we call the endpoint for the listing with a message
        $response = $this->postJson("/api/listings/{$listing->uuid->toString()}", [
            'message' => "Hello friendly guest",
        ]);

        // Then we see a 200 response
        $response->assertStatus(200);

        // And we created a message with the expected body
        $createdMessage = $listing->messages->first();
        $this->assertSame("Hello friendly guest", $createdMessage->body);

        // And service was called
        $service->shouldHaveReceived('send')
            ->with(\Mockery::on(fn (Message $message) => $message->is($createdMessage)))
            ->once();
    }
}
