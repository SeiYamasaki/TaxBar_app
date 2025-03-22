<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        // ユーザー自身の予約か、税理士が関連付けられた予約のみ閲覧可能
        return $user->id === $booking->user_id ||
            ($user->is_tax_accountant && $user->taxAdvisor && $user->taxAdvisor->id === $booking->tax_advisor_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        // ユーザー自身の予約か、税理士が関連付けられた予約のみ更新可能
        return $user->id === $booking->user_id ||
            ($user->is_tax_accountant && $user->taxAdvisor && $user->taxAdvisor->id === $booking->tax_advisor_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        // ユーザー自身の予約か、税理士が関連付けられた予約のみ削除可能
        return $user->id === $booking->user_id ||
            ($user->is_tax_accountant && $user->taxAdvisor && $user->taxAdvisor->id === $booking->tax_advisor_id);
    }
}
