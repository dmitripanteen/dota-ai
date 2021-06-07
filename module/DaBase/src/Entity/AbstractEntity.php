<?php

namespace DaBase\Entity;

abstract class AbstractEntity
{
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function exchangeArray($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value ?? null;
        }
    }
}