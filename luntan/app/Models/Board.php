<?php
/**
 * Date: 2019-12-20
 * Time: 15:47
 */
namespace App\Models;


use App\Container;
use Moon\Db\Table;

/**
 * Class Board
 * @property int $id
 * @property string $subject
 * @property string $author
 * @property string $body
 * @property string $idate
 * @property string $ndate
 * @property int $replise
 * @property string $ip
 * @package App\Models
 */
class Board extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return 'board';
    }

    public static function getDb()
    {
        return Container::get('db');
    }

}