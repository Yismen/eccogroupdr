<?php

namespace App\Http\Livewire\Traits;

use Flasher\Prime\Notification\Envelope;

/**
 * Add the capacity to handle sweet alert confirmation before performing certain actions.
 */
trait HasConfirmation
{
    public function sweetalertConfirmed(array $payload)
    {
        $method = $payload['envelope']['notification']['options']['confirmation_method'];

        $this->$method();
    }

    /**
     * Show a confirmation modal.
     *
     * @param  string                               $confirmation_method
     * @param  string                               $message
     * @return \Flasher\Prime\Notification\Envelope
     */
    public function confirm(string $confirmation_method, string|null $message = 'Are you sure?'): Envelope
    {
        return sweetalert()
            ->showDenyButton(
                $showDenyButton = true,
                $denyButtonText = 'No',
                $denyButtonColor = null,
                $denyButtonAriaLabel = null
            )
            ->timer(0)
            ->option('confirmation_method', str($confirmation_method))
        ->addInfo($message);
    }

    public function flash(string $message, string $type = 'success', array $options = [])
    {
        return flasher($message, $type, $options);
    }

    protected function getListeners()
    {
        return  array_merge(
            $this->listeners,
            ['sweetalertConfirmed']
        );
    }
}
