<?php

namespace Tests\Feature;

use App\Models\CEO;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CEOTest extends TestCase
{
    use RefreshDatabase;

    public function testCEOCreatedSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => 'john1234'
        ]);
        $this->actingAs($user);

        $ceo = [
            'name' => 'Susan Scikit',
            'company_name' => 'YouTube',
            'year' => 2014,
            'company_headquarters' => 'California',
            'what_company_does' => 'Video-Sharing platform'
        ];

        $this->postJson('api/ceo', $ceo)
            ->assertStatus(201)
            ->assertJson([
                'ceo' => [
                    'name' => 'Susan Scikit',
                    'company_name' => 'YouTube',
                    'year' => 2014,
                    'company_headquarters' => 'California',
                    'what_company_does' => 'Video-Sharing platform'
                ],
                'message' => 'Created successfully'
            ]);
    }

    public function testCEOListedSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => 'john1234'
        ]);
        $this->actingAs($user);

        CEO::factory()->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform",
        ]);

        $this->getJson('api/ceo')
            ->assertStatus(200)
            ->assertJson([
                "ceos" => [
                    [
                        "id" => 1,
                        "name" => "Susan Wojcicki",
                        "company_name" => "YouTube",
                        "year" => "2014",
                        "company_headquarters" => "San Bruno, California",
                        "what_company_does" => "Video-sharing platform"
                    ],
                ],
                'message' => 'Retrieved successfully'
            ]);
    }

    public function testRetrievedCEOSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => 'john1234'
        ]);
        $this->actingAs($user);

        $ceo = CEO::factory()->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $this->getJson('api/ceo/'. $ceo->id)
            ->assertStatus(200)
            ->assertJson([
                "ceo" => [
                    "name" => "Susan Wojcicki",
                    "company_name" => "YouTube",
                    "year" => "2014",
                    "company_headquarters" => "San Bruno, California",
                    "what_company_does" => "Video-sharing platform"
                ],
                "message" => "Retrieved successfully"
            ]);
    }

    public function testCEOUpdatedSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => 'john1234'
        ]);
        $this->actingAs($user);

        $ceo = CEO::factory()->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $payload = [
            "name" => "Demo User",
            "company_name" => "Sample Company",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ];

        $this->putJson('api/ceo/'. $ceo->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                "ceo" => [
                    "name" => "Demo User",
                    "company_name" => "Sample Company",
                    "year" => "2014",
                    "company_headquarters" => "San Bruno, California",
                    "what_company_does" => "Video-sharing platform"
                ],
                "message" => "Updated successfully"
            ]);
    }

    public function testDeleteCEO()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => 'john1234'
        ]);
        $this->actingAs($user);

        $ceo = CEO::factory()->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $this->deleteJson('api/ceo/'. $ceo->id)
            ->assertStatus(204);
    }
}
