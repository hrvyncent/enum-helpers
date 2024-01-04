<?php

use EnumHelpers\EnumHelpers;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

it('will throw an exception when the trait has been used be a non-enum class', function () {
    (new NonEnum)->random();
})->expectException(BadMethodCallException::class);

it('will return true if the enum is a backed enum', function () {
    assertTrue(ABackedEnum::isBackedEnum());
});

it('will return false if the enum is not a backed enum', function () {
    assertFalse(NotABackedEnum::isBackedEnum());
});

it('will get the values of a backed enum', function () {
    $values = ABackedEnum::values();
    $expected = [
        'first value',
        'second value',
        'third value'
    ];

    assertEquals($expected, $values);
});

it('will get the names of an enum', function () {
    $names = NotABackedEnum::values();
    $expected = [
        'FirstName',
        'SecondName',
        'ThirdName',
    ];

    assertEquals($expected, $names);
});

test('that the backed enum is equal to the given value', function () {
    $enum = ABackedEnum::FirstName;

    assertTrue($enum->is('first value'));
});

test('that the backed enum is not equal to the given value', function () {
    $enum = ABackedEnum::FirstName;

    assertFalse($enum->is('second value'));
});

test('that the backed enum is equal to the given name', function () {
    $enum = NotABackedEnum::FirstName;

    assertTrue($enum->is('FirstName'));
});

test('that the backed enum is not equal to the given name', function () {
    $enum = NotABackedEnum::FirstName;

    assertFalse($enum->is('SecondName'));
});

test('that the backed enum is equal to the given backed enum', function () {
    $enum = NotABackedEnum::FirstName;

    assertTrue($enum->is(NotABackedEnum::FirstName));
});

class NonEnum { use EnumHelpers; }

enum ABackedEnum : string 
{ 
    use EnumHelpers; 

    case FirstName = 'first value';
    case SecondName = 'second value';
    case ThirdName = 'third value';

}

enum NotABackedEnum 
{ 
    use EnumHelpers; 

    case FirstName;
    case SecondName;
    case ThirdName;
}