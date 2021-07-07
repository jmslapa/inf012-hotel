<?php

namespace Modules\Store\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\User;
use Modules\Store\Models\Booking;

class BookingPolicy
{
    use HandlesAuthorization;

    private $target;

    public function __construct()
    {
        $this->target = $this->getTarget();
    }

    /**
     * Verifica se o usuário tem a permissão.
     *
     * @param User $user
     * @param string $policyMethod
     * @return bool
     */
    public function checkPermission(User $user, string $policyMethod): bool
    {
        return (bool) ($user->authenticatable->role &&
            $user->authenticatable->role
            ->permissions()
            ->where('target', $this->target)
            ->where('policy_method', $policyMethod)
            ->count());
    }

    public function getTarget(): string
    {
        return Booking::class;
    }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::VIEW_ANY);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User $user
     * @return bool
     */
    public function view(User $user, Booking $booking)
    {
        if ($user->is_customer && $user->authenticatable->is($booking->customer)) {
            return true;
        }
        return $this->checkPermission($user, PolicyMethod::VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @return bool
     */
    public function update(User $user, Booking $booking)
    {
        if ($user->is_customer && $user->authenticatable->is($booking->customer)) {
            return true;
        }
        return $this->checkPermission($user, PolicyMethod::UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User $user
     * @return bool
     */
    public function restore(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::DELETE);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::DELETE);
    }

    public function addDemandable(User $user, Booking $booking)
    {
        if ($user->is_customer && $user->authenticatable->is($booking->customer)) {
            return true;
        }
        return $this->checkPermission($user, PolicyMethod::UPDATE);
    }

    public function removeDemandable(User $user, Booking $booking)
    {
        if ($user->is_customer && $user->authenticatable->is($booking->customer)) {
            return true;
        }
        return $this->checkPermission($user, PolicyMethod::UPDATE);
    }

    public function checkIn(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::UPDATE);
    }

    public function checkOut(User $user)
    {
        return $this->checkPermission($user, PolicyMethod::UPDATE);
    }
}
