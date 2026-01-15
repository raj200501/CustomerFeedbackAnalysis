<?php

namespace App\Model;

use App\Entity\Customer as CustomerEntity;
use App\Repository\CustomerRepository;

class Customer
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addCustomer(string $name, string $email): CustomerEntity
    {
        return $this->repository->create($name, $email);
    }

    public function getAllCustomers(): array
    {
        return $this->repository->all();
    }
}
