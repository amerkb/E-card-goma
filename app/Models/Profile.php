<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'theme_id', 'firstName', 'lastName', 'phoneNum',
        'about', 'location', 'cover', 'photo', 'bgColor','email'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function views()
    {
        return $this->hasMany(View::class, 'profile_id', 'user_id');
    }

    public function count_views($start, $end)
    {
        return $this->views()->whereBetween('created_at', [$start, $end.' 23:59:59'])->count();
    }

    public function setCoverAttribute($cover)
    {
        if ($cover == null || $cover == 'NULL' || $cover == 'null' || $cover == 'Null') {
            return $this->attributes['cover'] = null;
        } else {
            $newCoverName = uniqid().'_'.'cover'.'.'.$cover->extension();
            $cover->move(public_path('images/user/'), $newCoverName);

            return $this->attributes['cover'] = '/images/user/'.$newCoverName;
        }
    }

    public function setPhotoAttribute($photo)
    {

        $newPhotoName = uniqid().'_'.'photo'.'.'.$photo->extension();
        $photo->move(public_path('images/user/'), $newPhotoName);

        return $this->attributes['photo'] = '/images/user/'.$newPhotoName;

    }

    public function countViewByAddress($user_id)
    {
        return View::countByAddress($user_id)->get();
    }
}
