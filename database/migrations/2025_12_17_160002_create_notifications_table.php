<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Rename table lama
        Schema::rename('notifications', 'notifications_old');

        // 2. Create table notifications baru
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('type', 100);
            $table->string('title')->nullable();
            $table->text('message');
            $table->string('redirect_url', 255)->nullable();

            $table->timestamps();

            $table->index('type');
            $table->index('created_at');
        });

        // 3. Create table notification_receivers
        Schema::create('notification_receivers', function (Blueprint $table) {
            $table->id();

            $table->uuid('notification_id');
            $table->unsignedBigInteger('user_id');

            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->foreign('notification_id')
                ->references('id')
                ->on('notifications')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique(['notification_id', 'user_id']);
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });

        // 4. Migrate data lama
        DB::transaction(function () {
            $oldNotifications = DB::table('notifications_old')->get();

            foreach ($oldNotifications as $old) {
                // Insert ke notifications
                DB::table('notifications')->insert([
                    'id' => $old->id,
                    'type' => $old->type,
                    'title' => $old->title,
                    'message' => $old->message,
                    'redirect_url' => $old->redirect_url,
                    'created_at' => $old->created_at,
                    'updated_at' => $old->updated_at,
                ]);

                // Insert ke notification_receivers
                DB::table('notification_receivers')->insert([
                    'notification_id' => $old->id,
                    'user_id' => $old->notifiable_id,
                    'is_read' => (bool) $old->is_read,
                    'read_at' => $old->read_at,
                    'created_at' => $old->created_at,
                    'updated_at' => $old->updated_at,
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_receivers');
        Schema::dropIfExists('notifications');

        Schema::rename('notifications_old', 'notifications');
    }
};
