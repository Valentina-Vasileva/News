<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\News;
use Laravel\Passport\Passport;

class NewsTest extends TestCase
{
    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }
    /**
     * Test of news index.
     *
     * @return void
     */
    public function testIndex()
    {
        Passport::actingAs($this->user);
        $response = $this->get(route('news.index'));
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

        Passport::actingAs($this->user);
        $response = $this->get(route('news.show', ['news' => $news]));
        $response->assertOk();
    }

    /**
     * Test of news store.
     *
     * @return void
     */
    public function testStore()
    {
        $data = News::factory()->make()->toArray();

        Passport::actingAs($this->admin);
        $response = $this->post(route('news.store', $data));

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

        Passport::actingAs($this->admin);
        $response = $this->patch(route('news.update', ['news' => $news]), $data);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('news', $data);
    }
}
