<?php

/**
 * Open Solutions' ViMbAdmin Project.
 *
 * This file is part of Open Solutions' ViMbAdmin Project which is a
 * project which provides an easily manageable web based virtual
 * mailbox administration system.
 *
 * Copyright (c) 2011 - 2014 Open Source Solutions Limited
 *
 * ViMbAdmin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ViMbAdmin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ViMbAdmin.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Open Source Solutions Limited T/A Open Solutions
 *   147 Stepaside Park, Stepaside, Dublin 18, Ireland.
 *   Barry O'Donovan <barry _at_ opensolutions.ie>
 *
 * @copyright Copyright (c) 2011 - 2014 Open Source Solutions Limited
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 (GPLv3)
 * @author Open Source Solutions Limited <info _at_ opensolutions.ie>
 * @author Barry O'Donovan <barry _at_ opensolutions.ie>
 * @author Roland Huszti <roland _at_ opensolutions.ie>
 * @package ViMbAdmin
 */

/**
 * The log controller.
 *
 * @package ViMbAdmin
 * @subpackage Controllers
 */
class LogController extends ViMbAdmin_Controller_Action
{

    /**
     * If the parameter 'admin' is present then populates $this->_targetAdmin.
     * If parameter 'domain' is present then populates $this->_domain.
     * Also does authentication.
     *
     * @see Zend_Controller_Action::preDispatch()
     */
    public function preDispatch()
    {
        if( !$this->getTargetAdmin() && !$this->getAdmin()->isSuper() )
            $this->_targetAdmin = $this->getAdmin();

        if( $this->getParam( 'unset', false ) )
            unset( $this->getSessionNamespace()->domain );
        else
        {
            if( isset( $this->getSessionNamespace()->domain ) && $this->getSessionNamespace()->domain )
                $this->_domain = $this->getSessionNamespace()->domain;
            else if( $this->getDomain() )
                $this->getSessionNamespace()->domain = $this->getDomain();
        }
    }


    /**
     * Jumps to list action.
     */
    public function indexAction()
    {
        $this->forward( 'list' );
    }


    /**
     * Lists log entries. If $this->_targetAdmin is present then limits the listing to that admin, if $this->_domain
     * is present then limits the listing to that domain. Can use both limitation at the same time.
     */
    public function listAction()
    {
        $this->view->logs = $this->getD2EM()->getRepository( "\\Entities\\Log" )->loadForLogList( $this->getTargetAdmin(), $this->getDomain() );
    }

}
