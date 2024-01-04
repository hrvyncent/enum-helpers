<?php

trait EnumHelpers
{
    /**
     * Ensure that the class that using the trait is an enum.
     * 
     * @throws \BadMethodCallException
     */
    private static function assertStaticIsEnum(): void
    {
        if (!enum_exists(static::class)) {
            throw new BadMethodCallException(
                message: sprintf("The [%s] cannot be used by [%s] because it is not an enum.", __TRAIT__, static::class)
            );
        }
    }

    /**
     * Check if the enum is a `BackedEnum`.
     */
    public static function isBackedEnum(): bool
    {
        static::assertStaticIsEnum();

        return method_exists(static::class,'tryFrom');
    }

    /**
     * Check if the enum is equal to the given value
     */
    public function is(string|int|object $enum): bool
    {
        static::assertStaticIsEnum();

        if (is_object($enum)) {
            return $this === $enum;
        }

        return match (true) {
            static::isBackedEnum() => $this->value === $enum,
            !static::isBackedEnum() => $this->name === $enum,
        };
    }

    /**
     * Get a random enum
     */
    public static function random(): static
    {
        static::assertStaticIsEnum();

        $cases = static::cases();
        $index = array_rand($cases);

        return $cases[$index];
    }

    /**
     * Get the values of the enums. If the enum is not a `BackedEnum`, get the names instead.
     */
    public static function values(): array
    {
        static::assertStaticIsEnum();

        if (static::isBackedEnum()) {
            return array_column(static::cases(), 'value');
        }

        return array_column(static::cases(), 'name');
    }
}