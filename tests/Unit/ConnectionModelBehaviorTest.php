<?php

use App\Models\Connection;
use App\Models\User;

test('connection belongs to requester and addressee users', function () {
    $requester = User::factory()->create();
    $addressee = User::factory()->create();

    $connection = Connection::create([
        'requester_id' => $requester->id,
        'addressee_id' => $addressee->id,
    ]);

    $this->assertTrue($connection->requester->is($requester));
    $this->assertTrue($connection->addressee->is($addressee));
});

test('connection status helper returns the stored status or null when missing', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();

    Connection::create([
        'requester_id' => $firstUser->id,
        'addressee_id' => $secondUser->id,
        'status' => 'accepted',
    ]);

    expect(Connection::getConnectionStatus($firstUser->id, $secondUser->id))->toBe('accepted');
    expect(Connection::getConnectionStatus($secondUser->id, $firstUser->id))->toBe('accepted');
    expect(Connection::getConnectionStatus($firstUser->id, User::factory()->create()->id))->toBeNull();
});