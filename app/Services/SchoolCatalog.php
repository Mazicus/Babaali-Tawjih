<?php
namespace App\Services;
class SchoolCatalog
{
    public function schools(): array { return json_decode(file_get_contents(public_path('data/schools.json')), true, 512, JSON_THROW_ON_ERROR); }
    public function sectors(): array { return json_decode(file_get_contents(public_path('data/sectors.json')), true, 512, JSON_THROW_ON_ERROR); }
    public function contains(int $id): bool { return in_array($id, array_column($this->schools(), 'id'), true); }
    public function saved(array $ids): array { return array_values(array_filter($this->schools(), fn($school)=>in_array($school['id'],$ids,true))); }
}
