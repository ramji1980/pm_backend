<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Project Created')
            ->line('A new project titled "' . $this->project->title . '" has been created.')
            ->action('View Project', url('/projects/' . $this->project->id))
            ->line('Thank you for using our system!');
    }

    public function toArray($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'title' => $this->project->title,
        ];
    }
}
