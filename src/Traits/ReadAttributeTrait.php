<?php

namespace DeathSatan\SatanExcel\Traits;

trait ReadAttributeTrait
{
    /**
     * @param array $data
     * @return array
     */
    protected function handleProperty(array $data): array
    {
        foreach ($data as $key => $propertyAttributes)
        {
            foreach ($propertyAttributes as $property)
            {

            }
        }
        return $data;
    }

    protected function handle(array $excel): array
    {

    }
}