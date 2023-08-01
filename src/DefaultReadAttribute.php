<?php

namespace DeathSatan\SatanExcel;

use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;

class DefaultReadAttribute implements Contacts\ReadAttributeContact
{

    public function getAttributeExcelProperty(string $class, string $attribute): array
    {
        $data = [];
        $ref = new \ReflectionClass($class);
        $properties = $ref->getProperties();
        foreach ($properties as $property)
        {
            $attributes = $property->getAttributes($attribute);
            foreach ($attributes as $item)
            {
                /**
                 * @var \ReflectionAttribute $item
                 */
                /** @var ExcelPropertyContact $model */
                $model = $item->newInstance();
                $data[$property->getName()] = $model;
            }
        }
        array_multisort($data,SORT_ASC, array_column($data,'index'));
        array_multisort($data,SORT_DESC, array_column($data,'order'));

        return $data;
    }

    public function getAttributeExcelData(string $class, string $attribute): array
    {
        $data = [];
        $ref = new \ReflectionClass($class);
        $attributes = $ref->getAttributes($attribute);
        foreach ($attributes as $item)
        {
            /** @var \ReflectionAttribute $item */
            $data[] = $item->newInstance();
        }
        return $data;
    }
}