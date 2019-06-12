<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string|null id_sitra1
 * @property string|null type
 * @property string|null type_detail
 * @property string|null name
 * @property string|null address
 * @property integer|null zip_code
 * @property string|null town
 * @property string|null phone
 * @property string|null fax
 * @property string|null fax_phone
 * @property string|null email
 * @property string|null website
 * @property string|null facebook
 * @property string|null rank
 * @property string|null opening_times
 * @property string|null price
 * @property float|null pricemin
 * @property float|null pricemax
 * @property string|null author
 * @property integer|null gid
 * @property \DateTime creation_date
 * @property \DateTime last_update
 * @property \DateTime last_update_fme
 * @property double latitude
 * @property double longitude
 * @method static count()
 * @method static findOrFail($id)
 */
class Poi extends Model
{
    protected $table = 'poi';
    public $incrementing = false;
    public $timestamps = false;
}