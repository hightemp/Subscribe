<?php
/**
     * Subscribe
     * Copyright 2012 Bob Ray <http://bobsguides/com>
     *
     * Subscribe is free software; you can redistribute it and/or modify it
     * under the terms of the GNU General Public License as published by the Free
     * Software Foundation; either version 2 of the License, or (at your option) any
     * later version.
     *
     * Subscribe is distributed in the hope that it will be useful, but WITHOUT ANY
     * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
     * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along with
     * Subscribe; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
     * Suite 330, Boston, MA 02111-1307 USA
     *
     * @package subscribe
     * @author Bob Ray <http://bobsguides/com>
     *
     * @version Version 1.0.0 Beta-1
     * 3/3/12
     *
     * @Description Display request to subscribe unless user is admin or logged in */


    /**
     *  @version Version 1.0.0 Beta-1
     *  @package subscribe
     */


/* Display request to subscribe unless user is admin or logged in */
/* @var $modx modX */ 
/* @var $scriptProperties array */

  $sp =& $scriptProperties;
  $noShows = array($sp['loginPageId']);
  $noShows = array_merge($noShows,explode(',', $sp['noShow']));


/* don't show subscribe request if user is logged in or
 * current page is in noShow list
*/

$docId = $modx->resource->get('id');

/* Show Logout button if we're not showing the subscribe 
 * request and user is logged in */
$loggedIn = $modx->user->hasSessionContext($modx->context->get('key'));
if ($loggedIn || in_array($docId,$noShows) ) {

    if ($loggedIn) {
        $modx->regClientCSS(MODX_ASSETS_URL . 'components/subscribe/css/subscribe.css');
        $url = $modx->makeUrl($sp['loginPageId'],"","service=logout","full");
        $managePrefsUrl = $modx->makeUrl($sp['ManagePrefsPageId'],"","","full");
        $output =  $modx->getChunk('SmLogoutLink', array('logoutUrl' => $url));
        $output .= $modx->getChunk('SmManagePrefsLink', array('managePrefsUrl' => $managePrefsUrl));
        return $output;
    } else {
        /* <br /> maintains page layout. Change to '' if necessary for your layout */
        return '<br />';
    }

} else {
   /* Load CSS and JS, and show the subscribe request */

    $modx->regClientCSS(MODX_ASSETS_URL . 'components/subscribe/css/subscribe.css');

    $fields = array();
    $fields['registerPageId'] = $sp['registerPageId'];
    $fields['loginPageId'] = $scriptProperties['loginPageId'];

    return $modx->getChunk('SmSubscribe', $fields) ;
}