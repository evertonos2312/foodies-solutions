<?php namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $afterFind = ['escapeXSS'];

    protected function escapeXSS($data)
    {
        return esc($data);
    }
}
