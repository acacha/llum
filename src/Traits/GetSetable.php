<?php

namespace Acacha\Llum\Traits;

/**
 * Class GetSetable.
 */
trait GetSetable
{
    /**
     * Get/set a field.
     *
     * @param string $field
     * @param mixed  $fieldValue
     *
     * @return $this|string
     */
    private function getterSetter($field, $fieldValue)
    {
        if ($fieldValue == null) {
            return $this->$field;
        }

        $this->$field = $fieldValue;

        return $this;
    }
}
