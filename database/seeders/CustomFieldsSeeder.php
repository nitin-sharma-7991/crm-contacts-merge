<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomField;

class CustomFieldsSeeder extends Seeder
{
    public function run()
    {
        $fields = [
            ['name' => 'Birthday', 'type' => 'date'],
            ['name' => 'Company Name', 'type' => 'text'],
            ['name' => 'Address', 'type' => 'textarea'],
            ['name' => 'Favorite Color', 'type' => 'text'],
        ];

        foreach ($fields as $field) {
            CustomField::updateOrCreate(
                ['name' => $field['name']],
                ['type' => $field['type']]
            );
        }
    }
}
