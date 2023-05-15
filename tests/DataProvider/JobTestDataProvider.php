<?php

namespace Tests\DataProvider;
use Faker\Factory as FakerFactory;

class JobTestDataProvider
{
    protected $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

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

    public function testShowProvider(): array
    {
        return [
            [
                [
                    'data' => [
                        'id',
                        'company'     => [
                            'id',
                            'name',
                            'about',
                            'address',
                            'phone_number',
                            'created_at',
                            'updated_at',
                        ],
                        'job_title'   => [
                            'id',
                            'name',
                            'created_at',
                            'updated_at',
                        ],
                        'description',
                        'status',
                        'created_at',
                        'updated_at'
                    ]
                ],
                [
                    'data' => [
                        'id' => 1,
                    ]
                ],
            ]
        ];
    }

    public function testStoreProvider(): array
    {
        $companyId = rand(1, 100);
        $jobTitleId = rand(1, 50);
        $description = $this->faker->text();

        return [
            [
                [
                    'company_id' => $companyId,
                    'job_title_id' => $jobTitleId,
                    'description' => $description,
                    'status' => 'Open'
                ],
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
                ],
                [
                    'data' => [
                        'company'     => [
                            'id'      => $companyId,
                        ],
                        'job_title'   => [
                            'id'      => $jobTitleId,
                        ],
                        'description' => $description,
                        'status'      => 'Open'
                    ]
                ]
            ]
        ];
    }

    public function testInvalidCompanyId(): array
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

    public function testInvalidJobTitleId(): array
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

    public function testInvalidDescription(): array
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

    public function testInvalidStatus(): array
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

    public function testUpdateProvider(): array
    {
        return [
            [
                [
                    'company_id' => 124,
                    'job_title_id' => 130,
                    'description' => 'This is a description.',
                    'status' => 'Open'
                ],
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
                ],
                [
                    'data' => [
                        'company'     => [
                            'id'      => 124,
                        ],
                        'job_title'   => [
                            'id'      => 130,
                        ],
                        'description' => 'This is a description.',
                        'status'      => 'Open'
                    ]
                ]
            ]
        ];
    }

    public function testDeleteNotFound(): array
    {
        return [
            [
                ['job'=>99999999],
            ]
        ];
    }
}
