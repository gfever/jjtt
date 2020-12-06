<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property DateTime $updated_at
 * @property DateTime $created_at
 */
class Article extends Model
{
    use HasFactory;
}
