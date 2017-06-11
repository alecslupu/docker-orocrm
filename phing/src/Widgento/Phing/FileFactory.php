<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 6/7/17
 * Time: 8:38 PM
 */

namespace Widgento\Phing;

use SplFileObject;

class FileFactory
{
    /**
     * @param string $path
     * @return SplFileObject
     */
    public static function create($path)
    {
        return new SplFileObject($path);
    }
}