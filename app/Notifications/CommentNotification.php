<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
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
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
            'user_id' => $this->comment->user_id,
            'content' => $this->comment->content,
            'user_name' => $this->comment->user->name,
            'created_at' => $this->comment->created_at->toDateTimeString(),
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->comment->id,
            'content' => $this->comment->content,
            'user_name' => $this->comment->user->name,
            'user_id' => $this->comment->user->id,
            'created_at' => $this->comment->created_at->toDateTimeString(),
        ]);
    }

    /**
     * Determine which channels the event should broadcast on.
     */
    /**
     * Determine which channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Use a private channel to ensure only authorized users can listen
        return new PrivateChannel('user.' . $this->comment->post->user_id);
    }
}
