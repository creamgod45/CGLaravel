<?php

namespace App\Models;

use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 *
 * @method static Builder|static query()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method Animal firstOrNew(array $attributes = [], array $values = [])
 * @method Animal firstOrFail($columns = ['*'])
 * @method Animal firstOrCreate(array $attributes, array $values = [])
 * @method Animal firstOr($columns = ['*'], \Closure $callback = null)
 * @method Animal firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method Animal updateOrCreate(array $attributes, array $values = [])
 * @method null|static first($columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static findOrNew($id, $columns = ['*'])
 * @method static null|static find($id, $columns = ['*'])
 *
 * @property-read int $id
 *
 * @property int $type_id
 * @property string $name
 * @property Date $birthday
 * @property string $area
 * @property boolean $fix
 * @property string $description
 * @property string $personality
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Animal extends Model
{
    use HasFactory;
    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'name',
        'birthday',
        'area',
        'fix',
        'description',
        'personality',
    ];
}
