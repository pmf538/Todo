<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ValidateOrder extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $validatedCount = 0;
        $failedCount = 0;

        foreach ($models as $order) {
            if ($order->status === 'pending') {
                if ($order->validate()) {
                    $validatedCount++;
                } else {
                    $failedCount++;
                }
            }
        }

        if ($validatedCount > 0) {
            return Action::message("{$validatedCount} commande(s) validée(s) avec succès.");
        }

        if ($failedCount > 0) {
            return Action::danger("Impossible de valider {$failedCount} commande(s). Vérifiez les stocks.");
        }

        return Action::danger('Aucune commande en attente à valider.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Valider la commande';

    /**
     * Indicates if this action is only available on the resource index view.
     *
     * @var bool
     */
    public $onlyOnIndex = false;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;
} 