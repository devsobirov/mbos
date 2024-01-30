<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * For usage on observers while logging
 *
 * Trait HasLoggableUpdates
 * @package App\Traits
 */
trait HasLoggableUpdates
{
    protected function logEvent($event, $model, $type, $saveModified = false)
    {
        $logData = [
            'event' => $event,
            'message' => $saveModified ? $this->formatChangesToString($model) : null,
            'log_type' => $type,
            'group_type' => $this->groupType,
            'user_id' => auth()->id(),
        ];

        \App\Models\Log::create($logData);
        Log::info($this->groupName. ' event logged', $logData);
    }

    public function formatChangesToString($model): string
    {
        $formattedChanges = [];

        if ($model && $model instanceof Model) {
            foreach ($model->getChanges() as $field => $value) {
                if (!in_array($field, ['created_at', 'updated_at', 'deleted_at'])) {
                    $oldValue = $this->stringifyValue($model->getOriginal($field));
                    $newValue = $this->stringifyValue($model->$field);
                    $formattedChanges[] = "$field ($oldValue - $newValue)";
                }
            }
        }

        return implode(', ', $formattedChanges);
    }

    private function stringifyValue($value): string
    {
        return (is_object($value) || is_array($value))
            ? json_encode($value)
            : (string) $value;
    }
}
