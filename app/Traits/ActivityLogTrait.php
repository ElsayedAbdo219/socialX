<?php

namespace App\Traits;

trait ActivityLogTrait
{
    public function logActivity($model, $user, $message): void
    {
        activity()
            ->performedOn($model)
            ->causedBy($user)
            ->log($message);
    }

    public function propertyLogActivity($model, $user, $message, array $property = ['key' => 'value']): void
    {
        activity()
            ->performedOn($model)
            ->causedBy($user)
            ->withProperties($property)
            ->log($message);
    }

}
