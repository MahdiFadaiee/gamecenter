<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('genre')->nullable();
            $table->string('platform')->nullable();
            $table->string('developer')->nullable();
            $table->string('image')->nullable();
            $table->string('summary', 500)->nullable();
            $table->longText('description')->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('tournaments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('game_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->string('status')->default('draft')->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('max_participants')->nullable();
            $table->string('prize')->nullable();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tournament_registrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('registered')->index();
            $table->unsignedInteger('placement')->nullable();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            $table->unique(['tournament_id', 'user_id']);
        });

        Schema::create('game_matches', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->string('round')->nullable();
            $table->foreignId('player_one_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('player_two_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->unsignedSmallInteger('score_one')->nullable();
            $table->unsignedSmallInteger('score_two')->nullable();
            $table->string('status')->default('scheduled')->index();
            $table->timestamps();
        });

        Schema::create('play_sessions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->index();
            $table->timestamp('ended_at')->nullable()->index();
            $table->unsignedInteger('duration_minutes')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('reward_rules', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('threshold_minutes');
            $table->unsignedInteger('reward_minutes');
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('reward_awards', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reward_rule_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('milestone');
            $table->unsignedInteger('reward_minutes');
            $table->string('status')->default('available')->index();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('redeemed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'reward_rule_id', 'milestone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_awards');
        Schema::dropIfExists('reward_rules');
        Schema::dropIfExists('play_sessions');
        Schema::dropIfExists('game_matches');
        Schema::dropIfExists('tournament_registrations');
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('games');
    }
};
