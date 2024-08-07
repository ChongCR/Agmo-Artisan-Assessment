<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string $name
 * @property string $category_name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class ToDoList extends Model
{
    use HasFactory;
    protected $table = 'todolist';

    public function todolistCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ToDoListCategory::class);
    }

}
