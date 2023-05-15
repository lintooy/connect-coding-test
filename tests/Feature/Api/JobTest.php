<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Job;
use Tests\TestCase;

class JobTest extends TestCase
{
    private $admin;

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
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testIndexProvider()
     */
    public function test_index(array $params, array $expected)
    {
        $response = $this->get(route('job.index', $params));

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
        $response = $this->get(route('job.show', ['job' => $job]));

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
        $response = $this->get(route('job.show', ['job' => $job]));

        $response->assertNotFound();
    }

    /**
     * test_store
     *
     * @param array $data
     * @param array $structure
     * @param array $expected
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testStoreProvider()
     */
    public function test_store(array $data, array $structure, array $expected)
    {
        // print_r($data);
        $response = $this->actingAs($this->admin, 'web')->post(route('job.store'), $data);

        $response
            ->assertCreated()
            ->assertJsonStructure($structure)
            ->assertJson($expected);
    }

    // public function test_create_unauthenticated()
    // {
    //     $this->assertGuest();

    //     $job = Job::factory()->make();
    //     $response = $this->json('POST', route('job.store'), [
    //         'company_id' => $job->company_id,
    //         'job_title_id' => $job->job_title_id,
    //         'description' => $job->description,
    //         'status' => $job->status->key,
    //     ]);

    //     $response->assertUnauthorized();
    // }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyId()
     */
    public function test_create_company_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

     /**
     * Return an invalid error if job title does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyId()
     */
    public function test_create_job_title_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidDescription()
     */
    public function test_create_description_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidStatus()
     */
    public function test_create_status_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    /**
     * test_update
     *
     * @param array $data
     * @param array $structure
     * @param array $expected
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testStoreProvider()
     */
    public function test_update(array $data,array $structure, array $expected)
    {
        $job = Job::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->put(route('job.update', ['job' => $job]), $data);

        $response
            ->assertOk()
            ->assertJsonStructure($structure)
            ->assertJson($expected);
    }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyId()
     */
    public function test_update_company_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

     /**
     * Return an invalid error if job title does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidCompanyId()
     */
    public function test_update_job_title_id_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidDescription()
     */
    public function test_update_description_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    /**
     * Return an invalid error if company does not exists.
     * @param $data
     * @param $invalidFields
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testInvalidStatus()
     */
    public function test_update_status_failure(array $data, array $invalidFields)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->post(route('job.store'), $data)
            ->assertInvalid($invalidFields);
    }

    public function test_delete()
    {
        $job = Job::factory()->create();
        $this
            ->actingAs($this->admin, 'web')
            ->delete(route('job.destroy', ['job' => $job]))
            ->assertNoContent();
    }

    /**
     * 
     * @param $params
     * 
     * @dataProvider Tests\DataProvider\JobTestDataProvider::testDeleteNotFound()
     */
    public function test_delete_not_found(array $params)
    {
        $this
            ->actingAs($this->admin, 'web')
            ->delete(route('job.destroy', $params))
            ->assertNotFound();
    }
}
