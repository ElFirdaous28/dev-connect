<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LikeNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $like;

    /**
     * Create a new notification instance.
     */
    public function __construct($like)
    {
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'=>'like',
            'like_id' => $this->like->id,
            'post_id' => $this->like->post_id,
            'user_id' => $this->like->user_id,
            'user_name' => $this->like->user->name,
            'created_at' => $this->like->created_at->toDateTimeString(),
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type'=>'like',
            'id' => $this->like->id,
            'post_id' => $this->like->post_id,
            'user_name' => $this->like->user->name,
            'user_id' => $this->like->user->id,
            'created_at' => $this->like->created_at->toDateTimeString(),
        ]);
    }

    /**
     * Determine which channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Use a private channel to ensure only authorized users can listen
        return new PrivateChannel('user.' . $this->like->post->user_id);
    }
    public function broadcastType(): string
{
    return 'like';
}
}
