<?php
BAV_Autoloader::add('../BAV_Agency.php');


/**
 * Copyright (C) 2006  Markus Malkusch <bav@malkusch.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *
 * @package classes
 * @subpackage dataBackend
 * @author Markus Malkusch <bav@malkusch.de>
 * @copyright Copyright (C) 2006 Markus Malkusch
 */
class BAV_AgencyException extends RuntimeException {


    private
    /**
     * @var BAV_Agency
     */
    $agency;
    
    
    public function __construct(BAV_Agency $agency) {
        $this->agency = $agency;
    }
    /**
     * @return BAV_Agency
     */
    public function getAgency() {
        return $this->agency;
    }


}


?>