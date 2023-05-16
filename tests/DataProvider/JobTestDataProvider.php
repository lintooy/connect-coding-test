<?php

namespace Tests\DataProvider;
use Faker\Factory as FakerFactory;

class JobTestDataProvider
{
    protected $faker;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    /**
     * Data for index test
     *
     * @return array
     */
    public function testIndexProvider(): array
    {
        return [
            [
                [
                    'per_page' => 12,
                    'page' => 1,
                ],
                [
                    'meta' => [
                        'per_page' => 12,
                        'current_page' => 1,
                        'total' => 25,
                    ],
                ]
            ]
        ];
    }

    /**
     * Data for store test
     *
     * @return array
     */
    public function testStoreProvider(): array
    {
        return [
            [
                [
                    'data' => [
                        'id',
                        'company' => [
                            'id',
                            'name',
                            'about',
                            'address',
                            'phone_number',
                            'created_at',
                            'updated_at'
                        ],
                        'job_title' => [
                            'id',
                            'name',
                            'created_at',
                            'updated_at'
                        ],
                        'description',
                        'status',
                        'created_at',
                        'updated_at'
                    ],
                ]
            ]
        ];
    }

    /**
     * Data for invalid company id test
     *
     * @return array
     */
    public function testInvalidCompanyIdProvider(): array
    {
        return [
            [
                ['company_id' => null],
                ['company_id']
            ],
            [
                ['company_id' => 99999999],
                ['company_id'],
            ]
        ];
    }

    /**
     * Data for invalid job title id test
     *
     * @return array
     */
    public function testInvalidJobTitleIdProvider(): array
    {
        return [
            [
                ['job_title_id' => null],
                ['job_title_id']
            ],
            [
                ['job_title_id' => 99999999],
                ['job_title_id'],
            ]
        ];
    }

    /**
     * Data for invalid description test
     *
     * @return array
     */
    public function testInvalidDescriptionProvider(): array
    {
        return [
            [
                ['description' => null],
                ['description']
            ],
            [
                ['description' => $this->faker->realTextBetween(20001, 20100)],
                ['description'],
            ]
        ];
    }

    /**
     * Data for invalid status test
     *
     * @return array
     */
    public function testInvalidStatusProvider(): array
    {
        return [
            [
                ['status' => null],
                ['status']
            ],
            [
                ['status' => 'Scheduled'],
                ['status'],
            ]
        ];
    }

    /**
     * Data for update test
     *
     * @return array
     */
    public function testUpdateProvider(): array
    {
        return [
            [
                [
                    'data' => [
                        'id',
                        'company' => [
                            'id',
                            'name',
                            'about',
                            'address',
                            'phone_number',
                            'created_at',
                            'updated_at'
                        ],
                        'job_title' => [
                            'id',
                            'name',
                            'created_at',
                            'updated_at'
                        ],
                        'description',
                        'status',
                        'created_at',
                        'updated_at'
                    ],
                ]
            ]
        ];
    }

    /**
     * Data for delete not found test
     *
     * @return array
     */
    public function testDeleteNotFoundProvider(): array
    {
        return [
            [
                ['job'=>99999999],
            ]
        ];
    }
}
