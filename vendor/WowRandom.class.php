<?php
/**
 * Wow Random
 *
 * @author yftzeng <yftzeng@gmail.com>
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

/**
 * WowRandom class
 *
 * @package org.twbbs.antbsd.wowsecmodules
 */
class WowRandom
{
    /**
     * Generator function
     * @param string $type generate type
     * @param int $len return length of generator
     * @var string
     */
    static function generator($type, $len = 6)
    {
        if ($type === 'numeric') {
            $characters = '0123456789';
        }
        else if ($type === 'alphanumeric') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        }
        else if ($type === 'alphanumeric-capital') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        else {
            throw new Exception('Invalid generate type');
        }

        $char_len = strlen($characters) - 1;
        $random = ''; 
        for ($p = 0; $p < $len; $p++) {
            $random .= $characters[mt_rand(0, $char_len)];
        }   
        return $random;
    }
}

//echo WowRandom::generator(numeric, 10);
?>
