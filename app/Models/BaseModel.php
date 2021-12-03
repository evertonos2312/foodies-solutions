<?php namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $afterFind = ['escapeXSS'];
    protected $beforeInsert = ['escapeXSS'];
    protected $beforeUpdate = ['escapeXSS'];

    protected function escapeXSS($data)
    {
        return esc($data);
    }

    protected function criaSlug(array $data)
    {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', true);
        }
        return $data;
    }

    protected function corrigeValor($data): array
    {
        if (!isset($data['data']['preco'])) {
            return $data;
        }
        $data['data']['preco'] = str_replace('.', '', $data['data']['preco']);
        $data['data']['preco'] = str_replace(',', '.', $data['data']['preco']);
        return $data;
    }


}
