<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\News;

class NewsTest extends TestCase
{
    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
    }
    /**
     * Test of news index.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('news.index'));
        $response->assertOk();
    }

    /**
     * Test of news show.
     *
     * @return void
     */
    public function testShow()
    {
        $news = News::factory()->create();

        $response = $this->get(route('tasks.show', ['news' => $news]));
        $response->assertOk();
    }

    /**
     * Test of news store.
     *
     * @return void
     */
    public function testStore()
    {
        $data = News::factory()
            ->make()
            ->only(['title', 'body']);

        $response = $this->actingAs($this->admin)
            ->post(route('news.store', $data));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('news', $data);
    }

    /**
     * Test of news update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $news = News::factory()->create();
        $data = ['status' => 'published'];

        $response = $this->actingAs($this->admin)
            ->patch(route('news.update', ['news' => $news]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('news', $data);
    }
}