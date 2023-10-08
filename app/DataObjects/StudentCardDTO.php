<?php

declare(strict_types=1);

namespace App\DataObjects;

class StudentCardDTO
{
    public function __construct(
        private readonly int $user_id,
        private readonly string $school,
        private readonly ?string $description,
        private readonly MoneyDTO $canteen_price,
        private readonly bool $is_internal,
        private readonly string $date_of_birth,
    ) {
    }

    /**
     * @return array<string, int|string|bool|null>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'school' => $this->school,
            'description' => $this->description,
            'canteen_price' => $this->canteen_price->priceInCents(),
            'is_internal' => $this->is_internal,
            'date_of_birth' => $this->date_of_birth,
        ];
    }
}
