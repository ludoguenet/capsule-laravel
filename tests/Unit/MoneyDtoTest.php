<?php

declare(strict_types=1);

it('can convert from float', function () {
    $dto = new \App\DataObjects\MoneyDTO(floatval(18.50));

    expect($dto->priceInCents())->toEqual(1850);
});

it('can not accept a negative amount', function () {
    new \App\DataObjects\MoneyDTO(floatval(-18.50));
})
    ->throws(InvalidArgumentException::class);
