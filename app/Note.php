<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Note.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note query()
 * @mixin \Eloquent
 *
 * @property int    $id
 * @property string $source
 * @property string $html
 * @property string $createdAt
 * @property string $updatedAt
 * @property int    $archived
 * @property string $title
 * @property string $short
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Note whereUpdatedAt($value)
 */
class Note extends Model
{
}
