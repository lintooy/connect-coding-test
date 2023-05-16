<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Job;
use Tests\TestCase;

class JobTest extends TestCase
{
    private $admin;
    private const HEADERS = [
        'Accept' => 'aplication/json',
        'Content-Type' => 'aplication/json'
    ];

    /**
     * Test setup.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->create();

        Job::factory()->count(25)->open()->create();
        Job::factory()->count(30)->closed()->create();
    }

    /**
     * Display all open jobs.
     * 
     * @param array $params
     * @param array $expected
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testIndexProvider()
     */
    public function test_index(array $params, array $expected)
    {
        $response = $this->get(route('job.index', $params), self::HEADERS);

        $response
            ->assertOk()
            ->assertJson($expected);
    }

    /**
     * Show open job details.
     *
     */
    public function test_show()
    {
        $job = Job::factory()->open()->create();
        $response = $this->get(route('job.show', ['job' => $job]), self::HEADERS);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                ],
            ]);
    }

    /**
     * Returns a 404 when retrieving a closed job.
     *
     */
    public function test_show_not_found()
    {
        $job = Job::factory()->closed()->create();
        $response = $this->get(route('job.show', ['job' => $job]), self::HEADERS);

        $response->assertNotFound();
    }

    /**
     * Create a job.
     *
     * @param array $structure
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testStoreProvider()
     */
    public function test_store(array $structure)
    {
        $job = Job::factory()->make();
        $response = $this->actingAs($this->admin, 'web')->post(route('job.store'), [
            'company_id' => $job->company_id,
            'job_title_id' => $job->job_title_id,
            'description' => $job->description,
            'status' => $job->status->key,
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure($structure)
            ->assertJson([
                'data' => [
                    'company'     => [
                        'id'      => $job->company_id,
                    ],
                    'job_title'   => [
                        'id'      => $job->job_title_id,
                    ],
                    'description' => $job->description,
                    'status'      => $job->status->key
                ]
            ]);
    }

    /**
     * Verify that only authenticated admin can store job data.
     *
     */
    public function test_store_unauthenticated()
    {
        $this->assertGuest();

        $job = Job::factory()->make();

        $response = $this->post(route('job.store'), [
            'company_id'   => $job->company_id,
            'job_title_id' => $job->job_title_id,
            'description'  => $job->description,
            'status'       => $job->status->key,
        ], self::HEADERS);

        $response->assertUnauthorized();
    }

    /**
     * Verify that it will return an invalid error if company does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyIdProvider()
     */
    public function test_store_company_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if job title does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidJobTitleIdProvider()
     */
    public function test_store_job_title_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if description does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidDescriptionProvider()
     */
    public function test_store_description_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if status does not exists.
     *
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidStatusProvider()
     */
    public function test_store_status_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it can update job.
     *
     * @param array $structure
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testStoreProvider()
     */
    public function test_update(array $structure)
    {
        $job = Job::factory()->create();
        $fake = Job::factory()->make();
        $response = $this->actingAs($this->admin, 'web')->put(route('job.update', ['job' => $job]), [
            'company_id' => $fake->company->id,
            'job_title_id' => $fake->jobTitle->id,
            'description' => $fake->description,
            'status' => $fake->status->key
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure($structure)
            ->assertJson([
                'data' => [
                    'company'     => [
                        'id'      => $fake->company->id,
                    ],
                    'job_title'   => [
                        'id'      => $fake->jobTitle->id,
                    ],
                    'description' => $fake->description,
                    'status'      => $fake->status->key
                ]
            ]);
    }

    /**
     * Verify that it will return an invalid error if company does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyIdProvider()
     */
    public function test_update_company_id_failure(array $data, array $invalidFields)
    {
        $job = Job::factory()->create();

        $this
            ->actingAs($this->admin, 'web')
            ->put(route('job.update', ['job'=>$job]), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if job title does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidJobTitleIdProvider()
     */
    public function test_update_job_title_id_failure(array $data, array $invalidFields)
    {
        $job = Job::factory()->create();
        
        $this
            ->actingAs($this->admin, 'web')
            ->put(route('job.update', ['job' => $job]), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if description does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidDescriptionProvider()
     */
    public function test_update_description_failure(array $data, array $invalidFields)
    {
        $job = Job::factory()->create();

        $this
            ->actingAs($this->admin, 'web')
            ->put(route('job.update', ['job' => $job]), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it will return an invalid error if status does not exists.
     * 
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidStatusProvider()
     */
    public function test_update_status_failure(array $data, array $invalidFields)
    {
        $job = Job::factory()->create();

        $this
            ->actingAs($this->admin, 'web')
            ->put(route('job.update', ['job' => $job]), $data, self::HEADERS)
            ->assertInvalid($invalidFields);
    }

    /**
     * Verify that it can successfully delete job.
     *
     */
    public function test_delete()
    {
        $job = Job::factory()->create();

        $this
            ->actingAs($this->admin, 'web')
            ->delete(route('job.destroy', ['job' => $job]), self::HEADERS)
            ->assertNoContent();
    }

    /**
     * Verify that it will return a 404 if job does not exists.
     * 
     * @param $params
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testDeleteNotFoundProvider()
     */
    public function test_delete_not_found(array $params)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->delete(route('job.destroy', $params), self::HEADERS)
            ->assertNotFound();
    }
}
