<?php

namespace App\Controller;

use App\Repository\CustomerRepository;

class CustomerController
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(): array
    {
        return $this->repository->all();
    }
}
