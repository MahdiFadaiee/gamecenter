<?php

namespace App\Services;

use App\Models\RewardAward;
use App\Models\RewardRule;
use App\Models\User;

class PlaytimeRewardService
{
    public function issueEligibleAwards(User $user): int
    {
        $totalMinutes = $user->playedMinutes();
        $issued = 0;

        foreach (RewardRule::query()->where('active', true)->get() as $rule) {
            if ($rule->threshold_minutes < 1) {
                continue;
            }

            $milestones = intdiv($totalMinutes, $rule->threshold_minutes);

            for ($milestone = 1; $milestone <= $milestones; $milestone++) {
                $inserted = RewardAward::query()->insertOrIgnore([
                    'user_id' => $user->id,
                    'reward_rule_id' => $rule->id,
                    'milestone' => $milestone,
                    'reward_minutes' => $rule->reward_minutes,
                    'status' => 'available',
                    'issued_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $issued += $inserted;
            }
        }

        return $issued;
    }
}
