<?php

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student issue and return workflow works end to end', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'isAdmin' => false,
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'isAdmin' => true,
    ]);

    $book = Book::create([
        'title' => 'Clean Code',
        'author' => 'Robert C. Martin',
        'isbn' => '9780132350884',
        'copies_total' => 1,
        'copies_available' => 1,
        'is_active' => true,
    ]);

    $this->actingAs($student)
        ->post(route('borrow.request', $book))
        ->assertRedirect();

    $issue = BookIssue::first();

    expect($issue)
        ->status->toBe('pending_issue')
        ->request_type->toBe('issue');

    $this->actingAs($admin)
        ->post(route('admin.requests.accept', $issue))
        ->assertRedirect();

    $issue->refresh();
    $book->refresh();

    expect($issue->status)->toBe('issued')
        ->and($book->copies_available)->toBe(0);

    $this->actingAs($student)
        ->post(route('return.request', $issue))
        ->assertRedirect();

    $issue->refresh();

    expect($issue)
        ->status->toBe('pending_return')
        ->request_type->toBe('return');

    $this->actingAs($admin)
        ->post(route('admin.returns.receive', $issue))
        ->assertRedirect();

    $issue->refresh();
    $book->refresh();

    expect($issue->status)->toBe('returned')
        ->and($book->copies_available)->toBe(1);
});
